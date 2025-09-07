<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\DestroyController;
use App\Http\Controllers\WeightController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SalesForecastController;
use App\Http\Controllers\ScheduleController;
use Laravel\Fortify\Fortify;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

// 管理職向け商品管理
Route::resource('products', ProductController::class);

// スタッフ向けレシピ参照（読み取り専用）
Route::resource('specs', SpecController::class)->only(['index', 'show']);
Route::resource('ingredients', IngredientController::class);
Route::resource('volumes', VolumeController::class);
Route::resource('destroys', DestroyController::class);
Route::resource('weights', WeightController::class);
Route::resource('sales', SaleController::class);
Route::resource('sales_forecasts', SalesForecastController::class);
Route::resource('schedules', ScheduleController::class);
