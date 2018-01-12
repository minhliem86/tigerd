<?php
Route::group(['middleware'=>['web'],'namespace' => 'App\Modules\Client\Controllers'], function(){
    Route::get('/san-pham', ['as'=> 'client.product', 'uses' => 'SanPhamController@index' ]);
    Route::post('/addtocart', ['as' => 'client.addToCart', 'uses' => 'SanPhamController@addToCart']);

    Route::get('/cart', ['as' => 'client.cart', 'uses' => 'SanPhamController@getCart']);
    Route::get('/cart-remove/{id}', ['as' => 'client.cart.remove', 'uses' => 'SanPhamController@getCartRemove']);
    Route::get('/cart-removeAll', ['as' => 'client.cart.removeAll', 'uses' => 'SanPhamController@getCartRemoveAll']);
    Route::get('/payment', ['as' => 'client.payment', 'uses' => 'SanPhamController@payment']);
    Route::post('/process-promotion', ['as' => 'client.promotion', 'uses' => 'SanPhamController@applyPromotion']);
    Route::get('/addtocart/{id}', ['as' => 'client.addToCart2', 'uses' => 'SanPhamController@addToCart2']);

    Route::post('/doPayment', ['as' => 'client.doPayment', 'uses' => 'SanPhamController@doPayment']);
    Route::get('/responsePayment', ['as' => 'client.responsePayment', 'uses' => 'SanPhamController@responseFormOnePay']);
});
