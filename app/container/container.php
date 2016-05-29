<?php

// 这里全部是服务提供者

/**
 * 检测用户是否登录
 *
 * @param $app
 * @param $settings
 * @return callable
 */
$container['authenticate'] = function($app) {
    return function() use ($app) {
        if (!isset($_SESSION['user'])) {
            return false;
        }else{
            return true;
        }
    };
};