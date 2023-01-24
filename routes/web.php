<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendRequestController;
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
    Route::view('/friends', 'friends')
        ->name('friends');
    Route::get('/friend_requests', [FriendRequestController::class, 'view'])
        ->name('friend_requests.view');
    Route::patch('/friend_requests', [FriendRequestController::class, 'add'])
        ->name('friend_requests.add');
    Route::delete('/friend_requests', [FriendRequestController::class, 'delete'])
        ->name('friend_requests.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
