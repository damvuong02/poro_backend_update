<?php
namespace App\Services;

use App\Jobs\CreateOrderJob;
use App\Jobs\DeleteUpdateOrderJob;
use App\Models\Bill;
use App\Repositories\BillRepository;
use App\Repositories\FoodRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TableRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepo;
    protected $foodRepo;
    protected $tableService;
    protected $notificationService;
    protected $billRepo;


    /**
     * Class constructor.
     */
    public function __construct(OrderRepository $orderRepo, FoodRepository $foodRepo, TableService $tableService, WaiterNotificationService $notificationService, BillRepository $billRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->foodRepo = $foodRepo;
        $this->tableService = $tableService;
        $this->notificationService = $notificationService;
        $this->billRepo = $billRepo;
    }

    function getAllOrder()
    {
        return $this->orderRepo->getAllOrder();
    }

    public function getOrderByBillAndStatus($bill_id, $status)
    {
        if (!empty($bill_id) && !empty($status)) {
            return $this->orderRepo->getOrderByBillAndStatus($bill_id, $status);
        }
        return false;
    }


    public function getOrderByStatus($order_status)
    {
        if (!empty($order_status)) {
            return $this->orderRepo->getOrderByStatus($order_status);
        }
        return false;
    }

    public function createOrder($data)
    {
        $create_err = []; // Mảng lưu các lỗi phát sinh
        $successOrder = []; //Mảng lưu các Order được tạo thành công
        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            foreach ($data as $index => $value) {
                $food = $this->foodRepo->findById($value['food_id']);
                
                // Kiểm tra số lượng hàng còn lại
                if ($food->quantity !== null && $value['quantity'] > $food->quantity) {
                    $create_err[] = [
                        'food_id' => $value['food_id'],
                        'food_name' => $food['food_name'],
                        'requested_quantity' => $value['quantity'],
                        'available_quantity' => $food->quantity,
                        'error' => 'Insufficient quantity'
                    ];
                } else {
                    $orderData = [
                        'food_id' => $value['food_id'],
                        'bill_id' => $value['bill_id'],
                        'price' => $value['price'],
                        'quantity' => $value['quantity'],
                        'order_status' => $food->need_cooking == 0 ? "Done" : "New",
                        'note' => $value['note'],
                    ];
                    // Tạo đơn hàng
                    $result = $this->orderRepo->create($orderData);

                    // Cập nhật thông tin hàng hóa
                    $result1 = $this->foodRepo->updateBeforeCreateOrder($value);

                    if (!$result || !$result1) {
                        throw new \Exception('Failed to create order or update food information.');
                    } else{
                        array_push($successOrder, $result);
                        if($food->need_cooking == 1){
                            CreateOrderJob::dispatch($result->load("food", "bill", "bill.table"));
                        }
                    }
                }
            }

            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();

            return [
                'success' => empty($create_err),
                'errors' => $create_err,
                'success_order' => $successOrder
            ];

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return [
                'error' => $e->getMessage()
            ];
        }
    }

    
    public function deleteNewOrder($data)
    {
        // Bắt đầu transaction
        DB::beginTransaction();
        
        try {
            foreach ($data as $index => $value) {   
                // Xóa order
                $result = $this->orderRepo->delete($value["id"]);

                // Cập nhật thông tin hàng hóa
                $result1 = $this->foodRepo->incrementQuantity($value);

                if (!$result || !$result1) {
                    throw new \Exception('Failed to create order or update food information.');
                } else{
                    
                }
            }
            $bill = $this->billRepo->findBillById($value["bill_id"]);
            // $cookingOrder = $this->getOrderByBillAndStatus($value['bill_id'], "Cooking");
            if(count($bill->orders) == 0){
                $table = $this->tableService->findById( $bill->table_id);
                $this->tableService->updateTable(["table_status" => "Empty", 'table_name' => $table->table_name], $bill->table_id);
            } 
            $cookingOrder = $this->orderRepo->getOrderByStatus("Cooking");
            $newOrder = $this->orderRepo->getOrderByStatus("New");
            $mergedOrders = $cookingOrder->merge($newOrder);
            $mergedOrders =json_encode($mergedOrders);
            DeleteUpdateOrderJob::dispatch($mergedOrders);
            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();
            return [
                'message' =>"Success"
            ];

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return [
                'error' => $e->getMessage()
            ];
        }
    }

    function updateOrder($data, $id)
    {   
        $result = $this->orderRepo->update($data, $id);
        $cookingOrder = $this->orderRepo->getOrderByStatus("Cooking");
        $newOrder = $this->orderRepo->getOrderByStatus("New");
        $mergedOrders = $cookingOrder->merge($newOrder);
        $mergedOrders =json_encode($mergedOrders);
        DeleteUpdateOrderJob::dispatch($mergedOrders);
        $notificationData = [
            "table_id" => $data["table_id"],
            "food_id" =>$data['food_id'],
            "notification_status" => $data['order_status'],
        ];
        $noti = $this->notificationService->createWaiterNotification($notificationData);
        return $result;
    }

    // function updateOrderWithoutNotification($data, $id)
    // {   
    //     $result = $this->orderRepo->update($data, $id);
        
    //     return $result;
    // }

    function deleteOrder($data)
    {   
        $result = $this->orderRepo->delete($data["id"]);       
        return $result;
    }

    function deleteOrderByBill($bill_id)
    {
        return $this->orderRepo->deleteOrderByBill($bill_id);
    }
}
