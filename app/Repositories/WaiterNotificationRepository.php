<?php

namespace App\Repositories;

use App\Models\WaiterNotification;
use App\Repositories\BaseRepository;
use Exception;

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

    function create($data = []){
        $result = $this->model->create($data)->load('food', 'table');
        if($result){
            return $result;
        }
        return false;
    }

    function delete($id){
        try{
            $result = $this->model->find($id);
            if($result){
                $result->delete($id);
                return $result->load('food', 'table');
            }
            return false;
        }catch(Exception $ex){
            return null;
        }
    }

}