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

Route::get('/', ['as'=>'home','uses'=>'HomeController@index']);
Route::get('/category/{slug}', ['as'=>'category','uses'=>'HomeController@categories']);

Route::get('/admin/dashboard', function () {

    View::share('title', 'Admin dashboard');
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/add_category',['as'=>'category.add','uses'=>'Admin\CategoryController@add_category']);
    Route::get('/admin/edit_category/{id}',['as'=>'category.edit','uses'=>'Admin\CategoryController@edit_category']);
    Route::get('/admin/add_subcategory/{id}',['as'=>'category.sub','uses'=>'Admin\CategoryController@add_subcategory']);
    Route::get('/admin/delete_category/{id}',['as'=>'category.delete','uses'=>'Admin\CategoryController@delete_category']);

    Route::post('/admin/category_store/{id}',['as'=>'category.store','uses'=>'Admin\CategoryController@store_category']);
    Route::post('/admin/brand_store/{id}',['as'=>'brand.store','uses'=>'Admin\BrandController@store']);
    Route::get('/admin/add_brand',['as'=>'brand.add','uses'=>'Admin\BrandController@add_brand']);
    Route::get('/admin/edit_brand/{id}',['as'=>'brand.edit','uses'=>'Admin\BrandController@edit_brand']);
    Route::get('/admin/delete_brand/{id}',['as'=>'brand.delete','uses'=>'Admin\BrandController@delete_brand']);


    Route::post('/admin/product_store/{id}',['as'=>'product.store','uses'=>'Admin\ProductController@store']);
    Route::get('/admin/add_product',['as'=>'product.add','uses'=>'Admin\ProductController@add_product']);
    Route::get('/admin/edit_product/{id}',['as'=>'product.edit','uses'=>'Admin\ProductController@edit_product']);
    Route::get('/admin/delete_product/{id}',['as'=>'product.delete','uses'=>'Admin\ProductController@delete_product']);

});
require __DIR__.'/auth.php';
