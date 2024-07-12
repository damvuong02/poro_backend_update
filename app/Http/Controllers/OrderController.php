<?php

namespace App\Http\Controllers;

use App\Jobs\CreateOrderJob;
use App\Services\OrderService;
use App\Services\WaiterNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //
    protected $orderService;
    protected $notificationService;

    /**
     * Class constructor.
     */
    public function __construct(OrderService $orderService, WaiterNotificationService $notificationService )
    {
        $this->orderService = $orderService;
        $this->notificationService = $notificationService;
    }

    public function getAllOrder()
    {
        return response()->json($this->orderService->getAllOrder(), 200);
    }

    public function getOrderByStatus(Request $request)
    {
        $order_status = $request->order_status;
        $result = $this->orderService->getOrderByStatus($order_status);
        if ($result) {
            return response()->json($result);
        }
        return response()->json(["message" => "Đơn đặt hàng không tồn tại"], 500);
    }

    public function createOrder(Request $request)
    {
        try {
            $data_order = json_decode($request->data, true); 
            $result = $this->orderService->createOrder($data_order);
            
            if ($result) {
                if($result['success'] === true){
                    return response()->json(["message" => $result['success_order'], "success_order" => $result['success_order'], "result" => true], 200);
                }else{
                    return response()->json(["message" => $result['errors'], "success_order" => $result['success_order'], "result" => false], 500);
                }
            } else {
                return response()->json(["message" => "Thêm đơn đặt món thất bại"], 500);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Đã xảy ra lỗi: " . $e->getMessage()], 500);
        }
    }

    public function deleteNewOrder(Request $request)
    {
        try {
            $data_order = json_decode($request->data, true); 
            $result = $this->orderService->deleteNewOrder($data_order);
            if ($result) {
                return response()->json(["message" => "Hủy đơn đặt món thành công"], 200);
            } else {
                return response()->json(["message" => "Hủy đơn đặt món thất bại"], 500);
            }
        } catch (\Exception $e) {
            return response()->json(["message" => "Đã xảy ra lỗi: " . $e->getMessage()], 500);
        }
    }

    public function updateOrder(Request $request, $id)
    {   
        $rules = [
            'food_id' => 'required',
            'bill_id' => 'required',
            'price' => 'required',
            'quantity' => 'required',
            'order_status' => 'required',
        ];
        $messages = [
            'food_id.required' => 'Mã mặt hàng là bắt buộc',
            'bill_id.required'   => 'Mã hóa đơn là bắt buộc.',
            'price.required' => 'Giá bán là bắt buộc.',
            'quantity.required' => 'Số lượng là bắt buộc.',
            'order_status.required'   => 'Trạng thái là bắt buộc.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $newData = [
            "food_id" => $request->food_id,
            "bill_id" => $request->bill_id,
            "price" => $request->price,
            "quantity" => $request->quantity,
            "order_status" => $request->order_status,
            'note' => $request->note,
            'table_id' => $request->table_id,
        ];
        $result = $this->orderService->updateOrder($newData, $id);
        if($result){
            return response()->json(["message" => "Cập nhật đơn đặt món thành công", 
            "data" => $result->load('food')], 200);
        }   else {
            return response()->json(["message" => "Cập nhật đơn đặt món thất bại"], 500);
        }
    }

    public function deleteOrder(Request $request)
    {
        $result = $this->orderService->deleteOrder($request->all());
        if ($result) {
            return response()->json(["message" => "Xóa đơn đặt món thành công"], 200);
        } else {
            return response()->json(["message" => "Xóa đơn đặt món thất bại"], 500);
        }
    }

    public function deleteOrderByBill(Request $request)
    {
        $table_name = $request->table_name;
        $result = $this->orderService->deleteOrderByBill($table_name);
        if ($result) {
            return response()->json(["message" => "Xóa đơn đặt món thành công"], 200);
        } else {
            return response()->json(["message" => "Xóa đơn đặt món thất bại"], 500);
        }

    }
}
