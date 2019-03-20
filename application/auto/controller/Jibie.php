<?php

namespace app\auto\controller;

use think\Db;

use app\common\model\User;
use app\common\model\MsMcMembers;
use app\common\model\HsSzYiMember;
use app\common\model\AgentPerformance;

class Jibie {



    public function dis(){

        exit('0');

        
        $res = AgentPerformance::where(['flag'=>0])->limit(800)->select();
        $res = $res->toArray();
        dump($res);
        foreach($res as $v){

            User::where(['user_id'=>$v['user_id']])->update(['is_distribut'=>1]);
            AgentPerformance::where(['user_id'=>$v['user_id']])->update(['flag'=>1]);

        }

    }



    public function index(){

        exit('0');
    
        //级别

        // ==== 1
        $res = HsSzYiMember::where(['uniacid'=>2])->field('id,yeji_level')->limit(500)->select();
        $res = $res->toArray();

        if($res){

            foreach($res as $v){

                if($v['yeji_level'] == 0){
                    $yeji_level = 0;
                }
                if($v['yeji_level'] == 1){
                    $yeji_level = 1;
                }
                if($v['yeji_level'] == 2){
                    $yeji_level = 3;
                }
                if($v['yeji_level'] == 3){
                    $yeji_level = 5;
                }

                
                $r = User::where(['user_id'=>$v['id']])->update(['agent_user'=>$yeji_level]);
                echo '[OK]';

                HsSzYiMember::where(['id'=>$v['id']])->update(['uniacid'=>6]);

                echo $v['id'].",";
            }
        }
    }
}