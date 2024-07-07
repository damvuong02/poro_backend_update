<?php

namespace App\Repositories;

use App\Models\Account;
use App\Repositories\BaseRepository;

class AccountRepository extends BaseRepository
{

    function getModel()
    {
        return Account::class;
    }

    public function findByUsername($username) {
        $result = $this->model->where('user_name', $username)->first();
        if($result){
            return $result;
        }
        return false;
    }
    
}