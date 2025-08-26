<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MyTaskController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleApiController;
use App\Http\Controllers\ConselingMethodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/conselors/{conselor}/methods', [ScheduleApiController::class, 'getMethods']);
Route::get('/available-dates/{id}', [ScheduleApiController::class, 'availableDates']);
Route::get('/schedules/{id}/{date}', [ScheduleApiController::class, 'availableTimes']);


// Hanya route manual
Route::get('/checkout/payment/{order_uuid}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::put('/checkout/{order_uuid}', [CheckoutController::class, 'update'])->name('checkout.update');


// Endpoint AJAX untuk ambil jadwal
Route::get('/schedules/{conselor}/{date}', [ScheduleController::class, 'getSchedules']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('product', ProductController::class)->names('product');
    Route::resource('user', UserController::class)->names('user');
    Route::get('user/{user}/schedule', [UserController::class, 'schedule'])->name('user.schedule');
    Route::resource('order', OrderController::class)->names('order');
    

    Route::resource('method', ConselingMethodController::class)->names('method');
    Route::resource('schedule', ScheduleController::class)->names('schedule');
    Route::delete('/schedules/day/{date}', [ScheduleController::class, 'destroyByDate'])->name('schedule.destroyByDate');

    Route::resource('my-order', MyOrderController::class)->names('myorder');
    Route::get('/my-task/all', [MyTaskController::class, 'all'])->name('mytask.all');
    Route::get('/my-task', [MyTaskController::class, 'index'])->name('mytask.index');
    Route::get('/my-task/{order_uuid}', [MyTaskController::class, 'show'])->name('mytask.show');
    // Route::resource('my-task', MyTaskController::class)->names('mytask');


    

});

require __DIR__.'/auth.php';
