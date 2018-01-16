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

    Route::get('/', ['as' => 'client.home', 'uses' => 'HomeController@index']);

    /*CONTACT US*/
    Route::get('/lien-he', ['as' => 'client.contact', 'uses' => 'ContactController@getIndex']);
    Route::post('/lien-he', ['as' => 'client.contact.post', 'uses' => 'ContactController@postIndex']);
    Route::get('/cam-on-khach-hang', ['as' => 'client.contact.thankyou', 'uses' => 'ContactController@getThankyou']);

    /*NEWS*/
    Route::get('/tin-tuc', ['as' => 'client.news', 'uses' => 'NewsController@getIndex']);
    Route::get('/tin-tuc/{slug}', ['as' => 'client.news.detail', 'uses' => 'NewsController@getDetail'])->where('slug', '[0-9a-zA-Z._\-]+');

    /*PRODUCT*/
    Route::get('/danh-muc/{slug}', ['as' => 'client.category', 'uses' => 'ProductController@getCategory'])->where('slug','[0-9a-zA-Z._\-]+');
    Route::get('/san-pham/{slug}', ['as' => 'client.product', 'uses' => 'ProductController@getProduct'])->where('slug','[0-9a-zA-Z._\-]+');
    Route::post('/san-pham/addToCart', ['as' => 'client.product.addToCart', 'uses' => 'ProductController@addToCart']);


    Route::get('/{slug}', ['as'=>'client.single_page', 'uses'=>'SingleController@index'])->where('slug', '[0-9a-zA-Z._\-]+');
});
