<?php

namespace App\Repositories;

use App\Models\Bill;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class BillRepository extends BaseRepository
{

    function getModel()
    {
        return Bill::class;
    }
    public function getAll(){
        // return $this->model->latest()->get()->load('account', 'table', 'orders');
        return $this->model->latest()->with(['account', 'table', 'orders.food'])->get();
    }

    public function create($data = []){
        $result = $this->model->create($data);
        $result->created_at = $data["created_at"];
        $result->save();
        if($result){
            return $result->load('account', 'table', 'orders');
        }
        return false;
    }

    function update($data = [],$id){
        $result = $this->model->find($id);
        if($result){
            $result->update($data);
            $result->created_at = $data["created_at"];
            $result->save();
            return $result->load('account', 'table', 'orders');
        }
        return false;
    }

    public function getBillsToday()
    {
        $today = Carbon::today();

        $billsToday = Bill::whereDate('created_at', $today)->get();
        
        return $billsToday;
    }
    
    private function getRevenueByDay($day){
        $totalRevenue = 0; // Khởi tạo biến tổng doanh thu
        
        // Lấy danh sách hóa đơn của ngày cụ thể
        $bills = Bill::whereDate('created_at', $day)->get();
        
        // Lặp qua từng hóa đơn
        foreach ($bills as $bill) {
            // Decode trường "bill_detail" để có thể truy cập thông tin chi tiết của mỗi món hàng
            $billDetails = json_decode($bill->bill_detail, true);
            // Lặp qua từng chi tiết hóa đơn
            foreach ($billDetails as $detail) {
                // Tính tổng doanh thu từ giá tiền và số lượng của mỗi món hàng
                $totalRevenue += $detail['food']['price'] * $detail['quantity'];
            }
        }
        
        return $totalRevenue; // Trả về tổng doanh thu cuối cùng
    }
    
    public function getRevenueByDayInWeek()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        //danh sach cac ngay trong tuan
        $daysOfWeek = [];
        $billByDay = [];

        $day = $startOfWeek;
        for ($i = 0; $i < 7; $i++) {
            // Thêm ngày vào mảng
            $daysOfWeek[] = $day->copy(); // Sử dụng copy để tránh thay đổi ngày ban đầu
            $day->addDay(); 
        }
        // return $daysOfWeek;
        foreach ($daysOfWeek as $item) {
            // Sử dụng ngày làm key và gán giá trị là null cho mỗi ngày
            $billByDay[$item.""] = $this->getRevenueByDay($item);
        }
        
        return $billByDay;
    }

    private function getRevenueByMonth($year, $month){
        $totalRevenue = 0; // Khởi tạo biến tổng doanh thu
        
        // Lấy danh sách hóa đơn của tháng cụ thể
        $bills = Bill::whereYear('created_at', $year)
                     ->whereMonth('created_at', $month)
                     ->get();
        // Lặp qua từng hóa đơn
        foreach ($bills as $bill) {
            try {
                // Decode trường "bill_detail" để có thể truy cập thông tin chi tiết của mỗi món hàng
                $billDetails = json_decode($bill->bill_detail, true);
                
                // Lặp qua từng chi tiết hóa đơn
                foreach ($billDetails as $detail) {
                    // Tính tổng doanh thu từ giá tiền và số lượng của mỗi món hàng
                    $totalRevenue += $detail['food']['price'] * $detail['quantity'];
                }
            } catch(Exception) {

            }
        }
        
        return $totalRevenue; // Trả về tổng doanh thu cuối cùng
    }
    public function getRevenueByMonthInYear(){   
        $currentYear = Carbon::now()->year;
        $billByDay = [];
        for ($i = 1; $i <= 12; $i++) {
            $billByDay[$i.""] = $this->getRevenueByMonth($currentYear, $i);
        }
    
        return $billByDay;
    }

    public function getRevenueByYear(){
        // Lấy tất cả các hóa đơn từ cơ sở dữ liệu
        $bills = Bill::all();
        
        // Nhóm các hóa đơn theo năm dựa vào cột `created_at`
        $billsByYear = $bills->groupBy(function($bill) {
            return Carbon::parse($bill->created_at)->year;
        });
        
        // Tính toán tổng doanh thu cho mỗi năm và tạo mảng chứa doanh thu theo năm
        $revenueByYear = $billsByYear->mapWithKeys(function ($bills, $year) {
            $totalRevenue = 0; // Khởi tạo tổng doanh thu cho năm hiện tại là 0

            // Duyệt qua từng hóa đơn trong nhóm năm hiện tại
            foreach ($bills as $bill) {
                try {
                    // Giải mã JSON trong trường `bill_detail` thành mảng
                    $billDetails = json_decode($bill->bill_detail, true);

                    // Duyệt qua từng mục chi tiết hóa đơn
                    foreach ($billDetails as $detail) {
                        // Tính doanh thu của từng mục (giá * số lượng) và cộng vào tổng doanh thu
                        $totalRevenue += $detail['food']['price'] * $detail['quantity'];
                    }
                }catch (Exception){
                    
                }
            }

            // Trả về một mảng có khóa là năm và giá trị là tổng doanh thu của năm đó
            return [$year => $totalRevenue];
        });

        // Chuyển đổi kết quả thành mảng (nếu cần thiết)
        $revenueByYearArray = $revenueByYear->toArray();

        // Trả về mảng doanh thu theo năm
        return $revenueByYearArray;
    }

}