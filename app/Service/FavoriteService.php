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
     * @param int $id
     * @return void
     */
    public function buildDelete($id)
    {
        return $this->repository->delete($id);
    }
}
