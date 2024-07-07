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

    
    function createBill(Request $request) {
        $rules = [
            'table_name' => 'required',
            'bill_detail' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_name.required' => 'Tên bàn là bắt buộc.',
            'bill_detail.required'   => 'Chi tiết hóa đơn là bắt buộc.',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $result = null;
        if($request->has('account_id')){
            $result = $this->billService->cashierCreateBill($request->all());
        }else{

            $result = $this->billService->createBill($request->all());
        }
        if($result){
            return response()->json(["message" => "Thêm hóa đơn thành công", "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Thêm hóa đơn thất bại"], 500);
        }
        
    }

    function updateBill(Request $request, $id) {

        $rules = [
            'table_name' => 'required',
            'bill_detail' => 'required',
            'created_at' => 'required',
        ];
        $messages = [
            'table_name.required' => 'Tên bàn là bắt buộc.',
            'bill_detail.required'   => 'Chi tiết hóa đơn là bắt buộc.',
            'created_at.required'   => 'Ngày tạo hóa đơn là bắt buộc.',

        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "table_name" => $request->table_name,
            "bill_detail" => $request->bill_detail,
            "account_id" => $request->account_id,
            "created_at" => $request->created_at,
        ];
        $result = $this->billService->updateBill($newData, $id);
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
