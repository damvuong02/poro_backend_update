<?php

namespace App\Repositories;

use App\Models\Table;
use App\Repositories\BaseRepository;

class TableRepository extends BaseRepository
{

    function getModel()
    {
        return Table::class;
    }

    public function findByTableStatus($table_status) {
        $result = $this->model->where('table_status', $table_status)->paginate(10000);
        if($result){
            return $result;
        }
        return false;
    }

    public function updateStatusByTableName($table_name, $table_status) {
        $result = $this->model->where('table_status', $table_status)->paginate(10000);
        if($result){
            $newData = [
                "table_name" => $table_name,
                "table_status" => $table_status,
            ];
            return $result->update($newData);
        }
        return false;
    }
    
}