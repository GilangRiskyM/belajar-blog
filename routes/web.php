<?php

use App\Http\Controllers\Back\BlogController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Front\BlogController as FrontBlogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontBlogController::class, 'index']);
Route::get('/berita/{slug}', [FrontBlogController::class, 'show']);

Route::get('/dashboard', function () {
    return view('back.dashboard');
})->middleware(['auth', 'verified', 'blocked'])->name('dashboard');

//Back
Route::middleware(['auth', 'verified', 'blocked'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route Blog
    Route::resource('blogs', BlogController::class)->names([
        'index' => 'blog.index',
        'create' => 'blog.create',
        'store' => 'blog.store',
        'edit' => 'blog.edit',
        'update' => 'blog.update',
        'destroy' => 'blog.destroy',
    ]);
    Route::get('/blogs/{blog}/delete', [BlogController::class, 'delete'])->name('blog.delete');

    //Route USER
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy'
    ]);

    //Halaman delete USER
    Route::get('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

    //Blokir USER
    Route::get('/users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block')->middleware('role_or_permission:admin-user');
});

require __DIR__ . '/auth.php';
