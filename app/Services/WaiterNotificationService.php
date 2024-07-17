<?php

namespace App\Services;

use App\Jobs\CreateDeleteNotificationJob;
use App\Jobs\CreateNotificationJob;
use App\Jobs\DeleteNotificationJob;
use App\Jobs\NumberOfNotificationJob;
use App\Repositories\WaiterNotificationRepository;

class WaiterNotificationService{
    protected $waiterNotificationRepo;

    /**
     * Class constructor.
     */
    public function __construct(WaiterNotificationRepository $waiterNotificationRepository)
    {
        $this->waiterNotificationRepo = $waiterNotificationRepository;
    }
    
    
    function getAllWaiterNotification(){
        return $this->waiterNotificationRepo->getAll();
    }

    function createWaiterNotification($data){
        $allNotification = $this->waiterNotificationRepo->getAll();
        NumberOfNotificationJob::dispatch(count($allNotification));
        $result = $this->waiterNotificationRepo->create($data);
        CreateNotificationJob::dispatch(json_encode($result)); 
        return  $result;
    }

    function deleteWaiterNotification($id){
        $allNotification = $this->waiterNotificationRepo->getAll();
        NumberOfNotificationJob::dispatch(count($allNotification));
        $result = $this->waiterNotificationRepo->delete($id);
        DeleteNotificationJob::dispatch(json_encode($result));
        return $result;
    }

    
    
}
