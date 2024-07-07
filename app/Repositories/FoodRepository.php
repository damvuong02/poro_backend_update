<?php

namespace App\Repositories;

use App\Jobs\UpdateFoodJob;
use App\Models\Food;
use App\Repositories\BaseRepository;

class FoodRepository extends BaseRepository
{

    public function getModel()
    {
        return Food::class;
    }
    public function getAll()
    {
        return $this->model->latest()->get()->load('category');
    }

    public function create($data = [])
    {
        $result = $this->model->create($data);
        if ($result) {
            return $result->load('category');
        }
        return false;
    }

    public function update($data = [], $id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($data);
            return $result->load('category');
        }
        return false;
    }

    public function updateSoldQuantity($quantity, $id)
    {
        $result = $this->model->find($id);
        if ($result) {
            $result->update($result->quantity_sold + $quantity);
            return true;
        }
        return false;
    }

    public function searchFood(string $value, int $category_id)
    {
        if ($category_id < 0) {

            $result = $this->model->where('food_name', 'like', '%' . $value . '%')->with('category')->paginate(10000);
            return $result;
        } else {
            $result = $this->model->where('food_name', 'like', '%' . $value . '%')->where('category_id', $category_id)->with('category')->paginate(10000);
            return $result;
        }
    }

    public function getTopFoodQuantitySold()
    {
        $topFoods = Food::orderByDesc('quantity_sold')->take(5)->get()->load('category');
        return $topFoods;
    }
    public function updateBeforeCreateOrder($data = [])
    {
        // Giảm số lượng quantity
        $decrementResult = $this->model->where('id', $data['food_id'])->decrement('quantity', $data['quantity']);
        if($decrementResult){
            UpdateFoodJob::dispatch($this->model->find($data['food_id'])->load('category'));
        }
        $incrementResult = $this->model->where('id', $data['food_id'])->increment('quantity_sold', $data['quantity']);
        if($decrementResult&&$incrementResult){
            return true;
        }
        return false;
    }

    public function incrementQuantity($data = [])
    {
        // Giảm số lượng quantity
        $incrementResult = $this->model->where('id', $data['food_id'])->increment('quantity', $data['quantity']);
        if($incrementResult){
            UpdateFoodJob::dispatch($this->model->find($data['food_id'])->load('category'));
            return true;
        }
        return false;
    }
}
