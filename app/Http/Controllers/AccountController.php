<?php

namespace App\Http\Controllers;;

use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function Pest\Laravel\json;

class AccountController extends Controller
{
    //
    protected $accountService;
    /**
     * Class constructor.
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    function getAllAccount()
    {   
        return response()->json($this->accountService->getAllAccount(), 200);
    }

    function login(Request $request)
    {
        $rules = [
            'user_name' => 'required',
            'password' => 'required',
        ];
        $messages = [
            'user_name.required' => 'Tên người dùng là bắt buộc.',
            'password.required' => 'Trường mật khẩu là bắt buộc.',
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json(["message" => $errors], 422);
        } else {
            $user_name = $request->user_name;
            $password = $request->password;
            
            $account =  $this->accountService->login($user_name, $password);
            if ($account == false) {
                return response()->json(["message" => "Tài khoản hoặc mật khẩu không chính xác", 'account' => null,], 422);
            }
            else{
                return response()->json([
                    'message'=>"Đăng nhập thành công",
                    'account' => $account,
                ], 200);
            }
        }
    }

    function createAccount(Request $request) {
        $rules = [
            'user_name' => 'required|max:200|unique:accounts,user_name',
            'name' => 'required|max:200',
            'password' => 'required',
            'role' => 'required'
        ];
        $messages = [
            'user_name.required' => 'Tên người dùng là bắt buộc.',
            'user_name.max'      => 'Tên người dùng không được vượt quá 200 ký tự.',
            'user_name.unique'   => 'Tên người dùng đã được sử dụng.',
        
            'name.required' => 'Trường tên là bắt buộc.',
            'name.max'      => 'Trường tên không được vượt quá 200 ký tự.',
        
            'password.required' => 'Trường mật khẩu là bắt buộc.',
        
            'role.required' => 'Trường quyền là bắt buộc.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $result = $this->accountService->createAccount($request->all());
        if($result){
            return response()->json(["message" => "Thêm tài khoản thành công", "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Thêm tài khoản thất bại"], 500);
        }
        
    }

    function updateAccount(Request $request, $id) {
        $rules = [
            'user_name' => 'required|max:200',
            'name' => 'required|max:200',
            'password' => 'required',
            'role' => 'required'
        ];
        $messages = [
            'user_name.required' => 'Tên người dùng là bắt buộc.',
            'user_name.max'      => 'Tên người dùng không được vượt quá 200 ký tự.',
        
            'name.required' => 'Trường tên là bắt buộc.',
            'name.max'      => 'Trường tên không được vượt quá 200 ký tự.',
        
            'password.required' => 'Trường mật khẩu là bắt buộc.',
        
            'role.required' => 'Trường quyền là bắt buộc.'
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        
        $newData = [
            "user_name" => $request->user_name,
            "name" => $request->name,
            "role" => $request->role,
            "password" => $request->password,
        ];
        $result = $this->accountService->updateAccount($newData, $id);
        if($result){
            return response()->json(["message" => "Cập nhật tài khoản thành công", "data" => $result], 200);
        }   else {
            return response()->json(["message" => "Cập nhật tài khoản thất bại"], 500);
        }
        
    }

    function deleteAccount($id) {
        $result = $this->accountService->deleteAccount($id);
        if($result){
            return response()->json(["message" => "Xóa tài khoản thành công"], 200);
        }   else {
            return response()->json(["message" => "Xóa tài khoản thất bại"], 500);
        }
        
    } 
    
    function searchAccount(Request $request) {
        $result = $this->accountService->searchAccountByAccountName($request->input('user_name'));
        return response()->json($result, 200);
    }
    
    function finById(Request $request)
    {   
        $result = $this->accountService->findById($request->input('id'));
        return response()->json($result, 200);
    }

    function changePassword(Request $request){
        $result = $this->accountService->changePassword($request->input("id"), $request->input("password"), $request->input("new_password"));
        if($result == true){
            return response()->json(["message" => "Đổi mật khẩu thành công"], 200);
        }else{
            return response()->json(["message" => "Đổi mật khẩu thất bại"], 500);
        }
    }

    function checkPassword(Request $request){
        $result = $this->accountService->checkPassword($request->input("id"), $request->input("password"));
        if($result == true){
            return response()->json(["message" => "Mật khẩu chính xác"], 200);
        }else{
            return response()->json(["message" => "Mật khẩu không chính xác"], 401);
        }
    }

}
