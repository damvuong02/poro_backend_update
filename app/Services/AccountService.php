<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;

class AccountService{
    protected $accountRepo;

    /**
     * Class constructor.
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepo = $accountRepository;
    }
    
    
    function getAllAccount(){
        return $this->accountRepo->getAll();
    }

    function createAccount($data){
        return $this->accountRepo->create($data);
    }

    function updateAccount($data, $id){
        return $this->accountRepo->update($data, $id);
    }

    function deleteAccount($id){
        return $this->accountRepo->delete($id);
    }

    function searchAccountByAccountName($name){
        return $this->accountRepo->search('user_name', $name);
    }

    function findById($id){
        return $this->accountRepo->findById($id);
    }

    function changePassword($id, $oldPassword, $newPassword){
        $account = $this->accountRepo->findById($id);
        if($account == false){
            return false;
        }else{
            if($account->password == $oldPassword ){
                $account->update(["password" => $newPassword]);
                return true;
            }
            return false;
        }
    }

    function checkPassword($id, $oldPassword){
        $account = $this->accountRepo->findById($id);
        if($account == false){
            return false;
        }else{
            if($account->password == $oldPassword ){
                return true;
            }
            return false;
        }
    }

    function login($user_name, $password){
        $account = $this->accountRepo->findByUsername($user_name);
        if($account){
            if($account->password == $password){
                return $account;
            }
            return false;
        }
        return false;
    }
}
