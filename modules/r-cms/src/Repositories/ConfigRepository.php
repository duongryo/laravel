<?php

namespace RSolution\RCms\Repositories;

use RSolution\RCms\Models\Config;

class ConfigRepository extends EloquentRepository
{
    const PAGE_LIMIT = 20;
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Config::class;
    }

    public function getByKey($key, $paginate = null)
    {
        if ($paginate)
            return $this->model->where('key', $key)->paginate($paginate);
        else
            return $this->model->where('key', $key)->get();
    }

    public function findByKey($key, $onlyValue = false)
    {
        return $onlyValue ?
            $this->model->where('key', $key)->value('value') :
            $this->model->where('key', $key)->first();
    }
}
