<?php

use App\Http\Controllers\FeedController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/feed', [FeedController::class, 'edit'])
        ->name('feed.edit');
    Route::view('/make_post', 'make_post')
        ->name('make_post');
    Route::get('/posts', [PostController::class, 'edit'])
        ->name('posts.edit');
    Route::patch('/posts', [PostController::class, 'update'])
        ->name('posts.update');
    Route::delete('/posts', [PostController::class, 'destroy'])
        ->name('posts.destroy');
    Route::get('/friends', [FriendController::class, 'edit'])
        ->name('friends.edit');
    Route::patch('/friends', [FriendController::class, 'update'])
        ->name('friends.update');
    Route::delete('/friends', [FriendController::class, 'destroy'])
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