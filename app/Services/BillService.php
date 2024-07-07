<?php

namespace App\Services;

use App\Jobs\DeleteUpdateOrderJob;
use App\Models\Bill;
use App\Repositories\BillRepository;
use App\Repositories\FoodRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class BillService{
    protected $billRepo;
    protected $orderRepo;
    protected $foodRepo;
    protected $notificationRepo;
    protected $notificationService;



    /**
     * Class constructor.
     */
    public function __construct(BillRepository $billRepository, FoodRepository $foodRepository, WaiterNotificationService $notificationService, OrderRepository $orderRepository)
    {
        $this->billRepo = $billRepository;
        $this->orderRepo = $orderRepository;
        $this->foodRepo = $foodRepository;
        $this->notificationService = $notificationService;

    }
    
    function getAllBill(){
        return $this->billRepo->getAll();
    }
    function createBill($data){
        return $this->billRepo->create($data);
    }
    function cashierCreateBill($data){
        DB::beginTransaction();
        
        try {
            $orders = $this->orderRepo->getOrderByTable($data["table_name"])->toArray();
            $newOrders = array_filter($orders, function ($order) {
                return $order['order_status'] === 'New';
            });
            $otherOrders = array_values(array_diff_key($orders, $newOrders));

            foreach ($newOrders as $index => $value) {   
                // Cập nhật thông tin hàng hóa
                $result = $this->foodRepo->incrementQuantity($value);

                if (!$result) {
                    throw new \Exception('Failed to create order or update food information.');
                } else{
                    
                }
            }
            $bill_data = [
                "table_name" => $data["table_name"], 
                "account_id" => $data["account_id"], 
                "created_at" => $data["created_at"],
                "bill_detail" => json_encode($otherOrders),
                ];
            $bill = new Bill($bill_data);
            $bill->id = -1;
            if(!empty($otherOrders)) {
                // tạo bill
                $bill = $this->billRepo->create($bill_data);
            }
            //xóa order liên quan
            $this->orderRepo->deleteOrderByTable($data["table_name"]);

            //bill được tạo bởi Thu Ngân thì tạo thông báo đến phục vụ.
            $notificationData = [
                "table_name" => $data["table_name"],
                "notification_status" => "Clean",
            ];
            $createNotification = $this->notificationService->createWaiterNotification($notificationData);

            //send event UpdateOrder
            $allOrder = $this->orderRepo->getAllOrder();
            $allOrder =json_encode($allOrder);
            DeleteUpdateOrderJob::dispatch($allOrder);
            // Commit transaction nếu tất cả các xử lý đều thành công
            DB::commit();
            return $bill;

        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();

            return null;
        }
    }

    function updateBill($data, $id){
        return $this->billRepo->update($data, $id);
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
