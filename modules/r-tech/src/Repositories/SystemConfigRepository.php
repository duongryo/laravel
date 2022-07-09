<?php

namespace RTech\Repositories;

use RSolution\RCms\Repositories\EloquentRepository;
use RTech\Models\SystemConfig;

class SystemConfigRepository extends EloquentRepository
{
    public function getModel()
    {
        return SystemConfig::class;
    }

    public function update($id, $attributes = [])
    {
        if(isset($attributes['images']))
            $attributes['images'] = $this->urlImageSave($attributes['images']);
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
}