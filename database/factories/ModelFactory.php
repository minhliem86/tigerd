<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    return [
//        'name' => $faker->name,
//        'email' => $faker->safeEmail,
//        'password' => bcrypt(str_random(10)),
//        'remember_token' => str_random(10),
//    ];
//});

$factory->define(App\Models\Agencies::class, function (Faker\Generator $faker){
   return [
       'name' => $faker->company,
       'description' => $faker->paragraph(),
       'order' => $faker->biasedNumberBetween(1, 10),
   ] ;
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->company,
        'sku_cate' => $faker->company,
        'description' => $faker->paragraph(),
        'order' => $faker->biasedNumberBetween(1, 10),
    ] ;
});

$factory->define(App\Models\News::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph(),
        'content' => $faker->paragraph(),
        'order' => $faker->biasedNumberBetween(1, 10),
    ] ;
});

$factory->define(App\Models\Pages::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph(),
        'order' => $faker->biasedNumberBetween(1, 10),
    ] ;
});

$factory->define(App\Models\Promotion::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph(),
        'sku_promotion' => 'PROMO',
        'quality' => '100',
        'type' => $faker->paragraph(),
    ] ;
});

$factory->define(App\Models\CompanyInfomations::class, function (Faker\Generator $faker){
    return [
        'email' => $faker->freeEmail,
        'address' => $faker->streetAddress,
        'phone' => $faker->tollFreePhoneNumber,
    ] ;
});

$factory->define(App\Models\Customer::class, function (Faker\Generator $faker) {
   return [
       'firstname' => $faker->firstName,
       'lastname' => $faker->lastName,
       'email' => $faker->safeEmail,
       'username' => $faker->userName,
       'password' => bcrypt('123456'),
       'phone' => $faker->phoneNumber,
       'gender' => $faker->title,
       'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),

   ];
});

$factory->define(App\Models\PaymentMethod::class, function (Faker\Generator $faker){
    return [
        'name' => 'COD',
        'description' => 'Thanh toán khi giao hàng',
        'order'=> 1
    ] ;
});

$factory->define(App\Models\PaymentSupplier::class, function (Faker\Generator $faker){
    return [
        'name' => 'OnePay',
        'description' => 'Thanh toán bằng OnePay',
        'order'=> 1
    ] ;
});

$factory->define(App\Models\Feedback::class, function (Faker\Generator $faker){
   return [
      'fullname' => $faker->name,
       'phone' => $faker->tollFreePhoneNumber,
       'email' => $faker->safeEmail,
       'messages' => $faker->paragraph(),
   ] ;
});

$factory->define(App\Models\Product::class, function (Faker\Generator $faker){
   return [
       'name' => $faker->lexify('Sản Phẩm ???'),
       'description' => $faker->paragraph(),
       'content' => $faker->paragraph(),
       'price' => $faker->numberBetween('100000', '9999999'),
       'stock_quality' => 200,
   ];
});

$factory->define(App\Models\Attribute::class, function (Faker\Generator $faker){
    return[
        'name' => $faker->lexify('Màu Sắc ???'),
        'description' => $faker->paragraph(),
    ];
});

$factory->define(App\Models\AttributeValue::class, function (Faker\Generator $faker){
   return [
       'value' => 'xanh'
   ];
});
