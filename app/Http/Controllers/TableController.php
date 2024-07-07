<?php

namespace App\Http\Controllers;;


use App\Services\TableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    //
    protected $tableService;
    /**
     * Class constructor.
     */
    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    function getAllTable()
    {   
        return response()->json($this->tableService->getAllTable(), 200);
    }

    
    function createTable(Request $request) {
        $rules = [
            'table_name' => 'required|max:200|unique:tables,table_name',
            'table_status' => 'required'
        ];
        $messages = [
            'table_name.required' => 'Tên bàn là bắt buộc.',
            'table_name.max'      => 'Tên bàn không được vượt quá 200 ký tự.',
            'table_name.unique'   => 'Tên bàn đã được sử dụng.',
        
            'table_status.required' => 'Trạng thái bàn là bắt buộc.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $result = $this->tableService->createTable($request->all());
        if($result){
            return response()->json(["message" => "Thêm bàn thành công",
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Thêm bàn thất bại"], 500);
        }
        
    }

    function updateTable(Request $request, $id) {

        $rules = [
            'table_name' => 'required|max:200',
            'table_status' => 'required'
        ];
        $messages = [
            'table_name.required' => 'Tên bàn là bắt buộc.',
            'table_name.max'      => 'Tên bàn không được vượt quá 200 ký tự.',
        
            'table_status.required' => 'Trạng thái bàn là bắt buộc.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "table_name" => $request->table_name,
            "table_status" => $request->table_status,
        ];
        $result = $this->tableService->updateTable($newData, $id);
        if($result){
            return response()->json(["message" => "Cập nhật bàn thành công", 
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Cập nhật bàn thất bại"], 500);
        }
        
    }

    function deleteTable($id) {
        $result = $this->tableService->deleteTable($id);
        if($result){
            return response()->json(["message" => "Xóa bàn thành công"], 200);
        }   else {
            return response()->json(["message" => "Xóa bàn thất bại"], 500);
        }
        
    } 
    
    function searchTable(Request $request) {
        $result = $this->tableService->searchTableByTableName($request->input('table_name'));
        return response()->json($result, 200);
    }
    
    function finById(Request $request)
    {   
        $result = $this->tableService->findById($request->input('id'));
        return response()->json($result, 200);
    }

    function findTableByStatus(Request $request) {
        $result = $this->tableService->findTableByTableStatus($request->input('table_status'));
        return response()->json($result, 200);
    }
    
}
