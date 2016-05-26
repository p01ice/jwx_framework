<?php
/**
 * 基于MVC开发的单文件入口
 */

define('VERSION', '1.0');
define('TOKEN', 'Jwx');
// 生产或开发环境
define('DEBUG', true);

// 载入项目核心文件
include './Library/Jwx.class.php';

// 判断安装文件是否存在
// if (is_file('./install/install.php')) {
//     header('Location:/install/install.php');
// }

// 项目初始化
Jwx::run();

SeasLog::info('Jwx Ok~');
