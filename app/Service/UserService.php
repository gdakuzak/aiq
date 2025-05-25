<?php

namespace App\Service;

use App\Repositories\UserRepository;

class UserService
{
    private $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
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
        // @todo: deletar tokens existentes.
        // @todo: procurar todos os favoritos e deletar antes de deletar o usuario.
        return $this->repository->delete($id);
    }
}
