# myFrame-slimframework-
基于slimFramework改进的一点点东西，这个框架还不熟悉


## 目录结构
* `app` 项目主要文件
    *  `models` model文件，添加一个model之后，使用```composer dump-autoload```命令进行自动加载model
    *  `routes` 路由文件，具体去slimFramework官网去看路由说明 [路由地址](http://www.slimframework.com/docs/objects/router.html)
    *  `bootstrap.php` 是启动文件
* `config` 配置文件，`database.config.php`配置数据库信息
* `public` 入口文件
* `templates` 视图文件

## 使用命令
使用命令进行框架安装
```
composer install 
```