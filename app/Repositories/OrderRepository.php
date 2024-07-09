<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    protected $foodRepo;
    public function getModel()
    {
        return Order::class;
    }

    public function getAllOrder()
    {
        return $this->model->with('food.category', 'bill', 'bill.table')->latest()->get();
    }

    public function getOrderByBillAndStatus($bill_id, $status)
    {
        return $this->model->where('bill_id', $bill_id)->where('order_status', $status)->with('food.category')->get();
    }

    public function getOrderByTable($table_name)
    {
        return $this->model->where('table_name', $table_name)->with('food.category')->get();
    }

    public function getOrderByStatus($order_status)
    {
        return $this->model->where('order_status', $order_status)->with('food.category')->get();
    }

    public function deleteOrderByTable($table_name)
    {
        return $this->model->where('table_name', $table_name)->delete();
    }

    public function create($data = [])
    {
        $result = $this->model->create($data);
        if ($result) {
            return $result->load('food.category');
        }
        return false;
    }
}
