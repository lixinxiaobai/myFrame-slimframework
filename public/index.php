<?php
// use \Psr\Http\Message\ServerRequestInterface as Request;
// use \Psr\Http\Message\ResponseInterface as Response;

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__DIR__)) . DS);
define("VENDORDIR", ROOT . "vendor" . DS);
define("ROUTEDIR", ROOT . "app" . DS . "routes" . DS);
define("TEMPLATEDIR", ROOT . "templates" . DS);
define("LANGUAGEDIR", ROOT . "languages" . DS);

require_once '../vendor/autoload.php';

// 设置初始化信息
require_once ROOT . 'app' . DS . 'bootstrap.php';

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
            $app->flash('error', '没有登录');
            $app->redirect('/admin/login');
        }
    };
};



/**
 * 如果用户已经登录, 他访问页面(比如登录，注册)时候会重定向到登录后的主页
 *
 * @param $app
 * @param $settings
 * @return callable
 */
$container['isLogged'] = function($app, $settings) {
    return function() use ($app, $settings) {
        if (isset($_SESSION['user'])) {
            $app->redirect('/admin');
        }
    };
};

/**
 * 添加用户名的变量，以便于在模板进行查看
 */
// $app->hook('slim.before.dispatch', function() use ($app, $settings) {
//     $user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
//     $app->view()->setData('user', $user);
//     $app->view()->setData('settings', $settings);
//     $app->view()->setData("lang", $app->lang);
// });

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