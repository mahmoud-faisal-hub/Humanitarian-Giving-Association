<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GalaryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NewsAttachmentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Authentication Routes...
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', [HomeController::class, 'index'])->name("home");

    Route::get('/category/search', [CategoryController::class, 'search'])->name('admin.category.search');
    Route::resource('/category', CategoryController::class);

    Route::get('/news/search/{category_id?}', [NewsController::class, 'search'])->name('admin.news.search');
    Route::resource('/news', NewsController::class)->except(['show']);

    Route::get('/galary/search', [GalaryController::class, 'search'])->name('admin.galary.search');
    Route::resource('/galary', GalaryController::class);

    Route::get('/message', [MessageController::class, 'index'])->name('admin.message.index');
    Route::get('/message/search', [MessageController::class, 'search'])->name('admin.message.search');
    Route::get('/message/{id}', [MessageController::class, 'show'])->name('admin.message.show');
    Route::delete('/message/{id}', [MessageController::class, 'destroy'])->name('admin.message.destroy');

    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
    Route::put('/admin/{admin}/updateImage', [AdminController::class, 'updateImage'])->name('admin.update.image');
    Route::put('/admin/{admin}/updatePermissions', [AdminController::class, 'updatePermissions'])->name('admin.update.permissions');
    Route::resource('/admin', AdminController::class);

    Route::get('/role/search', [RoleController::class, 'search'])->name('role.search');
    Route::resource('/role', RoleController::class);
});
