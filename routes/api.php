<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillDetailController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WaiterNotificationController;
use Illuminate\Support\Facades\Route;

//login
Route::post('/login',[AccountController::class, 'login']);


//account section
Route::get('/account/all-account',[AccountController::class, 'getAllAccount']);
Route::post('/account/create-account',[AccountController::class, 'createAccount']);
Route::post('/account/update-account/{id}',[AccountController::class, 'updateAccount']);
Route::post('/account/delete-account/{id}',[AccountController::class, 'deleteAccount']);
Route::get('/account/search-account',[AccountController::class, 'searchAccount']);
Route::get('/account/find-account',[AccountController::class, 'finById']);
Route::post('/account/change-password',[AccountController::class, 'changePassword']);
Route::post('/account/check-password',[AccountController::class, 'checkPassword']);

//table section
Route::get('/table/all-table',[TableController::class, 'getAllTable']);
Route::post('/table/create-table',[TableController::class, 'createTable']);
Route::post('/table/update-table/{id}',[TableController::class, 'updateTable']);
Route::post('/table/delete-table/{id}',[TableController::class, 'deleteTable']);
Route::get('/table/search-table',[TableController::class, 'searchTable']);
Route::get('/table/find-table',[TableController::class, 'finById']);
Route::get('/table/find-table-status',[TableController::class, 'findTableByStatus']);

//category section
Route::get('/category/all-category',[CategoryController::class, 'getAllCategory']);
Route::post('/category/create-category',[CategoryController::class, 'createCategory']);
Route::post('/category/update-category/{id}',[CategoryController::class, 'updateCategory']);
Route::post('/category/delete-category/{id}',[CategoryController::class, 'deleteCategory']);
Route::get('/category/find-category',[CategoryController::class, 'finById']);
Route::get('/category/food-category',[CategoryController::class, 'getFoodByCategory']);

//food section
Route::get('/food/all-food',[FoodController::class, 'getAllFood']);
Route::post('/food/create-food',[FoodController::class, 'createFood']);
Route::post('/food/update-food/{id}',[FoodController::class, 'updateFood']);
Route::post('/food/delete-food/{id}',[FoodController::class, 'deleteFood']);
Route::get('/food/find-food',[FoodController::class, 'finById']);
Route::get('/food/search-food',[FoodController::class, 'searchFood']);
Route::get('/food/top-food',[FoodController::class, 'getTopFoodQuantitySold']);


//order section
Route::get('/order/get-order-by-table-status',[OrderController::class,'getOrderByTableAndStatus']);
Route::post('/order/create-order',[OrderController::class, 'createOrder']);
Route::post('/order/update-order/{id}',[OrderController::class, 'updateOrder']);
Route::post('/order/delete-new-order',[OrderController::class, 'deleteNewOrder']);
Route::post('/order/delete-order',[OrderController::class, 'deleteOrder']);
Route::post('/order/delete-order-by-table',[OrderController::class, 'deleteOrderByTableName']);
Route::get('/order/get-order-by-table',[OrderController::class, 'getOrderByTable']);
Route::get('/order/all-order',[OrderController::class, 'getAllOrder']);
Route::get('/order/get-order-by-status',[OrderController::class, 'getOrderByStatus']);

//bill section
Route::get('/bill/all-bill',[BillController::class,'getAllBill']);
Route::post('/bill/create-bill',[BillController::class, 'createBill']);
Route::post('/bill/update-bill/{id}',[BillController::class, 'updateBill']);
Route::post('/bill/delete-bill/{id}',[BillController::class, 'deleteBill']);
Route::get('/bill/find-bill',[BillController::class, 'finById']);
Route::get('/bill/bill-today',[BillController::class, 'getBillsToday']);
Route::get('/bill/weekly-revenue',[BillController::class, 'getRevenueByDayInWeek']);
Route::get('/bill/monthly-revenue',[BillController::class, 'getRevenueByMonthInYear']);
Route::get('/bill/year-revenue',[BillController::class, 'getRevenueByYear']);

//waiter notification section
Route::get('/waiter-notification/all-notification',[WaiterNotificationController::class, 'getAllWaiterNotification']);
Route::post('/waiter-notification/create-notification',[WaiterNotificationController::class, 'createWaiterNotification']);
Route::post('/waiter-notification/delete-notification/{id}',[WaiterNotificationController::class, 'deleteWaiterNotification']);




