<?php

namespace App\Repositories;

use App\Models\WaiterNotification;
use App\Repositories\BaseRepository;

class WaiterNotificationRepository extends BaseRepository
{

    function getModel()
    {
        return WaiterNotification::class;
    }

    public function getAll()
    {
        return $this->model->with('food', 'table')->latest()->get();
    }

}