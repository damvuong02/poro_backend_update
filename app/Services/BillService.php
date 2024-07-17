<?php

namespace App\Services;

use App\Jobs\DeleteOrderJob;
use App\Jobs\UpdateOrderJob;
use App\Models\Bill;
use App\Repositories\BillRepository;
use App\Repositories\FoodRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TableRepository;
use Illuminate\Support\Facades\DB;

class BillService{
    protected $billRepo;
    protected $orderRepo;
    protected $foodRepo;
    protected $notificationRepo;
    protected $tableService;
    protected $orderService;

    protected $notificationService;



    /**
     * Class constructor.
     */
    public function __construct(BillRepository $billRepository, FoodRepository $foodRepository, WaiterNotificationService $notificationService, OrderRepository $orderRepository, TableService $tableService, OrderService $orderService)
    {
        $this->billRepo = $billRepository;
        $this->orderRepo = $orderRepository;
        $this->foodRepo = $foodRepository;
        $this->notificationService = $notificationService;
        $this->tableService = $tableService;
        $this->orderService = $orderService;

        

    }
    
    function getAllBill(){
        return $this->billRepo->getAll();
    }
    function getNewBillByTable($table_id){
        return $this->billRepo->getNewBillByTable($table_id);
    }
    function createBill($data){
        return $this->billRepo->create($data);
    }

    function managerCreateBill($bill_data, $order_data){
        DB::beginTransaction();
        
        try {
            $bill = $this->billRepo->create($bill_data);
            
            foreach ($order_data as $index => $value) {
                $orderData = [
                    'food_id' => $value['food_id'],
                    'bill_id' => $bill->id,
                    'price' => $value['price'],
                    'quantity' => $value['quantity'],
                    'order_status' => "Done",
                    'note' => $value['note'],
                ];
                
                // Tạo đơn hàng
                $result = $this->orderRepo->create($orderData);
            }
            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();
            return $this->billRepo->findBillById($bill->id);

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return null;
        }
    }

    function cashierCreateBill($data, $bill_id){
        DB::beginTransaction();
        
        try {
            // $orders = $this->orderRepo->getOrderByTable($data["table_name"])->toArray();
            $bill = $this->billRepo->findBillById($bill_id);
            $orders = $bill->orders->toArray();
            $newOrders = array_filter($orders, function ($order) {
                return $order['order_status'] === 'New';
            });

            foreach ($newOrders as $index => $value) {   
                // Cập nhật thông tin hàng hóa
                $result = $this->foodRepo->incrementQuantity($value);
                $result2 = $this->orderRepo->delete($value["id"]);
                if (!$result || !$result2) {
                    throw new \Exception('Failed to create order or update food information.');
                } else{
                    $deletedOrders =json_encode($result2);
                    DeleteOrderJob::dispatch($deletedOrders);    
                }
            }
            $cookingOrders = array_filter($orders, function ($order) {
                return $order['order_status'] === 'Cooking';
            });
            
            if (count($cookingOrders) !== 0) {
                foreach ($cookingOrders as $index => $value1) {  
                    $newData = [
                        "food_id" => $value1["food_id"],
                        "bill_id" => $value1["bill_id"],
                        "price" => $value1["price"],
                        "quantity" => $value1["quantity"],
                        "order_status" => "Done",
                        'note' => $value1["note"],
                        'table_id' => $bill->table->id,
                    ];
                    $result3 = $this->orderRepo->update($newData, $value1["id"]);
                    
                    if (!$result3) {
                        throw new \Exception('Failed to create order or update food information.');
                    } else{
                        $updatedOrder =json_encode($result3);
                        UpdateOrderJob::dispatch($updatedOrder);    
                    }
                }
                
                
            } 
            
            $bill = $this->billRepo->update($data, $bill_id);
            $table = $this->tableService->findById( $bill->table_id);
            $this->tableService->updateTable(["table_status" => "Empty", 'table_name' => $table->table_name], $bill->table_id);
            //bill được tạo bởi Thu Ngân thì tạo thông báo đến phục vụ.
            $notificationData = [
                "table_id" => $data["table_id"],
                
                "notification_status" =>"Clean",
            ];
            $createNotification = $this->notificationService->createWaiterNotification($notificationData);

            if (count($bill->orders) == 0){
                $result = $this->billRepo->delete($bill_id);
            }
            //send event UpdateOrder
            $cookingOrder = $this->orderRepo->getOrderByStatus("Cooking");
            $newOrder = $this->orderRepo->getOrderByStatus("New");
            $mergedOrders = $cookingOrder->merge($newOrder);
            $mergedOrders =json_encode($mergedOrders);
            DeleteOrderJob::dispatch($mergedOrders);
            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();
            return $bill;

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return null;
        }
    }

    function updateBill($bill_data, $order_data, $id){
        DB::beginTransaction();
        try {
            $this->orderRepo->deleteOrderByBill($id);
                foreach ($order_data as $index => $value) {
                    $orderData = [
                        'food_id' => $value['food_id'],
                        'bill_id' => $id,
                        'price' => $value['price'],
                        'quantity' => $value['quantity'],
                        'order_status' => "Done",
                        'note' => $value['note'],
                    ];
                    // Tạo đơn hàng
                    $result = $this->orderRepo->create($orderData);
                }
            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();
            return $this->billRepo->update($bill_data, $id);
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            return null;
        }
        
    }

    function deleteBill($id){
        return $this->billRepo->delete($id);
    }
    
    function findById($id){
        return $this->billRepo->findById($id);
    }

    function getBillsToday(){
        return $this->billRepo->getBillsToday();
    }
    function getBillsByDate($data){
        return $this->billRepo->getBillsByDate($data);
    }
    function getRevenueByDayInWeek(){
        return $this->billRepo->getRevenueByDayInWeek();
    }

    function getRevenueByMonthInYear(){
        return $this->billRepo->getRevenueByMonthInYear();
    }

    function getRevenueByYear(){
        return $this->billRepo->getRevenueByYear();
    }
    
}
