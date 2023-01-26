<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome')
    ->name('welcome');

Route::middleware('auth')->group(function () {
    Route::view('/feed', 'feed')
        ->name('feed');
    Route::view('/posts', 'posts')
        ->name('posts');
    Route::get('/friends', [FriendController::class, 'edit'])
        ->name('friends.edit');
    Route::patch('/add_friend', [FriendController::class, 'update'])
        ->name('friends.update');
    Route::delete('/remove_friend', [FriendController::class, 'destroy'])
        ->name('friends.destroy');
    Route::get('/friend_requests', [FriendRequestController::class, 'edit'])
        ->name('friend_requests.edit');
    Route::patch('/friend_requests', [FriendRequestController::class, 'update'])
        ->name('friend_requests.update');
    Route::delete('/friend_requests', [FriendRequestController::class, 'destroy'])
        ->name('friend_requests.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';