<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar as RouteContract;

Route::group(['namespace' => 'Api\V1'], function (RouteContract $api) {
    // 登录
    $api->post('auth/login', 'AuthController@login');
    // 商品列表
    $api->get('shop', 'ShopController@index');
    // 检查优惠价
    $api->post('checkCoupon', 'ShopController@checkCoupon');
    // 检测用户邮箱
    $api->post('checkEmail', 'UserController@checkEmail');
    // 提交订单
    $api->post('submitOrder', 'ShopController@submitOrder');
});
