<?php

namespace RSolution\RCms\Repositories;

use Illuminate\Http\Request;

abstract class EloquentRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Get first
     * @param $id
     * @return mixed
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return true;
        }

        return false;
    }

    /**
     * Paginate
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginate(int $limit = 10)
    {
        return $this->model->latest()->paginate($limit);
    }

    /**
     * Update fillable
     * @param int $id
     * @param Request $request
     * @return bool|mixed
     */
    public function updateFillable(int $id, Request $request)
    {
        return $this->update($id, $request->only($this->model->getFillable()));
    }

    /**
     * Bulk Delete
     *
     * @param array $id
     * @return mixed
     */
    public function bulkDelete(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    /**
     * Bulk Insert
     *
     * @param array $data
     * @return mixed
     */
    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    /**
     * Bulk Update
     *
     * @param array $data
     * @return mixed
     */
    public function bulkUpdate(array $ids, $attributes)
    {
        $this->model->whereIn('id', $ids)->update($attributes);
    }


    /**
     * Get by user ID
     *
     * @param integer $userId
     * @return mixed
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)->select()->latest()->get();
    }

    /**
     * Bulk Delete by user Id
     *
     * @param integer $userId
     * @param array $ids
     * @return mixed
     */
    public function bulkDeleteByUser(int $userId, array $ids)
    {
        return $this->model->where('user_id', $userId)->whereIn('id', $ids)->delete();
    }

    /**
     * Find by user id
     *
     * @param integer $userId
     * @param integer $id
     * @return mixed
     */
    public function findByUserId(int $userId, int $id)
    {
        return $this->model->where('id', $id)->where('user_id', $userId)->first();
    }

    /**
     *  Update by user id
     *
     * @param integer $userId
     * @param integer $id
     * @param array $attributes
     * @return mixed
     */
    public function updateByUserId(int $userId, int $id, array $attributes)
    {
        $result = $this->findByUserId($userId, $id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Count by user id
     * @param integer $id
     * @return mixed
     */
    public function countByUserId(int $userId)
    {
        return $this->model->where('user_id', $userId)->count();
    }

    /**
     * Chunk bulk Insert
     *
     * @param array $data
     * @param integer $size
     * @return void
     */
    public function chunkInsert(array $data, int $size = 100)
    {
        $chunk = array_chunk($data, $size);
        foreach ($chunk as $item)
            $this->insert($item);
    }

    /**
     * Delete by key
     *
     * @param string $key
     * @param array $value
     * @return mixed
     */
    public function deleteByKey(string $key, array $value)
    {
        return $this->model->whereIn($key, $value)->delete();
    }

    /**
     * Bulk Delete by user with relation
     *
     * @param integer $userId
     * @param array $ids
     * @param EloquentRepository $relation
     * @param string $foreignKey
     * @return void
     */
    public function bulkDeleteByUserWithRelation(int $userId, array $ids, EloquentRepository $relation, string $foreignKey)
    {
        $data = $this->model->where('user_id', $userId)->whereIn('id', $ids)->get();

        $ids = $data->pluck('id')->toArray();

        $this->bulkDelete($ids);

        $relation->deleteByKey($foreignKey, $ids);
    }

    /**
     * Clear Expired Data
     *
     * @param integer $days
     * @return void
     */
    public function clearExpired(int $days = 30)
    {
        $this->model->whereDate('created_at', '<', now()->subDays($days))->delete();
    }
}
