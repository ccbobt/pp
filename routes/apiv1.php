<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar as RouteContract;

Route::group(['namespace' => 'Api\V1'], function (RouteContract $api) {
    // 登录
    $api->post('auth/login', 'AuthController@login');
});
