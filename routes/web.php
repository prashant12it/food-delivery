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
Route::get('/books', ['as'=>'books','uses'=>'HomeController@books']);
Route::get('/shop-grid', ['as'=>'shop.grid','uses'=>'HomeController@shop']);
Route::get('/shop-details', ['as'=>'shop.details','uses'=>'HomeController@shopDetails']);

Route::get('/category/{slug}', ['as'=>'category','uses'=>'HomeController@categories']);
Route::get('/product/{slug}', ['as'=>'product','uses'=>'HomeController@productDetails']);
Route::get('/my-cart', ['as'=>'product','uses'=>'HomeController@myCart']);
Route::post('/get_subcategories', ['as'=>'subcategories','uses'=>'HomeController@subcategories']);
Route::post('/remove_cart_item', ['as'=>'removeCartItem','uses'=>'HomeController@removeCartItem']);

Route::group(['middleware' => 'customerAuth'], function () {
Route::post('/add_to_cart', ['as' => 'addToCart', 'uses' => 'HomeController@add_to_cart']); 
Route::get('/cart-checkout', ['as'=>'checkout','uses'=>'HomeController@checkout']);
Route::post('/update_cart', ['as' => 'updateCart', 'uses' => 'HomeController@update_cart']);
Route::post('/place_order', ['as' => 'placeOrder', 'uses' => 'HomeController@place_order']);
Route::post('/payment', ['as' => 'payment', 'uses' => 'HomeController@payment']);
Route::get('/thanks', ['as' => 'thanks', 'uses' => 'HomeController@thanks']);

});

Route::post('/login',['as'=>'login','uses'=>'Admin\UserController@login']);
Route::post('/store_user',['as'=>'signup','uses'=>'Admin\UserController@store_user']);
Route::get('/front-logout',['as'=>'frontLogout','uses'=>'HomeController@logout']);

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
    Route::get('/admin/orders',['as'=>'list.orders','uses'=>'Admin\OrdersController@index']);
    Route::post('/admin/change_order_status',['as'=>'change.order.status','uses'=>'Admin\OrdersController@changeStatus']);
    Route::get('/admin/order_details/{id}',['as'=>'order.details','uses'=>'Admin\OrdersController@order_details']);

});
require __DIR__.'/auth.php';
