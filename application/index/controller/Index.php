<?php
namespace app\index\controller;
use \Rollbar\Rollbar;
use \Rollbar\Payload\Level;


class Index
{
    public function index()
    {
        Rollbar::init(
            array(
                'access_token' => 'eccb4e2e66634e26becab4fb1f488132',
                'environment' => 'production'
            )
        );
        Rollbar::log(Level::info(), '出错了，大错误');
       


        return '批量自动化处理';
    }


    public function aaa()
    {
        Rollbar::init(
            array(
                'access_token' => 'eccb4e2e66634e26becab4fb1f488132',
                'environment' => 'production'
            )
        );
        Rollbar::log(Level::info(), 'aaa模块 出错了，大错误');
       


        return '批量自动化处理';
    }
}
