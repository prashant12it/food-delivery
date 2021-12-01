<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
    return view('welcome');
});

Route::get('/admin/dashboard', function () {

    View::share('title', 'Admin dashboard');
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/add_category',['as'=>'category.add','uses'=>'Admin\CategoryController@add_category']);
    Route::post('/admin/category_store',['as'=>'category.store','uses'=>'Admin\CategoryController@store_category']);
    Route::post('/admin/brand_store',['as'=>'brand.store','uses'=>'Admin\BrandController@store']);
    Route::get('/admin/add_brand',['as'=>'brand.add','uses'=>'Admin\BrandController@add_brand']);
});
require __DIR__.'/auth.php';
