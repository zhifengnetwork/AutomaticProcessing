<?php
namespace app\auto\controller;

class Index
{
    public function index()
    {
        
        // 这里放置需要 定时处理的代码


        // 密码不存在这里，放在 config_password.php 文件中
        //调用方式    CONFIG('password1')


        echo CONFIG('password1');

        echo '执行成功';

    }
}
