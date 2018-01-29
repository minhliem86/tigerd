<?php
Route::group(['prefix' => 'admin', 'namespace' => 'App\Modules\Admin\Controllers'], function(){
  // Authentication Routes...
  Route::group(['middleware'=>['web']], function(){

    Route::get('login', 'Auth\AuthController@showLoginForm');
    Route::post('login', 'Auth\AuthController@login');
    Route::get('logout', 'Auth\AuthController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\AuthController@showRegistrationForm');
    Route::post('register', 'Auth\AuthController@register');

    // Password Reset Routes...
    Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\PasswordController@reset');

    // Change Password
    Route::post('/changePass', ['as' => 'admin.changePass.postChangePass', 'uses'=>'ProfileController@postChangePass']);

    /*ROLE, PERMISSION*/
    Route::get('/create-role', ['as' => 'admin.createRole', 'uses' => 'Auth\RoleController@createRole']);
    Route::post('/create-role', ['as' => 'admin.postCreateRole', 'uses' => 'Auth\RoleController@postCreateRole']);
    Route::post('/ajax-role', ['as' => 'admin.ajaxCreateRole', 'uses' => 'Auth\RoleController@postAjaxRole']);
    Route::post('/ajax-permission', ['as' => 'admin.ajaxCreatePermission', 'uses' => 'Auth\RoleController@postAjaxPermission']);

    Route::group(["middleware" => "can_login"], function(){

        Route::get('dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
        //   PORFILE
        Route::get('/profile', ['as' => 'admin.profile.index', 'uses' => 'ProfileController@index']);

        /*USER MANAGEMENT*/
        Route::get('user/getData', ['as' => 'admin.user.getData', 'uses' => 'UserManagementController@getData']);
        Route::post('user/deleteAll', ['as' => 'admin.user.deleteAll', 'uses' => 'UserManagementController@deleteAll']);
        Route::post('user/updateStatus', ['as' => 'admin.user.updateStatus', 'uses' => 'UserManagementController@updateStatus']);
        Route::post('user/createUserByAdmin', ['as' => 'admin.user.createByAdmin', 'uses' => 'Auth\AuthController@registerByAdmin']);
        Route::resource('/user','UserManagementController');

        // MULTI PHOTOs
        Route::get('photo', ['as'=>'admin.photo.index', 'uses'=>'MultiPhotoController@getIndex']);
        Route::get('photo/create', ['as'=>'admin.photo.create', 'uses'=>'MultiPhotoController@getCreate']);
        Route::post('photo/create', ['as'=>'admin.photo.postCreate', 'uses'=>'MultiPhotoController@postCreate']);
        Route::get('photo/edit/{id}',['as' => 'admin.photo.edit', 'uses'=>'MultiPhotoController@getEdit']);
        Route::put('photo/edit/{id}',['as' => 'admin.photo.update', 'uses'=>'MultiPhotoController@postEdit']);
        Route::delete('photo/delete/{id}', ['as' => 'admin.photo.destroy', 'uses'=>'MultiPhotoController@destroy']);
        Route::post('photo/deleteAll', ['as' => 'admin.photo.deleteAll', 'uses'=>'MultiPhotoController@deleteAll']);

        /*AGENCY*/
        Route::get('agency/getData', ['as' => 'admin.agency.getData', 'uses' => 'AgencyController@getData']);
        Route::post('agency/deleteAll', ['as' => 'admin.agency.deleteAll', 'uses' => 'AgencyController@deleteAll']);
        Route::post('agency/updateStatus', ['as' => 'admin.agency.updateStatus', 'uses' => 'AgencyController@updateStatus']);
        Route::post('agency/postAjaxUpdateOrder', ['as' => 'admin.agency.postAjaxUpdateOrder', 'uses' => 'AgencyController@postAjaxUpdateOrder']);
        Route::resource('agency', 'AgencyController');

        /*CATEGORY*/
        Route::get('category/getData', ['as' => 'admin.category.getData', 'uses' => 'CategoryController@getData']);
        Route::post('category/deleteAll', ['as' => 'admin.category.deleteAll', 'uses' => 'CategoryController@deleteAll']);
        Route::post('category/updateStatus', ['as' => 'admin.category.updateStatus', 'uses' => 'CategoryController@updateStatus']);
        Route::post('category/postAjaxUpdateOrder', ['as' => 'admin.category.postAjaxUpdateOrder', 'uses' => 'CategoryController@postAjaxUpdateOrder']);
        Route::resource('category', 'CategoryController');

        /*PRODUCT*/
        Route::get('product/getData', ['as' => 'admin.product.getData', 'uses' => 'ProductController@getData']);
        Route::post('product/deleteAll', ['as' => 'admin.product.deleteAll', 'uses' => 'ProductController@deleteAll']);
        Route::post('product/postAjaxUpdateOrder', ['as' => 'admin.product.postAjaxUpdateOrder', 'uses' => 'ProductController@postAjaxUpdateOrder']);
        Route::post('product/AjaxRemovePhoto', ['as' => 'admin.product.AjaxRemovePhoto', 'uses' => 'ProductController@AjaxRemovePhoto']);
        Route::post('product/AjaxUpdatePhoto', ['as' => 'admin.product.AjaxUpdatePhoto', 'uses' => 'ProductController@AjaxUpdatePhoto']);
        Route::post('product/updateStatus', ['as' => 'admin.product.updateStatus', 'uses' => 'ProductController@updateStatus']);
        Route::post('product/updateHotProduct', ['as' => 'admin.product.updateHotProduct', 'uses' => 'ProductController@updateHotProduct']);
        Route::post('product/createAttribute', ['as' => 'admin.product.createAttribute', 'uses' => 'ProductController@postAddAttribute']);
        Route::post('product/createAttValue', ['as' => 'admin.product.createAttValue', 'uses' => 'ProductController@createAttValue']);
        Route::post('product/removeAttribute', ['as' => 'admin.product.removeAttribute', 'uses' => 'ProductController@removeAttribute']);
        Route::post('product/removeAttributeValue', ['as' => 'admin.product.removeAttributeValue', 'uses' => 'ProductController@removeAttributeValue']);

        /*ORDER*/
        Route::get('/don-hang', ['as' => 'admin.order.index', 'uses' => 'OrderController@getIndex']);
        Route::get('/don-hang/getData', ['as' => 'admin.order.getData', 'uses' => 'OrderController@getData']);
        Route::get('/don-hang/show/{id}', ['as' => 'admin.order.detail', 'uses' => 'OrderController@getDetail'])->where('id','[0-9a-z-A-Z._/\-]+');
        Route::post('don-hang/doi-trang-thai-ship', ['as' => 'admin.order.changeShipStatus', 'uses' => 'OrderController@postChangeShip']);
        Route::post('don-hang/doi-trang-thai-payment', ['as' => 'admin.order.changePaymentStatus', 'uses' => 'OrderController@postChangePayment']);

            /*CONFIGURABLE PRODUCT*/
        Route::get('product/pre-create', ['as' => 'admin.pre_create.product', 'uses' => 'ProductController@getPreCreateProduct']);
        Route::post('product/pre-create', ['as' => 'admin.pre_create.product.post', 'uses' => 'ProductController@postPreCreateProduct']);
        Route::post('product/configuable/create/s1', ['as' => 'admin.create.product.configuable.s1', 'uses' => 'ProductController@postCreateConfiguableS1']);
        Route::get('product/configuable/create/s2', ['as' => 'admin.create.product.configuable.s2', 'uses' => 'ProductController@getCreateProductConfigS2']);
        Route::post('product/configuable/create/s2', ['as' => 'admin.create.product.configuable.s2.post', 'uses' => 'ProductController@postCreateProductConfigS2']);
        Route::get('product/configuable/getAttributeForProduct', ['as' => 'admin.create.product.getAttribute', 'uses' => 'ProductController@getAttributeForProduct']);
        Route::post('product/configuable/getAttributeForProduct', ['as' => 'admin.create.product.postAttribute', 'uses' => 'ProductController@postAttributeForProduct']);

            /*PRODUCT CONFIGUABLE*/
        Route::get('/product/configuable/index/{parent_id}', ['as' => 'admin.product.configuable.index', 'uses' => 'ProductController@getIndexProductConfig'])->where('parent_id','[0-9a-zA-Z._\-]+');
        Route::get('/product/configuable/create/{parent_id}', ['as'=>'admin.product.configuable.create', 'uses' => 'ProductController@getCreateProductConfig']);
        Route::get('/product/configuable/edit/{id}/{parent_id}', ['as' => 'admin.product.configuable.edit', 'uses' => 'ProductController@getEditProductConfig'])->where(['id'=>'[0-9a-zA-Z._\-]+', 'parent_id' => '[0-9a-zA-Z._\-]+']);
        Route::post('/product/configuable/edit/{id}', ['as' => 'admin.product.configuable.edit.post', 'uses' => 'ProductController@postEditProductConfig'])->where('id','[0-9a-zA-Z._\-]+');

        Route::get('/product/configuable/remove/{id}', ['as'=>'admin.product.configuable.remove', 'uses' => 'ProductController@postRemoveConfiguable'])->where(['id'=>'[0-9a-zA-Z._\-]+']);
        Route::post('/product/configuable/checkDefault', ['as' => 'admin.product.configuable.changeDefault', 'uses' => 'ProductController@postChangeDefault']);
        

        Route::resource('product', 'ProductController');

        /*ATTRIBUTE*/
        Route::get('attribute/index', ['as' => 'admin.attribute.index', 'uses' => 'AttributeController@index']);
        Route::get('attribute/getData', ['as' => 'admin.attribute.getData', 'uses' => 'AttributeController@getData']);
        Route::get('attribute/edit/{id}', ['as' => 'admin.attribute.edit', 'uses' => 'AttributeController@edit'])->where('id','[0-9a-zA-Z._\-]+');
        Route::post('attribute/update/{id}', ['as' => 'admin.attribute.update', 'uses' => 'AttributeController@update'])->where('id','[0-9a-zA-Z._\-]+');
        Route::get('/attribute', ['as' => 'admin.attribute.create', 'uses' => 'AttributeController@getCreate']);
        Route::post('/attribute', ['as' => 'admin.attribute.create.post', 'uses' => 'AttributeController@postCreate']);


        /*COMMENT*/
        Route::get('comment/getData', ['as' => 'admin.comment.getData', 'uses' => 'CommentController@getData']);
        Route::post('comment/deleteAll', ['as' => 'admin.comment.deleteAll', 'uses' => 'CommentController@deleteAll']);
        Route::resource('comment', 'CommentController', ['expect' => ['index','edit','update','destroy']]);

        /*PAYMENT METHOD*/
        Route::get('payment-method/getData', ['as' => 'admin.payment-method.getData', 'uses' => 'PaymentMethodController@getData']);
        Route::post('payment-method/deleteAll', ['as' => 'admin.payment-method.deleteAll', 'uses' => 'PaymentMethodController@deleteAll']);
        Route::post('payment-method/updateStatus', ['as' => 'admin.payment-method.updateStatus', 'uses' => 'PaymentMethodController@updateStatus']);
        Route::resource('payment-method', 'PaymentMethodController');

        /*PROMOTION*/
        Route::get('promotion/getData', ['as' => 'admin.promotion.getData', 'uses' => 'PromotionController@getData']);
        Route::post('promotion/deleteAll', ['as' => 'admin.promotion.deleteAll', 'uses' => 'PromotionController@deleteAll']);
        Route::post('promotion/updateStatus', ['as' => 'admin.promotion.updateStatus', 'uses' => 'PromotionController@updateStatus']);
        Route::post('promotion/postAjaxUpdateOrder', ['as' => 'admin.promotion.postAjaxUpdateOrder', 'uses' => 'PromotionController@postAjaxUpdateOrder']);
        Route::resource('promotion', 'PromotionController');

        /*FEEDBACK*/
        Route::get('feedback/getData', ['as' => 'admin.feedback.getData', 'uses' => 'FeedbackController@getData']);
        Route::post('feedback/deleteAll', ['as' => 'admin.feedback.deleteAll', 'uses' => 'FeedbackController@deleteAll']);
        Route::post('feedback/updateStatus', ['as' => 'admin.feedback.updateStatus', 'uses' => 'FeedbackController@updateStatus']);
        Route::post('feedback/postAjaxUpdateOrder', ['as' => 'admin.feedback.postAjaxUpdateOrder', 'uses' => 'FeedbackController@postAjaxUpdateOrder']);
        Route::resource('feedback', 'FeedbackController');

        /*NEWS*/
        Route::get('news/getData', ['as' => 'admin.news.getData', 'uses' => 'NewsController@getData']);
        Route::post('news/deleteAll', ['as' => 'admin.news.deleteAll', 'uses' => 'NewsController@deleteAll']);
        Route::post('news/updateStatus', ['as' => 'admin.news.updateStatus', 'uses' => 'NewsController@updateStatus']);
        Route::post('news/postAjaxUpdateOrder', ['as' => 'admin.news.postAjaxUpdateOrder', 'uses' => 'NewsController@postAjaxUpdateOrder']);
        Route::resource('news', 'NewsController');

        /*PAGES*/
        Route::get('pages/getData', ['as' => 'admin.pages.getData', 'uses' => 'PagesController@getData']);
        Route::post('pages/deleteAll', ['as' => 'admin.pages.deleteAll', 'uses' => 'PagesController@deleteAll']);
        Route::post('pages/updateStatus', ['as' => 'admin.pages.updateStatus', 'uses' => 'PagesController@updateStatus']);
        Route::post('pages/postAjaxUpdateOrder', ['as' => 'admin.pages.postAjaxUpdateOrder', 'uses' => 'PagesController@postAjaxUpdateOrder']);
        Route::resource('pages', 'PagesController');

        /*PAYMENT SUPPLIER*/
        Route::get('payment-supplier/getData', ['as' => 'admin.payment-supplier.getData', 'uses' => 'PaymentSupplierController@getData']);
        Route::post('payment-supplier/deleteAll', ['as' => 'admin.payment-supplier.deleteAll', 'uses' => 'PaymentSupplierController@deleteAll']);
        Route::post('payment-supplier/updateStatus', ['as' => 'admin.payment-supplier.updateStatus', 'uses' => 'PaymentSupplierController@updateStatus']);
        Route::post('payment-supplier/postAjaxUpdateOrder', ['as' => 'admin.payment-supplier.postAjaxUpdateOrder', 'uses' => 'PaymentSupplierController@postAjaxUpdateOrder']);
        Route::resource('payment-supplier', 'PaymentSupplierController');

        /*CUSTOMER DETAIL*/
        Route::get('customer-idea/getData', ['as' => 'admin.customer-idea.getData', 'uses' => 'CustomerIdeaController@getData']);
        Route::post('customer-idea/deleteAll', ['as' => 'admin.customer-idea.deleteAll', 'uses' => 'CustomerIdeaController@deleteAll']);
        Route::post('customer-idea/updateStatus', ['as' => 'admin.customer-idea.updateStatus', 'uses' => 'CustomerIdeaController@updateStatus']);
        Route::post('customer-idea/postAjaxUpdateOrder', ['as' => 'admin.customer-idea.postAjaxUpdateOrder', 'uses' => 'CustomerIdeaController@postAjaxUpdateOrder']);
        Route::resource('customer-idea', 'CustomerIdeaController');

        /*SUPPLIER*/
        Route::get('supplier/getData', ['as' => 'admin.supplier.getData', 'uses' => 'PaymentSupplierController@getData']);
        Route::post('supplier/deleteAll', ['as' => 'admin.supplier.deleteAll', 'uses' => 'PaymentSupplierController@deleteAll']);
        Route::post('supplier/updateStatus', ['as' => 'admin.supplier.updateStatus', 'uses' => 'PaymentSupplierController@updateStatus']);
        Route::post('supplier/postAjaxUpdateOrder', ['as' => 'admin.supplier.postAjaxUpdateOrder', 'uses' => 'PaymentSupplierController@postAjaxUpdateOrder']);
        Route::resource('supplier', 'PaymentSupplierController');

        /*CUSTOMER MANAMENT*/
        Route::get('customer/getData', ['as' => 'admin.customer.getData', 'uses' => 'CustomerController@getData']);
        Route::post('customer/deleteAll', ['as' => 'admin.customer.deleteAll', 'uses' => 'CustomerController@deleteAll']);
        Route::post('customer/updateStatus', ['as' => 'admin.customer.updateStatus', 'uses' => 'CustomerController@updateStatus']);
        Route::post('customer/postAjaxUpdateOrder', ['as' => 'admin.customer.postAjaxUpdateOrder', 'uses' => 'CustomerController@postAjaxUpdateOrder']);
        Route::resource('customer', 'CustomerController', ['expect'=>['index', 'show', 'destroy']]);

        /* COMPANY */
        Route::any('company/{id?}', ['as' => 'admin.company.index', 'uses' => 'CompanyController@getInformation']);

    });
  });
});
