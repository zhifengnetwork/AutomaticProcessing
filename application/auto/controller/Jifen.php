<?php

namespace app\auto\controller;

use think\Db;

class Jifen {

    /**
     * 导入积分
     * 
     * 注册时间
     */
    public function index(){

        $dbconf1 = [
            // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => CONFIG('hostname'),
            // 数据库名
            'database'    => 'zxx',
            // 数据库用户名
            'username'    => 'zxx',
            // 数据库密码
            'password'    => CONFIG('password1'),
            // 数据库连接端口
            'hostport'    => '3306',
            // 数据库连接参数
            'params'      => [],
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => '',
        ];

        $dbconf2 = [
            'type'        => 'mysql',
             // 服务器地址
             'hostname'    => CONFIG('hostname'),
             // 数据库名
             'database'    => 'mobileshop',
             // 数据库用户名
             'username'    => 'mobileshop',
             // 数据库密码
             'password'    => CONFIG('password2'),
        ];

        // $fiels = "`uid` as `user_id`,`openid`,`nickname`,`realname`,`mobile`,`weixin`,`isagent`,`avatar` as `head_pic`,`province`,`city`,`alipay`";

        $fiels = '`uid` as `user_id`,`flag_1`,`createtime`';
        // desc 
        $sql = "select $fiels from `hs_sz_yi_member` where flag_1 = 0 and uid > 0 order by uid asc limit 300";

        $res = Db::connect($dbconf1)->query($sql);
        

        if($res){

            foreach($res as $v){
                
               
                $insql1 = "UPDATE `tp_users` SET reg_time = '$v[createtime]' WHERE user_id = '$v[user_id]'";
                $r = Db::connect($dbconf2)->execute($insql1);



                $sql3 = "UPDATE `hs_sz_yi_member` SET flag_1 = 1 WHERE uid = '$v[user_id]'";
                Db::connect($dbconf1)->execute($sql3);

                //改flag
                echo $v['user_id'],',';
                

            }
        }
    }
}