<?php

/**
 * 创建一个应用
 */
$app = new \Slim\App([
    'debug' => true,
    'settings' => [
        'displayErrorDetails' => true,
    ]
]);

$container = $app->getContainer();

// 加载view twig模板引擎
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(TEMPLATEDIR, [
        'cache' => false //ROOT.'cache/'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));
    return $view;
};

// 加密cookie
// $app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'h5/4jc/)$3kfè4()487HD3d')));

// 引入ORM laravel
use Illuminate\Database\Capsule\Manager as Capsule;

// 连接数据库
if (file_exists(ROOT . 'config' . DS . 'database.config.php')) {
    $capsule = new Capsule;
    $capsule->addConnection(include ROOT . "config" . DS . 'database.config.php');
    $capsule->bootEloquent();
    $capsule->setAsGlobal();

	$container['db'] = $db;
}

/**
 * 加载所有的libs的文件，可以放置一些公共的函数
 */
foreach (glob(LIBDIR . '*.php') as $filename) {
    require_once $filename;
}

/**
 * 加载所有的CONTAINER的文件, 服务提供者，依赖注入
 */
foreach (glob(CONTAINERDIR . '*.php') as $filename) {
    require_once $filename;
}

/**
 * 加载所有的Middleware的文件, 中间件类
 */
foreach (glob(MIDDLEWARERDIR . '*.php') as $filename) {
    require_once $filename;
}

/**
 * 加载所有的controller的文件, 可以使用路由调用
 */
foreach (glob(CONTROLLERDIR . '*.php') as $filename) {
    require_once $filename;
}

