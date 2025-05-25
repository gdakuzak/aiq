<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FakeStoreService
{
    private $cacheTime = 1800; // 30 minutes

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
        if (env('CACHE_PRODUCTS') == true && Cache::has("product_" . $id)) {
            return Cache::get("product_" . $id);
        }

        $response = Http::get(config('app.fake_store_api') . "/products/{$id}");
        if (!$response->successful()) {
            return new Exception("Error access /products/id", 500);
        }

        if (empty($response->json())) {
            throw new \Exception('Product not found', 400);
        }

        if (env('CACHE_PRODUCTS') == true && Cache::has("product_" . $id)) {
            Cache::put("product_" . $id, $response->json(), $this->cacheTime);
        }

        return $response->json();
    }
}
