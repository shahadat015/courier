<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShopController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RiderController;
use App\Http\Controllers\Api\ParcelController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BankAccountController;
use App\Http\Controllers\Api\PickupRequestController;
use App\Http\Controllers\Api\WithdrowRequestController;

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

Route::get('settings', [SettingsController::class, 'index']);

Route::group([ 'middleware' => 'auth:sanctum' ], function () {
    Route::get('analytics', [DashboardController::class, 'index']);
    Route::get('user', [UserController::class, 'show']);
    Route::post('update/profile', [UserController::class, 'update']);
    Route::get('get-merchants', [ParcelController::class, 'getMerchants']);
    Route::post('trackings/{parcel}', [ParcelController::class, 'storeTracking']);
    Route::get('parcels/{merchant}/merchant', [ParcelController::class, 'getParcelsByMerchant']);
    Route::post('payments/store', [PaymentController::class, 'store']);
    Route::get('payments/{merchant}/merchant', [PaymentController::class, 'index']);
    Route::get('payments/{payment}', [PaymentController::class, 'show']);
    Route::get('get-parcels', [RiderController::class, 'getParcels']);
    Route::post('parcels/{rider}/assign', [RiderController::class, 'assignParcels']);
    Route::get('parcels/{rider}/rider', [RiderController::class, 'getParcelsByRider']);
    Route::get('rider/parcels/{riderParcel}', [RiderController::class, 'getRiderParcel']);
    Route::post('rider/parcels/{riderParcel}', [RiderController::class, 'updateRiderParcel']);
    Route::get('get-parcels/{merchant}', [PaymentController::class, 'geParcels']);
    Route::post('shops/{merchant}/merchant', [ShopController::class, 'store']);
    Route::post('bank-account/{merchant}/merchant', [BankAccountController::class, 'store']);
    Route::post('settings', [SettingsController::class, 'update']);
    Route::apiResources([
        'withdrow-requests' => WithdrowRequestController::class,
        'pickup-requests' => PickupRequestController::class,
        'riders' => RiderController::class,
        'merchants' => MerchantController::class,
        'parcels' => ParcelController::class,
    ]);
});

