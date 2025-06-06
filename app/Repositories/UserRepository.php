<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @var Role
     */
    private $model;

    /**
     * User Repository constructor.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->get();
    }

    /**
     * @param  int  $id
     * @return mixed
     */
    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * 
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        return $this->model->find($id)->fill($data)->save();
    }

    /**
     * @param int $id
     * 
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->model->find($id)->delete();
    }
}