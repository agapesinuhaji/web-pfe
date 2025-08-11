<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ConselingMethodController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});

Route::get('/checkout', function () {
    return view('orders.checkout');
});

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
});

require __DIR__.'/auth.php';
