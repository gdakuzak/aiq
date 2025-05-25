<?php

namespace App\Service;

use Illuminate\Support\Facades\Cache;
use App\Repositories\FavoriteRepository;

class FavoriteService
{
    private $repository;

    private $fakeStoreService;

    public function __construct(FavoriteRepository $favoriteRepository, FakeStoreService $fakeStoreService)
    {
        $this->repository = $favoriteRepository;
        $this->fakeStoreService = $fakeStoreService;
    }

    /**
     * Return all data from table.
     *
     * @return mixed
     */
    public function renderList()
    {
        return $this->repository->getAll();
    }

    /**
     * Return specific data from table.
     *
     * @return mixed
     */
    public function renderEdit($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Return specific data from table.
     *
     * @param int $product_id
     * @param int $user_id
     * 
     * @return mixed
     */
    public function renderByProductAndUser(int $product_id, int $user_id)
    {
        return $this->repository->getByProductIdAndUserId($product_id, $user_id);
    }

    /**
     * Insert data.
     *
     * @param array $data
     * 
     * @return mixed
     */
    public function buildInsert(array $data)
    {
        // Check if product exists in the fake store API
        $this->fakeStoreService->getProductById($data['product_id']);
        
        return $this->repository->create($data);
    }

    /**
     * Update data.
     *
     * @param int $id
     * @param array $data
     * @return void
     */
    public function buildUpdate(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete data.
     *
     * @param array $request
     * @return void
     */
    public function buildDelete(array $request)
    {
        $fav = $this->renderByProductAndUser($request['product_id'], $request['user_id']);
        return $this->repository->delete($fav->id);
    }
}
