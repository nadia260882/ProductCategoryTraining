<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\ProductImageController; 
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

Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/register', function () {
    return view('register');
})->name('register');


Route::get('/main', 'LoginController@index');
Route::post('/main/checklogin',[LoginController::class,'checklogin'])->name('checklogin');
Route::post('/main/successlogin',[LoginController::class,'successlogin'])->name('successlogin');
Route::get('main/logout',[LoginController::class,'logout'])->name('logout');


Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
Route::post('/categories/getCategories', [CategoriesController::class, 'getCategories'])->name('getCategories');
Route::get('/categories/add', [CategoriesController::class, 'create'])->name('catadd');
Route::post('/categories/store', [CategoriesController::class, 'store'])->name('catstore');
Route::get('/categories/edit/{id}', [CategoriesController::class, 'edit'])->name('catedit');
Route::get('/categories/delete/{id}', [CategoriesController::class, 'delete'])->name('catdelete');



Route::get('products', [ProductController::class, 'index'])->name('products');
Route::post('/products/getProducts', [ProductController::class, 'getProducts'])->name('getProducts');
Route::get('/products/add', [ProductController::class, 'create'])->name('productadd');
Route::post('/products/store', [ProductController::class, 'store'])->name('productstore');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('productedit');
Route::get('/products/delete/{id}', [ProductController::class, 'delete'])->name('productdelete');


Route::post('productImages/upload', [ProductImageController::class, 'saveImg'])->name('uploadImage');





