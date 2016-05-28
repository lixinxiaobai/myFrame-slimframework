<?php

/**
 * 创建一个应用
 */
$app = new \Slim\App([
    'debug' => true
]);

$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer(TEMPLATEDIR);
// 加密cookie
// $app->add(new \Slim\Middleware\SessionCookie(array('secret' => 'h5/4jc/)$3kfè4()487HD3d')));

// 引入ORM
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
foreach (glob(ROOT . 'src' . DS . 'libs' . DS . '*.php') as $filename) {
    require_once $filename;
}