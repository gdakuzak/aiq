<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Facades\Http;

class FakeStoreService
{

    /**
     * Get all products from Fake Store API.
     *
     * @return void
     */
    public function getAllProducts(): mixed
    {
        $response = Http::get(config('app.fake_store_api') . '/products');
        if (!$response->successful()) {
            return new Exception("Error access /products", 500);
        }

        return $response->json();
    }

    /**
     * Get specific product from Fake Store API.
     *
     * @param int $id
     * @return mixed
     */
    public function getProductById(int $id): mixed
    {
        $response = Http::get(config('app.fake_store_api') . "/products/{$id}");
        if (!$response->successful()) {
            return new Exception("Error access /products/id", 500);
        }

        return $response->json();
    }
}
