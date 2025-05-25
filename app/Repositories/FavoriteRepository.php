<?php

namespace App\Repositories;

use App\Models\Favorite;

class FavoriteRepository
{
    /**
     * @var Role
     */
    private $model;

    /**
     * User Repository constructor.
     */
    public function __construct(Favorite $favorite)
    {
        $this->model = $favorite;
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
     * @param  int  $id
     * @return mixed
     */
    public function getByUserId(int $user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    /**
     * @param int $product_id
     * @param int $user_id
     * 
     * @return mixed
     */
    public function getByProductIdAndUserId(int $product_id, int $user_id)
    {
        return $this->model->where('product_id', $product_id)->where('user_id', $user_id)->first();
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
