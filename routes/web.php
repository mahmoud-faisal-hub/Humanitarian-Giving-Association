<?php

use App\Http\Controllers\CKeditorController;
use App\Http\Controllers\FilepondController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ContactController;
use App\Http\Controllers\Web\GalaryController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\NewsController;
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

Route::get('/', [HomeController::class, 'index']) -> name("web.home");

Route::get('/categories', [CategoryController::class, 'index']) -> name("web.categories.show");
Route::get('/category/{id}', [CategoryController::class, 'show']) -> name("web.category.show");

Route::get('/news/search/', [NewsController::class, 'search']) -> name("web.news.search");
Route::get('/news/{id}', [NewsController::class, 'show']) -> name("web.news.show");

Route::get('/galary/{type?}', [GalaryController::class, 'index'])->name('web.galary.index');

Route::post('/message', [MessageController::class, 'store'])->name('web.message.store');

Route::get('/contact', [ContactController::class, 'index'])->name('web.contact.index');


Route::get('filepond/load/{name}', [FilepondController::class, 'load'])->name('filepond-load');
Route::post('/ckeditor', [CKeditorController::class, 'store'])->name('ckeditor');
