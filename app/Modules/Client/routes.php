<?php
Route::group(['middleware'=>['web'],'namespace' => 'App\Modules\Client\Controllers'], function(){
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
    Route::get('/san-pham', ['as' => 'client.product.showAll', 'uses' => 'ProductController@getAllProduct']);
    Route::get('/san-pham/{slug}', ['as' => 'client.product', 'uses' => 'ProductController@getProduct'])->where('slug','[0-9a-zA-Z._\-]+');
    Route::post('/san-pham/addToCart', ['as' => 'client.product.addToCart', 'uses' => 'ProductController@addToCart']);
    Route::post('/ajaxAttributeValue', ['as' => 'client.product.ajaxChangeAttributeValue', 'uses' => 'ProductController@ajaxChangeAttributeValue']);

    Route::get('/gio-hang', ['as' => 'client.cart', 'uses' => 'ProductController@getCart']);
    Route::post('/update-soluong', ['as' => 'client.cart.updateQuantity', 'uses' => 'ProductController@updateQuantityAjax' ]);
    Route::post('/remove-item', ['as' => 'client.cart.removeItem', 'uses' => 'ProductController@removeItemCart']);
    Route::post('/them-gio-hang-ajax', ['as' => 'client.cart.addToCartAjax', 'uses' => 'ProductController@addToCartAjax']);
    Route::get('/xoa-gio-hang',['as' => 'client.cart.clear', 'uses' => 'ProductController@clearCart']);

    Route::get('/thanh-toan', ['as' => 'client.payment', 'uses' => 'ProductController@getPayment']);
    Route::post('/process-promotion', ['as' => 'client.promotion', 'uses' => 'ProductController@applyPromotion']);
    Route::post('/doPayment', ['as' => 'client.doPayment', 'uses' => 'ProductController@doPayment']);
    Route::get('/responsePayment', ['as' => 'client.responsePayment', 'uses' => 'ProductController@responseFormOnePay']);

    Route::get('/thanh-toan-thanh-cong', ['as' => 'client.payment_success.thank','uses' => 'ProductController@getThankyou']);

    /*ORDER DETAIL*/
    Route::get('/don-hang/{id}', ['as' => 'client.order_detail', 'uses'=> 'ProfileController@getInvoke'])->where('id','[0-9a-zA-Z._\-]+');

    /*SUBCRIBE EMAIL*/
    Route::post('/subcribe',['as' => 'client.subcribe.post', 'uses' => 'ExtensionController@postSubscribe']);
    Route::post('/subcribe-header',['as' => 'client.subcribe-header.post', 'uses' => 'ExtensionController@postSubscribeHeader']);


    /*SEARCH*/
    Route::post('/search', ['as' => 'client.search.post', 'uses' => 'ExtensionController@postSearch']);


    /*CUSTOMER*/
    Route::get('/dang-nhap', ['as' => 'client.auth.login', 'uses' => 'Auth\AuthController@getLogin']);
    Route::post('/dang-nhap', ['as' => 'client.auth.login.post', 'uses' => 'Auth\AuthController@postLogin']);
    Route::post('/dang-ky', ['as' => 'client.auth.register.post', 'uses' => 'Auth\AuthController@postRegister']);

    // Password Reset Routes...
    Route::get('password/reset/{token?}',['as'=> 'client.password.reset.getForm', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email',['as' => 'client.password.email.post', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', 'Auth\PasswordController@reset');

    Route::get('/thong-tin-khach-hang', ['as'=> 'client.auth.profile', 'uses' => 'ProfileController@getProfile']);
    Route::post('/update-profile', ['as' => 'client.auth.profile.post', 'uses' => 'ProfileController@postProfile']);

    Route::post('/changePassword', ['as' => 'client.auth.changePassword.post', 'uses' => 'ProfileController@postChangePassword']);

    Route::get('/dang-xuat', ['as' => 'client.auth.logout', 'uses' => 'Auth\AuthController@logout']);

    Route::get('/{slug}', ['as'=>'client.single_page', 'uses'=>'SingleController@index'])->where('slug', '[0-9a-zA-Z._\-]+');

    Route::post('/payment/getDistrict', ['as' => 'client.post.getDistrict', 'uses' => 'ProductController@getDistrict']);
    Route::post('/payment/getWard', ['as' => 'client.post.getWard', 'uses' => 'ProductController@getWard']);

});
