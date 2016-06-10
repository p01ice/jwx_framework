<?php
/**
 * 公共控制器
 */
class PublicController extends Controller
{
    /**
     * 显示登陆页面
     */
    public function login(){
        // 显示模板视图
        $this->view->display('Login/index.tpl');
//        $this->logDebug('Test Debug String');
    }

    /**
     * 登陆验证
     */
    public function loginIs()
    {
        // 验证提交表单
        $postData = is_from($_POST);

        // 检查用户是否存在
        $AdminModel = new AdminModel();
        $UserInfo = $AdminModel->loginis($postData['Username']);
        if (empty($UserInfo)) {
            header('location:index.php');
        }

        // 验证登录密码是否正确
        $postData['Password'] = md5($postData['Password'].$UserInfo['sale']);
        if ($postData['Password'] === $UserInfo['password']) {
            // 将用户信息写入session
            $_SESSION['adminuser'] = $UserInfo;
            // 跳转值后台管理页面
            header('location:index.php?c=Main&a=index');
        }else {
            header('location:index.php');
        }
    }

    /**
     * 退出登录状态
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function loginout()
    {
        // 注销会话状态
        unset($_SESSION['adminuser']);
        header('location:index.php');
    }
}
