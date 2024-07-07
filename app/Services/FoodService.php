<?php

namespace App\Services;

use App\Repositories\FoodRepository;

class FoodService{
    protected $foodRepo;

    /**
     * Class constructor.
     */
    public function __construct(FoodRepository $foodRepository)
    {
        $this->foodRepo = $foodRepository;
    }
    
    
    function getAllFood(){
        return $this->foodRepo->getAll();
    }

    function createFood($data){
        return $this->foodRepo->create($data);
    }

    function updateFood($data, $id){
        return $this->foodRepo->update($data, $id);
    }

    function updateSoldQuantity($sold_quantity, $id){
        return $this->foodRepo->updateSoldQuantity($sold_quantity, $id);
    }

    function deleteFood($id){
        return $this->foodRepo->delete($id);
    }
    
    function findById($id){
        return $this->foodRepo->findById($id);
    }

    function searchFood($foodName, $category_id){
        return $this->foodRepo->searchFood($foodName, $category_id);
    }

    function getTopFoodQuantitySold(){
        return $this->foodRepo->getTopFoodQuantitySold();
    }
    
}
