<?php

namespace app\auto\controller;

use think\Db;

use app\common\model\User;
use app\common\model\MsMcMembers;

use app\common\model\HsSzYiMember;



class Yue {



    /**
     * 分销
     */
    public function change(){


        User::where([''])->select();


    }




    public function money(){

        exit('00');


        $res = MsMcMembers::where(['flag'=>6])->limit(500)->select();
        $res = $res->toArray();

        dump($res);
    
        foreach($res as $k => $v){
            $user_id = $v['user_id'];


            User::where(['user_id'=>$user_id])->update(['user_money'=>$v['credit2'],'flag'=>2]);


            MsMcMembers::where(['user_id'=>$user_id])->update(['flag'=>7]);

        }
    } 




    public function user(){


        exit('0');
        $res = MsMcMembers::where(['flag'=>5])->limit(500)->select();
        $res = $res->toArray();

        dump($res);
    
        foreach($res as $k => $v){
            $uid = $v['uid'];

            $user_id = HsSzYiMember::where(['uid'=>$uid])->value('id');

            MsMcMembers::where(['uid'=>$v['uid']])->update(['user_id'=>$user_id,'flag'=>6]);

        }
    } 






    public function index(){


        exit('4');

        $con['credit2'] = array('gt',0);
        $res = HsSzYiMember::where(['uniacid'=>6])->field('uid,uniacid,credit2')->where($con)->limit(500)->select();
        $res = $res->toArray();
    
        if($res){

            foreach($res as $v){

                if((float)$v['credit2'] == 0){

                    HsSzYiMember::where(['uid'=>$v['uid']])->update(['uniacid'=>5]);
                    echo $v['uid']."为0,";
                    continue;
                }

                User::where(['uid'=>$v['uid']])->update(['user_money'=>$v['credit2']]);
           
                HsSzYiMember::where(['uid'=>$v['uid']])->update(['uniacid'=>5]);

                echo $v['uid']."OK,";
            }
        }
    }
}