<?php

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

// site's index page
Route::get('/', "SiteController@index");

// Admin's idnex
Route::get('admin', function () {
    return view('admin.index');
});

// Category
Route::resource('admin/category','admin\CategoryController');

// Slider
Route::resource('admin/slider','admin\SliderController');

// Product
Route::resource('admin/product', 'admin\ProductController');
Route::get('admin/product/gallery/{id}', 'admin\ProductController@gallery');
Route::post('admin/product/upload/{id}', 'admin\ProductController@upload');
Route::delete('admin/product/deleteImage/{img}', 'admin\ProductController@deleteImage');
// Except 'delete', Drop all other methods (stack:18326030)
Route::match(array('GET', 'POST', 'HEAD', 'PUT', 'PATCH'), 'admin/product/deleteImage/{img}', function()
{
    return abort(404);
});

Route::get('/categoryTree', "SiteController@categoryTree");

// Filter
Route::get('admin/filter' , 'admin\FilterController@index');
Route::post('admin/filter', 'admin\FilterController@create');
