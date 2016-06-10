<?php
/**
 * 公共方法库
 */

/**
 * 验证及过滤表单数据
 *
 * @param  array   $Data 用户提交的数据
 * @param  stiring $Type 数据过滤模式
 *
 * @return array
 */
function is_from($Data, $Type = 'SQL')
{
    if (empty($Data)) {
        return false;
    }

    $tempArray = [];

    switch ($Type) {
        case 'XSS': // 过滤xss
            $HTMLPurifier = new HTMLPurifier;

            foreach ($Data as $k => $v) {
                $tempArray[ $k ] = $HTMLPurifier->purify($v);
            }

            return $tempArray;
            break;
        case 'SQL':
            foreach ($Data as $k => $v) {
                $tempArray[ $k ] = htmlspecialchars($v, ENT_QUOTES);
            }

            return $tempArray;
            break;
        default:
            exit('数据过滤类型错误！');
            break;
    }
}

/**
 * 创建文件夹
 *
 * @param  string $dir   路径
 * @param  int    $chmod 权限
 *
 * @return bool
 */
function createDir($dir, $chmod = 0766)
{
    if (is_dir($dir)) {
        mkdir($dir, $chmod, true);

        return true;
    } else {
        return false;
    }
}

/**
 * 常用返回XML结构体
 *
 * @param  string $msgType 消息类型
 *
 * @return string         xml结构体
 */
function returnWxXml($msgType)
{
    switch ($msgType) {
        case 'text':
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%d</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";

            return $textTpl;
            break;
        default:
            # code...
            break;
    }
}

/**
 * 获取WX的access_token
 *
 * @param  int    $appid  用户唯一凭证
 * @param  string $secret 唯一凭证密钥
 *
 * @return string
 */
function getWxUserToken($appid = '', $secret = '')
{
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
    $getUrl = sprintf($url, $appid, $secret);
    $access_token = json_decode(file_get_contents($getUrl), true);

    if (empty($access_token)) {
        return false;
    } else {
        // 将Token 写入到Seeion中
        // $_SESSION['wx_token'] = $access_token['access_token'];

        // return $access_token['access_token'];
    }
}

// 用于公共API的验证
function valid()
{
    $echoStr = $_GET["echostr"];

    //valid signature , option
    if (checkSignature()) {
        echo $echoStr;
        exit;
    }
}

// 微信PHPAPI校验方法
function checkSignature()
{
    if ( !defined("TOKEN")) {
        throw new Exception('TOKEN is not defined!');
    }

    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];

    $token = TOKEN;
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
