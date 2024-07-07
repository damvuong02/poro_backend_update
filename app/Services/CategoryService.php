<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService{
    protected $categoryRepo;

    /**
     * Class constructor.
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }
    
    
    function getAllCategory(){
        return $this->categoryRepo->getAll();
    }

    function createCategory($data){
        return $this->categoryRepo->create($data);
    }

    function updateCategory($data, $id){
        return $this->categoryRepo->update($data, $id);
    }

    function deleteCategory($id){
        return $this->categoryRepo->delete($id);
    }
    
    function findById($id){
        return $this->categoryRepo->findById($id);
    }

    function getFoodByCategory($id){
        return $this->categoryRepo->getFoodByCategory($id);
    }
}
