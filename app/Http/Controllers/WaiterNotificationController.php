<?php

namespace App\Http\Controllers;;

use App\Jobs\CreateDeleteNotificationJob;
use App\Jobs\NumberOfNotificationJob;
use App\Services\WaiterNotificationService;
use Illuminate\Http\Request;

class WaiterNotificationController extends Controller
{
    //
    protected $waiterNotificationService;
    /**
     * Class constructor.
     */
    public function __construct(WaiterNotificationService $waiterNotificationService)
    {
        $this->waiterNotificationService = $waiterNotificationService;
    }

    function getAllWaiterNotification()
    {   
        return response()->json($this->waiterNotificationService->getAllWaiterNotification(), 200);
    }

    function deleteWaiterNotification($id) {
        $result = $this->waiterNotificationService->deleteWaiterNotification($id);
        if($result){
            return response()->json(["message" => $result], 200);
        }   else {
            return response()->json(["message" => "Xóa thông báo thất bại"], 500);
        }
    } 
    
}
