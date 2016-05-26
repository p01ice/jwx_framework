<?php
/**
 * JWX后台管理控制器
 */

class MainController extends Controller
{

    // 加载显示首页模板
    public function index()
    {

        $this->loadHead();

        // 显示内容主体
        $this->view->display('Main/index.tpl');
        // echo getWxUserToken();
        // var_dump($this->getUserNum());

        $this->loadFooter();

    }

    /**
     * 获取关注用户总数
     * @return int
     */
    public function getUserNum($openid = 0)
    {
        $access_token = '';
        $url          = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=%s';
        if (empty($openid)) {
            if (isset($_SESSION['wx_token'])) {
                $access_token = $_SESSION['wx_token'];
                $getUrl       = sprintf($url, $access_token);

            } else {
                throw new Exception('错误：access_token获取失败或不存在！');
            }
        } else {
            if (isset($_SESSION['wx_token'])) {
                $access_token = $_SESSION['wx_token'];
                $url          = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=%s&next_openid=%s';
                $getUrl       = sprintf($url, $access_token, $openid);

            } else {
                throw new Exception('错误：access_token获取失败或不存在！');
            }
        }
        return json_decode(file_get_contents($getUrl), true);
    }

    // 显示模板头
    public function loadHead()
    {
        $this->view->display('Public/Head.tpl');
    }
    // 显示模板尾
    public function loadFooter()
    {
        $this->view->display('Public/Footer.tpl');
    }
}
