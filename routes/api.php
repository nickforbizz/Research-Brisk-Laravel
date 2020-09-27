<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ____________________________Routes Accessible To Public_____________________________________________________

// ******************** BASICS *************************************************
Route::get('/fetch_users', 'apiAuth\ApiAuthController@index')->name('users');
Route::get('/get_user/{id}', 'apiAuth\ApiAuthController@show')->name('user');
Route::post('/login', 'apiAuth\ApiAuthController@login')->name('login');


// ******************** ACADEMICS *************************************************
// order cats
Route::get('/fetch_order_cats', 'Orders\orderCatController@index')->name('orderCats');
Route::get('/get_order_cat/{id}', 'Orders\orderCatController@show')->name('orderCat');

// order formats
Route::get('/fetch_order_formats', 'Orders\orderFormatController@index')->name('orderFormats');
Route::get('/get_order_format/{id}', 'Orders\orderFormatController@show')->name('orderFormat');

// order langs
Route::get('/fetch_order_langs', 'Orders\orderLangController@index')->name('orderLangs');
Route::get('/get_order_lang/{id}', 'Orders\orderLangController@show')->name('orderLang');

// order
Route::get('/fetch_order_prices', 'Orders\orderPricingController@index')->name('orderPrices');
Route::get('/get_order_price/{id}', 'Orders\orderPricingController@show')->name('orderPrice');

Route::get('/order_miscs', 'Orders\orderController@miscs')->name('orderMiscs');


// ******************** BLOGS *************************************************
//cats
Route::get('/fetch_blog_cats', 'Blogs\blogCatController@index')->name('blogCats');
Route::get('/get_blog_cat/{id}', 'Blogs\blogCatController@show')->name('blogCat');

//blogs
Route::get('/fetch_blog', 'Blogs\blogController@index')->name('blogs');
Route::get('/fetch_recent_blog', 'Blogs\blogController@recentBlogs')->name('recentBlogs');
Route::get('/get_blog/{id}', 'Blogs\blogController@show')->name('blog');

//comments
Route::get('/fetch_blog_comments', 'Blogs\blogCommentController@index')->name('blogComments');
Route::get('/get_blog_comment/{id}', 'Blogs\blogCommentController@show')->name('blogComment');
Route::post('/post_blog_comment', 'Blogs\blogCommentController@store')->name('createBlogComment');



Route::middleware('auth:api')->group(function (){

    // _________________________________________________ ACADEMIC ___________________________________________________
    // Categories
    Route::post('/post_order_cat', 'Orders\orderCatController@store')->name('createOrderCat');
    Route::post('/patchOrder_cat/{id}', 'Orders\orderCatController@update')->name('updateOrderCat');
    Route::post('/delOrder_cat/{id}', 'Orders\orderCatController@destroy')->name('delOrderCat');

    // Formats
    Route::post('/post_order_format', 'Orders\orderFormatController@store')->name('createOrderFormat');
    Route::post('/patchOrder_format/{id}', 'Orders\orderFormatController@update')->name('updateOrderFormat');
    Route::post('/delOrder_format/{id}', 'Orders\orderFormatController@destroy')->name('delOrderFormat');

    // Languages
    Route::post('/post_order_lang', 'Orders\orderLangController@store')->name('createOrderLang');
    Route::post('/patchOrder_lang/{id}', 'Orders\orderLangController@update')->name('updateOrderLang');
    Route::post('/delOrder_lang/{id}', 'Orders\orderLangController@destroy')->name('delOrderLang');

     // Order Prices
     Route::post('/post_order_price', 'Orders\orderPricingController@store')->name('createOrderPrice');
     Route::post('/patchOrder_price/{id}', 'Orders\orderPricingController@update')->name('updateOrderPrice');
     Route::post('/delOrder_price/{id}', 'Orders\orderPricingController@destroy')->name('delOrderPrice');

    // Order
    Route::get('/fetch_orders', 'Orders\orderController@index')->name('orders');
    Route::get('/get_order/{id}', 'Orders\orderController@show')->name('order');
    Route::post('/post_order', 'Orders\orderController@store')->name('createOrder');
    Route::post('/patchOrder/{id}', 'Orders\orderController@update')->name('updateOrder');
    Route::post('/delOrder/{id}', 'Orders\orderController@destroy')->name('delOrder');

    


    // _________________________________________________ BLOGS ___________________________________________________
    // Categories
    Route::post('/post_blog_cat', 'Blogs\blogCatController@store')->name('createBlogCat');
    Route::post('/patchBlog_cat/{id}', 'Blogs\blogCatController@update')->name('updateBlogCat');
    Route::post('/delBlog_cat/{id}', 'Blogs\blogCatController@destroy')->name('delBlogCat');

    // Blogs
    Route::post('/post_blog', 'Blogs\blogController@store')->name('createBlog');
    Route::post('/patchBlog/{id}', 'Blogs\blogController@update')->name('updateBlog');
    Route::post('/delBlog/{id}', 'Blogs\blogController@destroy')->name('delBlog');

    // Comments
    Route::post('/patchBlog_comment/{id}', 'Blogs\blogCommentController@update')->name('updateBlogComment');
    Route::post('/delBlog_comment/{id}', 'Blogs\blogCommentController@destroy')->name('delBlogComment');



}); 