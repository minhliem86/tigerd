<?php
Route::group(['middleware'=>['web'],'namespace' => 'App\Modules\Client\Controllers'], function(){
    Route::get('/san-pham', ['as'=> 'client.product', 'uses' => 'SanPhamController@index' ]);
    Route::post('/addtocart', ['as' => 'client.addToCart', 'uses' => 'SanPhamController@addToCart']);
    Route::get('/payment', ['as' => 'client.payment', 'uses' => 'SanPhamController@payment']);
    Route::get('/addtocart/{id}', ['as' => 'client.addToCart2', 'uses' => 'SanPhamController@addToCart2']);

    Route::get('/promotion', ['as' => 'client.promotion' , 'uses' => 'SanPhamController@getPayment']);
    Route::post('/process-promotion', ['as' => 'client.process.promotion', 'uses' => 'SanPhamController@postPayment']);
    Route::post('/process-promotion2', ['as' => 'process.promotion', 'uses' => 'SanPhamController@applyPromotion']);
});
