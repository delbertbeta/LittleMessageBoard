<?php

class operate_success
{
    public $code = 0;
    public $explain = "成功了哟！o(*￣▽￣*)ブ给你小花花";
}

class not_login_error
{
    public $code = 1;
    public $explain = "你居然没登陆就想来骗我？哼唧(╯▔皿▔)╯";
}

class user_not_match_error
{
    public $code = 2;
    public $explain = "不带这样玩的啊哟喂(╯▔皿▔)╯";
}

class sql_error
{
    public $code = 3;
    public $explain = "服务器向你提出了一个问题...";
}

class parameter_is_expected_error
{
    public $code = 4;
    public $explain = "调用缺少参数，请参考API文档哟";
}

class upload_image_error
{
    public $code = 5;
    public $explain = "你这个文件不行啊，还需要学习一个。文件要是png或者jpg的哟，而且小于200KB";
}

class login_error
{
    public $code = 6;
    public $explain = "未找到该用户或密码错误";
}

class register_error
{
    public $code = 7;
    public $explain = "注册失败，用户名已被使用";
}

class token_out_of_date
{
    public $code = 8;
    public $explain = "你的头坑(Token)已经失效啦！重新登陆一下好伐？";
}

?>
