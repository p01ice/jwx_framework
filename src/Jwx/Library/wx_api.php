<?php
/**
 * PHP信息公众号的编写
 */

include './ini.php';

// 微信公众号个人验证TOKEN
define("TOKEN", "lujiadiandong");
$wechatObj = new wechatCallbackapiTest();
// 首次服务器配置则需要运行 valid()方法  是为了微信的tolen校验
// $wechatObj->valid();
// 自己写的方法则是调用responseMsg()方法
$wechatObj->responseMsg();

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    // 微信个人公众号返回消息的方法
    // 数据库等CURD均在此处编写
    public function responseMsg()
    {
        //get post data, May be due to the different environments
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        //extract post data
        if (!empty($postStr)) {
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
            the best way is to check the validity of xml by yourself */
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            // 返回用户的名称
            $fromUsername = $postObj->FromUserName;
            // 当前微信账号名称
            $toUsername = $postObj->ToUserName;
            // 接收消息类型
            $Msg_Type = $postObj->MsgType;
            // 接收事件类型
            $Event = $postObj->Event;


            $keyword = trim($postObj->Content);
            // 当前服务器时间
            $time = time();

            // 接收参数日志
            $log = json_encode($postObj);
            file_put_contents('./test.log', $log,FILE_APPEND);
            file_put_contents('./test.log', "\r\n",FILE_APPEND);

            // 够构造返回文字消息的XML结构体
            $textTpl = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Content><![CDATA[%s]]></Content>
                            <FuncFlag>0</FuncFlag>
                            </xml>";

            // if (!empty($keyword)) {
                // 回复用户的文字消息
                if ($Msg_Type == 'text') {
                    $msgType    = "text";
                    // 从数据库请取出自动回复消息
                    $SqlStr = 'select content from t_msg where msgtype = 1 limit 1';
                    $msginfo = mysql_query($SqlStr);
                    $row = mysql_fetch_assoc($msginfo);

                    // $contentStr = "感谢您关注我的微信号！发送数字1获取最新的活动...";
                    $contentStr = $row['content']; // 显示后台用户任意更改的消息内容
                    $resultStr  = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;

                } else if ($Msg_Type == 'event') {
                    // 关注微信公众号事件 自动回复消息
                    switch ($Event) {
                        case "subscribe": // 关注事件
                            // 回复内容是写死的，固定的！ 如果要实现自定义 也得入库 然后取出
                            $content = '欢迎您订阅我的微信号！test关注事件...';
                            break;
                        default: // 取消事件
                            $content = "Unknow Event: " . $Event;
                            break;
                    }
                    $msgType   = 'text';
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $content);

                    // 发送参数日志
                    // $log = json_encode($resultStr);
                    // file_put_contents('./test.log', $log,FILE_APPEND);
                    // file_put_contents('./test.log', "\r\n",FILE_APPEND);

                    echo $resultStr;
                // }
            } else {
                echo "Inputsomething...";
            }

        } else {
            echo "";
            exit;
        }
    }

    /**
     * 微信用于校验服务器端的TOKEN
     */
    private function checkSignature()
    {
        // 用来验证服务器的API是否能正常返回
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $token  = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }
}
