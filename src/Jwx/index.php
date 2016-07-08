<?php
/**
 * 基于MVC开发的单文件入口
 */

define('VERSION', '1.0');
// 生产或开发环境
define('DEBUG', true);

// 开启微信端及服务端校验
define('CHECKSIGNATURE', false);

// 载入项目核心文件

switch (CHECKSIGNATURE) {
    case 1:
        require  './Common/function.php';
        $Config = require './Config/config.php';
        define('TOKEN', $Config['WX_TOKEN']);
        valid();
        exit();
        break;
    case 2:
        // code...
        break;
    default:
        define('Web_TOKEN', VERSION);
        include './Library/Jwx.class.php';
        break;
}

// 判断安装文件是否存在 去参考CMS系统的安装
// if (is_file('./install/install.php')) {
//     header('Location:/install/install.php');
// }

// 项目初始化
Jwx::run();

//SeasLog::info('Jwx Ok~');
