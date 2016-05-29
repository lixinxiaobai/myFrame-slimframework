<?php

// 判断是否登录中间件,如果没有登录重定向至登录页面
$authenticate = function($request, $response, $next) use ($app){
    if(!$app->authenticate($response)){
        $response = $response->withStatus(302)->withHeader('Location', '/login');
    }
    $response = $next($request, $response);
    return $response;
};