<?php

namespace App\Http\Controllers;;

use App\Services\FoodService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    //
    protected $foodService;
    /**
     * Class constructor.
     */
    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
    }

    function getAllFood()
    {   
        return response()->json($this->foodService->getAllFood(), 200);
    }

    
    function createFood(Request $request) {
        $rules = [
            'food_name' => 'required|max:200',
            'category_id' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ];
        $messages = [
            'food_name.required' => 'Tên mặt hàng là bắt buộc.',
            'food_name.max'      => 'Tên mặt hàng không được vượt quá 200 ký tự.',
        
            'category_id.required' => 'Mã nhóm mặt hàng là bắt buộc.',

            'price.required' => 'Giá bán là bắt buộc.',

            'quantity.required' => 'Số lượng là bắt buộc.',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $data = $request->all();
        // Ensure quantity_sold is not null
        $data['quantity_sold'] = $data['quantity_sold'] ?? 0;

        $result = $this->foodService->createFood($data);

        if($result){
            return response()->json(["message" => "Thêm mặt hàng thành công",
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Thêm mặt hàng thất bại"], 500);
        }
        
    }

    function updateFood(Request $request, $id) {

        $rules = [
            'food_name' => 'required|max:200',
            'category_id' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ];
        $messages = [
            'food_name.required' => 'Tên mặt hàng là bắt buộc.',
            'food_name.max'      => 'Tên mặt hàng không được vượt quá 200 ký tự.',
        
            'category_id.required' => 'Mã nhóm mặt hàng là bắt buộc.',

            'price.required' => 'Giá bán là bắt buộc.',

            'quantity.required' => 'Số lượng là bắt buộc.',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "food_name" => $request->food_name,
            "category_id" => $request->category_id,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "food_image" => $request->food_image,
            "food_unit" => $request->food_unit,
            "need_cooking" => $request->need_cooking
        ];
        $result = $this->foodService->updateFood($newData, $id);
        if($result){
            return response()->json(["message" => "Cập nhật mặt hàng thành công", 
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Cập nhật mặt hàng thất bại"], 500);
        }
        
    }

    function updateSoldQuantity($quantity, $id) {

        $result = $this->foodService->updateSoldQuantity($quantity, $id);
        if($result){
            return true;
        }   else {
            return false;
        }
        
    }

    function deleteFood($id) {
        $result = $this->foodService->deleteFood($id);
        if($result){
            return response()->json(["message" => "Xóa mặt hàng thành công"], 200);
        }   else {
            return response()->json(["message" => "Xóa mặt hàng thất bại"], 500);
        }
        
    } 
    
    function searchFood(Request $request) {
        $result = $this->foodService->searchFood($request->input('food_name'), $request->input('category_id'));
        return response()->json($result, 200);
    }
    
    function finById(Request $request)
    {   
        $result = $this->foodService->findById($request->input('id'));
        return response()->json($result, 200);
    }

    function getTopFoodQuantitySold()
    {   
        return response()->json($this->foodService->getTopFoodQuantitySold(), 200);
    }
    
}
