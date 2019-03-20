<?php

namespace app\auto\controller;

use think\Db;
use app\common\model\User;
use app\common\model\AgentPerformance;

class Yeji {


    public function index(){

       
        $dbconf1 = [
            // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => CONFIG('hostname'),
            // 数据库名
            'database'    => 'zxx_iiio_copy',
            // 数据库用户名
            'username'    => 'root',
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

       
        $user = User::where(['flag'=>0])->field('user_id,openid')->limit(300)->select();

        $user = $user->toArray();

       
        if($user){

            foreach($user as $v){
                
                if($v['openid'] == ''){
                    continue;
                }
              
               
                $insql = "select mc.openid,sum(mc.teams)+sum(mc.total) total from hs_sz_yi_bonusorder mc where mc.openid='$v[openid]'";
                
            
                $res2 = Db::connect($dbconf1)->query($insql);
            
                $total = $res2[0]['total'];
               
        

                // $insql1 = "insert into `tp_agent_performance` (`user_id`,`agent_per`) values ('$uid','$total')";
               
                // $r = Db::connect($dbconf2)->execute($insql1);
                // if($r == 1){
                //     $sql3 = "UPDATE `hs_sz_yi_member` SET falg = 1 WHERE openid = '$v[openid]'";
                //     Db::connect($dbconf1)->execute($sql3);
                //     // echo ',ok:'.$uid."。";
                //     continue;
                // }else{
                //     // echo ',fail:'.$uid.",";
                // }


                $model = new AgentPerformance();
                $model->user_id = $v['user_id'];
                $model->agent_per = $total;
                $r = $model->save();
                if($r == 1){
                    User::where(['user_id'=>$v['user_id']])->update(['flag'=>1]);
                }else{
                    User::where(['user_id'=>$v['user_id']])->update(['flag'=>4]);
                }
                

                echo $v['user_id'].",";
            }
        }
    }
}