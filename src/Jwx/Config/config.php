<?php
/**
 * 基础设置文件
 */

return array(
    'mysql'          => array(
        // 数据库地址
        'host'    => '127.0.0.1',
        // 端口
        'port'    => '3306',
        // 数据库名称
        'dbname'  => 'db_jwx',
        // 数据库用户名
        'user'    => 'root',
        // 数据库密码
        'pass'    => 'root',
        // 编码
        'charset' => 'utf8',
        // 表前缀
        'prefix'  => 't_',
    ),

    // 微信的明文TOKEN
    'WX_TOKEN'       => 'wx_token123456',
    // 填写高级调用功能的app id
    'APPID'          => '',
    // 填写加密用的EncodingAESKey
    'ENCODINGAESKEY' => '',
    // 填写高级调用功能的密钥
    'APPSECRET'=>'',

    // 使用的文件编辑器默认使用百度富文本
    'EDITOR'         => 'ueditor',
    // XSS过滤库
    'XSS_PURIFIER'   => 'htmlpurifier',
    // 模板引擎
    'TPL_DIR'        => 'smarty',
    // 模板文件后缀名
    'VIEW_EXTENSION' => '.tpl',

    //上传类型白名单
    'upload_mime'    => 'image/png,image/jpg,image/gif,image/jpeg',
);
