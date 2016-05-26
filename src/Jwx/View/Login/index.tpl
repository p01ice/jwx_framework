<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8"/>
        <title>
            JWX个人微信号框架登陆系统 ---- By:0x584A
        </title>
    <link rel="stylesheet" type="text/css" href="/Public/Css/login.css">
    </head>
    <body>
        <div class="login">
            <h1>
                JWX个人微信公众号系统 V1.0版本
            </h1>
            <form action="/index.php?c=Public&a=loginis" method="post">
                <input name="Username" type="text" placeholder="用户名" required="required" />
                <input name="Password" type="password" placeholder="密码" required="required" />
                <!-- TODO:待加验证码功能 -->
                <button type="submit" class="btn btn-primary btn-block btn-large">
                    登录
                </button>
            </form>
            <div class="author">
                <p></p>
                <span>作者：0x584A</span>
                <span><a href="http://jgeek.cn">博客地址:Jgeek.cn</a></span>
            </div>
        </div>
        <div style="text-align:center;">
        </div>
    </body>
</html>
