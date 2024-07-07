<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{

    function getModel()
    {
        return Category::class;
    }

    public function getFoodByCategory($id){
        $result = $this->model->find($id);
        if(!$result){
            return [];
        }
        
        return $result->foods->load('category');
    }
    
}