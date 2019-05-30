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

        
        
        Rollbar::log(Level::info(), 'Test info message');
        throw new Exception('Test exception');


        return '批量自动化处理';
    }
}
