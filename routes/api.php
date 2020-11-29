<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//for transaction
Route::get('/transaction/project','ApiTransactionController@project');
Route::get('/transaction/category','ApiTransactionController@category');
Route::get('/transaction/voucher','ApiTransactionController@vouchar');
Route::post('add_transactions',[
    'as' => 'addTransactions',
    'uses'=>'TransactionsController@addTransactions'
]);

//for Salary
Route::get('/employee/salary/{id}','ApiSalaryController@index');
Route::post('/employee/salary/{id}','ApiSalaryController@store');
