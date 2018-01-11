<?php
Route::group(['middleware'=>['web'],'namespace' => 'App\Modules\Client\Controllers'], function(){
    Route::get('/san-pham', ['as'=> 'client.product', 'uses' => 'SanPhamController@index' ]);
    Route::post('/addtocart', ['as' => 'client.addToCart', 'uses' => 'SanPhamController@addToCart']);
    Route::get('/payment', ['as' => 'client.payment', 'uses' => 'SanPhamController@payment']);
    Route::post('/process-promotion', ['as' => 'client.promotion', 'uses' => 'SanPhamController@applyPromotion']);
    Route::get('/addtocart/{id}', ['as' => 'client.addToCart2', 'uses' => 'SanPhamController@addToCart2']);
});
