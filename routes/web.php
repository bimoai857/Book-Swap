<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ProfileController;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

Route::get('/dashboard', [ProfileController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('mybooks',[ProfileController::class,'mybooks'])->name('mybooks');
Route::get('/notifications', [ProfileController::class,'notification'])->middleware(['auth', 'verified'])->name('notifications');
Route::get('/addNewBooks',function(){ return view('addNewBooks');});
Route::post('/add',[ProfileController::class,'add']);
Route::post('/search',[ProfileController::class,'search'])->name('search');
Route::get('/swapView/{id}/{bookID}',[ProfileController::class,'swapView'])->name('swapView');

Route::post('/sendNotification/{id}/{RRC}/book/{bookID?}',[ProfileController::class,'sendNotification'])->name('sendNotification.test');
Route::post('/sendNotification/{id}/{RRC}/notification/{notID?}',[ProfileController::class,'sendNotification'])->name('sendNotification');
Route::post('/sendNotification/{id}/{RRC}/notification/{notID?}/book/{bookID?}/',[ProfileController::class,'sendNotification'])->name('sendNotification');