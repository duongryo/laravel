<?php

namespace RTech\Repositories;

use RTech\Models\PostCategory;
use RSolution\RCms\Repositories\EloquentRepository;

class PostCategoryRepository extends EloquentRepository
{
    public function getModel()
    {
        return PostCategory::class;
    }

    public function getListCategory()
    {
        $data = [];
        $models = $this->getAll();
        
        foreach ($models as $item) {
            $data[$item->id] = $item->name;
        }
        $option = ['' => 'Choose Category'];

        if($data)
            $data = array_merge($option, $data);
        return $data;
    }
}