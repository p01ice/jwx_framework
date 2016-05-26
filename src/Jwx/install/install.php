<?php
/**
 * 初始化安装
 * @author 0x584A <xjiek2010@icloud.com>
 * @copyright 2016
 * @link jgeek.cn 个人博客
 */

include '/Common/function.php';


// 模板引擎是否具有可写权限
if (chmod('/Library/smarty/templates', 0777)) {
    echo "smarty/templates文件夹无可编辑权限";
}


// 显示页面，更具提交类型生成conf.php基础配置文件


// conf.php文件是否存在 不存在则初始化数据录入
if (!is_file('../Config/conf.php')) {

}
