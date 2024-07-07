<?php

namespace App\Http\Controllers;;


use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    protected $categoryService;
    /**
     * Class constructor.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    function getAllCategory()
    {   
        return response()->json($this->categoryService->getAllCategory(), 200);
    }

    function getFoodByCategory(Request $request)
    {   
        return response()->json($this->categoryService->getFoodByCategory($request->input('id')), 200);
    }

    
    public function createCategory(Request $request) {
        $rules = [
            'category_name' => 'required|max:200',
        ];
        $messages = [
            'category_name.required' => 'Tên nhóm mặt hàng là bắt buộc.',
            'category_name.max'      => 'Tên nhóm mặt hàng không được vượt quá 200 ký tự.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ($validator->fails()) {
            // Get the first error message
            $errorMessage = $validator->errors()->first('category_name');
            return response()->json(['message' => $errorMessage], 422);
        }
    
        $result = $this->categoryService->createCategory($request->all());
    
        if ($result) {
            return response()->json([
                "message" => "Thêm nhóm mặt hàng thành công",
                "data" => $result
            ], 200);
        } else {
            return response()->json(["message" => "Thêm nhóm mặt hàng thất bại"], 500);
        }
    }

    function updateCategory(Request $request, $id) {

        $rules = [
            'category_name' => 'required|max:200',
        ];
        $messages = [
            'category_name.required' => 'Tên nhóm mặt hàng là bắt buộc.',
            'category_name.max'      => 'Tên nhóm mặt hàng không được vượt quá 200 ký tự.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            // Get the first error message
            $errorMessage = $validator->errors()->first('category_name');
            return response()->json(['message' => $errorMessage], 422);
        }
        
        $newData = [
            "category_name" => $request->category_name,
        ];
        $result = $this->categoryService->updateCategory($newData, $id);
        if($result){
            return response()->json(["message" => "Cập nhật nhóm mặt hàng thành công", 
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Cập nhật nhóm mặt hàng thất bại"], 500);
        }
        
    }

    function deleteCategory($id) {
        $result = $this->categoryService->deleteCategory($id);
        if($result){
            return response()->json(["message" => "Xóa nhóm mặt hàng thành công"], 200);
        }   else {
            return response()->json(["message" => "Xóa nhóm mặt hàng thất bại"], 500);
        }
        
    } 
    
    function finById(Request $request)
    {   
        $result = $this->categoryService->findById($request->input('id'));
        return response()->json($result, 200);
    }
}
