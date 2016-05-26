<?php

/**
 * 核心控制器 Wechat
 */
class Controller
{
    // 模板引擎
    protected $VIEW;

    // WX_TOKEN
    private $WX_TOKEN;

    // 填写加密用的EncodingAESKey
    private $ENCODINGAESKEY;

    // 填写高级调用功能的app id
    private $APPID;

    public $debug = false;
    public $errCode = 0; // 未知错误
    public $errMsg = "";

    public function __construct()
    {

        $this->WX_TOKEN = isset($GLOBALS['config']['WX_TOKEN']) ? $GLOBALS['config']['WX_TOKEN'] : '';
        $this->ENCODINGAESKEY = isset($GLOBALS['config']['ENCODINGAESKEY']) ? $GLOBALS['config']['ENCODINGAESKEY'] : '';
        $this->APPID = isset($GLOBALS['config']['APPID']) ? $GLOBALS['config']['APPID'] : '';
        $this->APPSECRET = isset($GLOBALS['config']['appsecret']) ? $GLOBALS['config']['appsecret'] : '';
        $this->DEBUG = isset($this->debug) ? $this->debug : false;


        // 设置模板目录
        $this->view = new View();
        $this->view->setTemplateDir(VIEW_DIR . '/');
    }

    // 成功跳转方法ssuccess
    public function success($url, $msg, $time = 1)
    {
        include_once VIEW_DIR . '/redirect.html';
        exit;
    }

    // 失败跳转方法
    public function error($url, $msg, $time = 3)
    {
        include_once VIEW_DIR . '/redirect.html';
        exit;
    }

    /**
     * 错误日志记录
     * @param mixed $msg 输入错误信息
     */
    protected function logError($msg)
    {
        if ($this->debug && $msg) {
            $msg = json_encode($msg);
            SeasLog::error(sprintf('Error Log ->%s' . $msg));
        }
    }

    /**
     * 配置日志记录
     * @param mixed $msg 输入错误信息
     */
    protected function logInfo($msg)
    {
        if ($msg) {
            $msg = json_encode($msg);
            SeasLog::error(sprintf('Info Log ->%s' . $msg));
        }
    }

    /**
     * Bug日志记录
     */
    public function logDebug($msg)
    {
        if ($msg) {
            $msg = json_encode($msg);
            SeasLog::debug("debug --> {$msg} ::",array(__CLASS__ => __FUNCTION__));
        }
    }
}
