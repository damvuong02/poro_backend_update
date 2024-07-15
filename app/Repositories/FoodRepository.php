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
        $food = $this->model->find($data['food_id']);
        if (!$food) {
            // Nếu không tìm thấy food, trả về false hoặc ném ra exception
            return false;
        }
        // Kiểm tra nếu quantity của food khác null
        if ($food->quantity !== null) {
            // Giảm số lượng quantity
            $decrementResult = $this->model->where('id', $data['food_id'])->decrement('quantity', $data['quantity']);
            if ($decrementResult) {
                UpdateFoodJob::dispatch($food->load('category'));
            }
        } else {
            $decrementResult = true; // Không thực hiện giảm số lượng nhưng vẫn cho phép tiếp tục
        }
        $incrementResult = $this->model->where('id', $data['food_id'])->increment('quantity_sold', $data['quantity']);
        if($decrementResult&&$incrementResult){
            return true;
        }
        return false;
    }

    public function incrementQuantity($data = [])
    {
        // Lấy thông tin của food từ database
        $food = $this->model->find($data['food_id']);

        if (!$food) {
            // Nếu không tìm thấy food, trả về false hoặc ném ra exception
            return false;
        }

        // Kiểm tra nếu quantity của food khác null
        if ($food->quantity !== null) {
            // Tăng số lượng quantity
            $incrementResult = $this->model->where('id', $data['food_id'])->increment('quantity', $data['quantity']);
        } else {
            $incrementResult = true; // Không thực hiện tăng số lượng nhưng vẫn cho phép tiếp tục
        }

        if ($incrementResult) {
            UpdateFoodJob::dispatch($food->load('category'));
            return true;
        }

        return false;
    }

}
