<?php

namespace app\auto\controller;

use think\Db;

class Aatest {


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

        $fiels = '`uid` as `user_id`,`openid`,`isagent`,`level`,`flag`';

        $sql = "select $fiels from `hs_sz_yi_member` where flag = 0 order by uid desc limit 200";

        $res = Db::connect($dbconf1)->query($sql);

        if($res){

            foreach($res as $v){

                $sql1 = "select `uid` from hs_sz_yi_member where openid='$v[openid]'";
                $insql = "select mc.openid,sum(mc.teams)+sum(mc.total) total from hs_sz_yi_bonusorder mc where mc.openid='$v[openid]'";
                
            
                $res2 = Db::connect($dbconf1)->query($insql);
                $res1 = Db::connect($dbconf1)->query($sql1);

                $uid = $res1[0]['uid'];

                if($uid == 0){
                    $sql3 = "UPDATE `hs_sz_yi_member` SET flag = 1 WHERE openid = '$v[openid]'";
                    Db::connect($dbconf1)->execute($sql3);
                    echo ',uid=0:'.$uid."。";
                    continue;
                }


                // $result1 = [];
                // $result = [];
                // array_map(function ($value) use (&$result) {
                //     $result = array_merge($result, array_values($value));
                // }, $res2);


                // array_map(function ($value) use (&$result1) {
                //     $result1 = array_merge($result1, array_values($value));
                // }, $res1);

                
                if($res2[0]['openid'] == null){
                    $sql3 = "UPDATE `hs_sz_yi_member` SET flag = 1 WHERE openid = '$v[openid]'";
                    Db::connect($dbconf1)->execute($sql3);
                    echo ',openid=0:'.$uid."。";
                    continue;
                }             

                $total = $res2[0]['total'];
               
               
                $insql1 = "insert into `tp_agent_performance` (`user_id`,`agent_per`) values ('$uid','$total')";
               
                $r = Db::connect($dbconf2)->execute($insql1);
                if($r == 1){
                    //ok
                  
                    $sql3 = "UPDATE `hs_sz_yi_member` SET flag = 1 WHERE openid = '$v[openid]'";
                    Db::connect($dbconf1)->execute($sql3);

                    echo ',ok:'.$uid."。";

                    continue;
                }else{
                   
                    echo ',fail:'.$uid.",";
                }

               

            }

           
        }
       
    }



}