<?php

use App\Http\Controllers\api\CampaignsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CitiesController;
use App\Http\Controllers\api\DiscountsController;
use App\Http\Controllers\api\GroupsController;
use App\Http\Controllers\api\ProductsController;

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
Route::name('api')->group(function (){
    Route::resource('/cities', CitiesController::class);
    Route::resource('/groups', GroupsController::class);
    Route::resource('/campaigns', CampaignsController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/discounts', DiscountsController::class);
});