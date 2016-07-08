<?php
if (!defined('Web_TOKEN')) {
    exit('hello,hacker...');
}

/**
 * 核心类文件
 * @author 0x584A <xjiek2010@icloud.com>
 * @copyright 2016
 * @link jgeek.cn 个人博客
 */
class Jwx
{
    /**
     * 项目初始化
     * @access public
     * @author 0x584A
     */
    public static function run()
    {
        self::setHeader();
        self::setConst();
        self::setError();
        self::setSession();
        self::setConfig();
        self::setInclude();
        self::setAutoLoad();
        self::setUrl();
        self::setPrivilege();
        self::setDispatch();
    }

    /**
     * 定义编码格式
     * @access private
     * @author 0x584A
     */
    private static function setHeader()
    {
        header('Content-type:text/html;charset=utf-8');
    }

    /**
     * 定义常量目录
     * @access private
     */
    private static function setConst()
    {
        // 设置路径常量
        define('ROOT_DIR', str_replace('\\', '/', realpath(dirname(__FILE__) . '/../')));
        // 定义核心目录
        define('CORE_DIR', ROOT_DIR . '/Core');
        define('CONFIG_DIR', ROOT_DIR . '/Config');
        define('COMMON_DIR', ROOT_DIR . '/Common');
        define('MODEL_DIR', ROOT_DIR . '/Model');
        define('CONTROLLER_DIR', ROOT_DIR . '/Controller');
        define('VIEW_DIR', ROOT_DIR . '/View');
        define('LIBRARY_DIR', ROOT_DIR . '/Library');
        define('LOG_DIR', ROOT_DIR . '/Log');
        define('PUBLIC_DIR' , '/Public');
    }

    /**
     * 设置错误信息
     * @access private
     */
    private static function setError()
    {
        if (DEBUG) {
            // 开发模式
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
        } else {
            // 生成模式
            ini_set('display_errors', 'Off');
            error_reporting(0);
        }
    }

    /**
     * 设置session信息
     * @access private
     */
    private static function setSession()
    {
        session_start();
    }

    /**
     * 配置文件信息
     * @access private
     */
    private static function setConfig()
    {
        $GLOBALS['config'] = include CONFIG_DIR . '/config.php';
    }

    /**
     * 自动加载第三方扩展
     * @access private
     */
    private static function setInclude(){
        // 模板引擎
        // templates目录地址
        define('TEMPLATES_DIR', LIBRARY_DIR.'/smarty/templates/');
        // templates_c目录地址
        define('TEMPLATES_C_DIR', LIBRARY_DIR.'/smarty/templates_c/');
        // cache目录地址
        define('CACHE_DIR', LIBRARY_DIR.'/smarty/cache/');
        include LIBRARY_DIR.'/smarty/Smarty.class.php';

        // 加载公用方法函数
        include COMMON_DIR.'/function.php';

        // 加载XSS过滤库
				include LIBRARY_DIR.'/htmlpurifier/HTMLPurifier.php';

				// 日志存放路径
				SeasLog::setBasePath(LOG_DIR);
    }


    /**
     * 设置文件自动加载
     * @access private
     */
    private static function loadCore($class)
    {
        if (is_file(CORE_DIR . "/$class.class.php")) {
            include CORE_DIR . "/$class.class.php";
        }
    }
    private static function loadController($class)
    {
        if (is_file(CONTROLLER_DIR . "/$class.class.php")) {
            include CONTROLLER_DIR . "/$class.class.php";
        }
    }
    private static function loadModel($class)
    {
        if (is_file(MODEL_DIR . "/$class.class.php")) {
            include MODEL_DIR . "/$class.class.php";
        }
    }
    /**
     * @access private
     */
    private static function setAutoLoad()
    {
        // 把上面三个函数注册到自动加载函数中
        spl_autoload_register('self::loadCore');
        spl_autoload_register('self::loadController');
        spl_autoload_register('self::loadModel');
    }

    /**
     * 设置 url 路由
     * @param string c:控制器名称
     * @param string a:操作名称
     * @access private
     */
    private static function setUrl()
    {
        $controller = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Public';
        $action     = isset($_REQUEST['a']) ? $_REQUEST['a'] : 'login';
        // 字符串转小写
        $controller = strtolower($controller);
        $action     = strtolower($action);
        // 控制名称首字母大写
        $controller = ucfirst($controller);
        define('CONTROLLER', $controller);
        define('ACTION', $action);
    }

    /**
     * 设置访问权限
     * @access private
     */
    private static function setPrivilege()
    {
        if (!(CONTROLLER == 'Public' && (ACTION == 'captcha' || ACTION == 'login' || ACTION == 'signin'))) {
            // 没有设置session 强制跳转
            if (!isset($_SESSION['adminuser'])) {
                header('Location:index.php');
            }
        }
    }

    /**
     * 设置路由：请求分发
     * @access private
     */
    private static function setDispatch()
    {
        // 获取控制器与操作参数 并组装
        $controller = CONTROLLER . 'Controller';
        $action = ACTION;
        //实例化控制器
        $controller = new $controller();
        $controller->$action();
    }

}
