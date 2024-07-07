<?php

namespace App\Services;

use App\Jobs\CreateDeleteNotificationJob;
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
        $this->waiterNotificationRepo->create($data);
        $allNotification = $this->waiterNotificationRepo->getAll();
        CreateDeleteNotificationJob::dispatch($allNotification);
        NumberOfNotificationJob::dispatch(count($allNotification));
        return  $allNotification;
    }

    function deleteWaiterNotification($id){
        $this->waiterNotificationRepo->delete($id);
        return $this->waiterNotificationRepo->getAll();
    }

    
    
}
