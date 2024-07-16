<?php

namespace App\Http\Controllers;;

use App\Services\BillService;
use App\Services\WaiterNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{
    protected $billService;
    protected $notificationService;
    /**
     * Class constructor.
     */
    public function __construct(BillService $billService, WaiterNotificationService $notificationService)
    {
        $this->billService = $billService;
        $this->notificationService = $notificationService;
    }

    function getAllBill()
    {   
        return response()->json($this->billService->getAllBill(), 200);
    }
    
    function getNewBillByTable(Request $request)
    {   
        return response()->json($this->billService->getNewBillByTable($request->input('table_id')), 200);
    }
    
    function createBill(Request $request) {
        $rules = [
            'table_id' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_id.required' => 'Bàn không được để trống',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $result = $this->billService->createBill($request->all());
        if($result){
            return response()->json(["message" => "Thêm hóa đơn thành công", "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Thêm hóa đơn thất bại"], 500);
        }
        
    }
    
    function cashierCreateBill(Request $request, $id) {

        $rules = [
            'table_id' => 'required',
            'account_id' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_id.required' => 'Bàn không được để trống',
            'account_id.required' => 'Tài khoản không được để trống',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "table_id" => $request->table_id,
            "account_id" => $request->account_id,
            "created_at" => $request->created_at,
        ];
        $result = $this->billService->cashierCreateBill($newData, $id);
        if($result){
            return response()->json(["message" => "Xác nhận thanh toán hóa đơn thành công", "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Xác nhận thanh toán hóa đơn thất bại"], 500);
        }
        
    }

    function managerCreateBill(Request $request) {

        $rules = [
            'table_id' => 'required',
            'account_id' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_id.required' => 'Bàn không được để trống',
            'account_id.required' => 'Tài khoản không được để trống',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $bill_data = [
            "table_id" => $request->table_id,
            "account_id" => $request->account_id,
            "created_at" => $request->created_at,
        ];
        $data_order = json_decode($request->data, true); 
        $result = $this->billService->managerCreateBill($bill_data, $data_order);
        if($result){
            return response()->json(["message" => "Tạo hóa đơn thành công", "data" => $result], 200);
        }else {
            return response()->json(["message" => "Tạo hóa đơn thất bại", "data" => $result], 500);
        }
        
    }

    function updateBill(Request $request, $id) {

        $rules = [
            'table_id' => 'required',
            'account_id' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_id.required' => 'Bàn không được để trống',
            'account_id.required' => 'Tài khoản không được để trống',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "table_id" => $request->table_id,
            "account_id" => $request->account_id,
            "created_at" => $request->created_at,
        ];
        $data_order = json_decode($request->data, true); 
        $result = $this->billService->updateBill($newData, $data_order, $id);
        if($result){
            return response()->json(["message" => "Cập nhật hóa đơn thành công", 
            "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Cập nhật hóa đơn thất bại"], 500);
        }
        
    }

    function deleteBill($id) {
        $result = $this->billService->deleteBill($id);
        if($result){
            return response()->json(["message" => "Xóa hóa đơn thành công"], 200);
        }   else {
            return response()->json(["message" => "Xóa hóa đơn thất bại"], 500);
        }
        
    } 
    
    function finById(Request $request)
    {   
        $result = $this->billService->findById($request->input('id'));
        return response()->json($result, 200);
    }

    function getBillsToday()
    {   
        $result = $this->billService->getBillsToday();
        return response()->json($result, 200);
    }

    function getBillsByDate(Request $request) {
        $rules = [
            
            'created_at' => 'required',
        ];
        $messages = [
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $result = $this->billService->getBillsByDate($request->all());
        return response()->json($result, 200);
        
    }

    function getRevenueByDayInWeek()
    {   
        $result = $this->billService->getRevenueByDayInWeek();
        return response()->json($result, 200);
    }

    function getRevenueByMonthInYear()
    {   
        $result = $this->billService->getRevenueByMonthInYear();
        return response()->json($result, 200);
    }

    function getRevenueByYear()
    {   
        $result = $this->billService->getRevenueByYear();
        return response()->json($result, 200);
    }
    
}
