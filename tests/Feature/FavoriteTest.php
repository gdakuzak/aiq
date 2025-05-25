<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    protected $mockOne = [
        "id" => 1,
        "title" => "Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops",
        "price" => 109.95,
        "description" => "Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday",
        "category" => "men's clothing",
        "image" => "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg",
        "rating" => [
            "rate" => 3.9,
            "count" => 120
        ]
    ];

    protected $mockMulti = [
        [
            "id" => 1,
            "title" => "Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops",
            "price" => 109.95,
            "description" => "Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday",
            "category" => "men's clothing",
            "image" => "https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg",
            "rating" => [
                "rate" => 3.9,
                "count" => 120
            ]
        ],
        [
            "id" => 2,
            "title" => "Mens Casual Premium Slim Fit T-Shirts ",
            "price" => 22.3,
            "description" => "Slim-fitting style, contrast raglan long sleeve, three-button henley placket, light weight & soft fabric for breathable and comfortable wearing. And Solid stitched shirts with round neck made for durability and a great fit for casual fashion wear and diehard baseball fans. The Henley style round neckline includes a three-button placket.",
            "category" => "men's clothing",
            "image" => "https://fakestoreapi.com/img/71-3HjGNDUL._AC_SY879._SX._UX._SY._UY_.jpg",
            "rating" => [
                "rate" => 4.1,
                "count" => 259
            ]
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();

        $act = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'teste@umteste.com.br',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($act);
        $this->withoutExceptionHandling();

        Http::fake([
            env('FAKE_STORE_URL') . '/products' => Http::response($this->mockMulti, 200),
            env('FAKE_STORE_URL') . '/products/1' => Http::response($this->mockOne, 200),
        ]);
    }

    public function test_user_can_favorite_a_product()
    {
        $response = $this->post(route('favorite.store'), [
            'product_id' => 1,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('favorites', [
            'user_id' => Auth::id(),
            'product_id' => 1,
        ]);
    }

    public function test_user_can_unfavorite_a_product()
    {
        $this->post(route('favorite.store'), [
            'product_id' => 1,
        ]);

        $response = $this->delete(route('favorite.destroy', ['product_id' => 1]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => Auth::id(),
            'product_id' => 1,
        ]);
    }

    public function test_user_can_get_favorite_products()
    {
        $this->post(route('favorite.store'), [
            'product_id' => 1,
        ]);

        $response = $this->get(route('favorite.show'));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => 1,
            'title' => 'Fjallraven - Foldsack No. 1 Backpack, Fits 15 Laptops',
            'price' => 109.95,
            'description' => 'Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday',
        ]);
    }
}
