<?php

namespace RTech\Repositories;

use RSolution\RCms\Repositories\EloquentRepository;
use RTech\Models\Product;

class ProductRepository extends EloquentRepository
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public function getModel()
    {
        return Product::class;
    }

    public function create($attributes = [])
    {
        if(isset($attributes['images']))
            $attributes['images'] = $this->urlImageSave($attributes['images']);
        if(isset($attributes['logo']))
            $attributes['logo'] = $this->urlImageSave($attributes['logo']);
        return $this->model->create($attributes);
    }

    public function update($id, $attributes = [])
    {
        if(isset($attributes['images']))
            $attributes['images'] = $this->urlImageSave($attributes['images']);
        if(isset($attributes['logo']))
            $attributes['logo'] = $this->urlImageSave($attributes['logo']);
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    public function urlImageSave($url){
        if($url)
        {
            $str = explode(env('APP_URL'), $url);
            $rls = $str[1]??null;
        }
        return $rls??null;
    }

    public function filter($request)
    {
        $query = $this->model::query();
        
        if (!empty($request->status))
            $query->where('status', $request->status);

        if (!empty($request->search))
            $query->where('name', 'like', '%' . $request->search . '%');
        
        if (!empty($request->created_at))
            $query->whereDate('created_at', $request->created_at);
        
        return $query->orderBy('display_order', 'asc')->orderBy('created_at','desc')->paginate($request->limit ? $request->limit : 10);
    }

    public function getListActive()
	{
		return $this->model::query()->where('status', self::STATUS_ACTIVE)->orderBy('display_order', 'asc')->orderBy('created_at', 'desc')->get();
	}
}