<?php
session_start();
define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("VENDORDIR", ROOT . "vendor" . DS);
define("ROUTEDIR", ROOT . "app" . DS . "routes" . DS);
define("LIBDIR", ROOT . "app" . DS . "libs" . DS);
define("CONTROLLERDIR", ROOT . "app" . DS . "controller" . DS);
define("MIDDLEWARERDIR", ROOT . "app" . DS . "middleware" . DS);
define("CONTAINERDIR", ROOT . "app" . DS . "container" . DS);
define("TEMPLATEDIR", ROOT . "templates" . DS);
define("LANGUAGEDIR", ROOT . "languages" . DS);

require_once '../vendor/autoload.php';

// 设置初始化信息
require_once ROOT . 'app' . DS . 'bootstrap.php';

/**
 * 引入路由文件
 */
foreach(glob(ROUTEDIR . '*.php') as $router) {
    require_once $router;
}
/**
 * 运行应用
 */
$app->run();