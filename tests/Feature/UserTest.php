<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $act = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'teste@umteste.com.br',
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($act);

        \App\Models\User::factory()->create([
            'name' => $this->faker->name(),
            'email' => Str::random(2) . $this->faker->safeEmail(),
            'password' => bcrypt(Str::random(10)),
        ]);

        $this->withoutExceptionHandling();
    }

    public function test_if_registration_works(): void
    {
        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'status',
                'token'
            ]);
    }

    public function test_if_login_works(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'teste@umteste.com.br',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'token'
            ]);
    }

    public function test_if_user_can_be_fetched(): void
    {
        $response = $this->getJson(route('users.index'));
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'email',
                ]
            ]);

        $response = $this->getJson(route('users.show', ['user' => 2]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    public function test_if_user_can_be_updated(): void
    {
        $response = $this->putJson(route('users.update', ['user' => 2]), [
            'name' => 'Updated User',
        ]);
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
            ]);
        
        $this->assertDatabaseHas('users', [
            'id' => 2,
            'name' => 'Updated User',
        ]);
    }

    public function test_if_user_can_be_deleted(): void
    {
        $response = $this->deleteJson(route('users.destroy', ['user' => 2]));
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
            ]);
        
        $this->assertDatabaseMissing('users', [
            'id' => 2,
        ]);
    }
}
