<?php
namespace app\xiaozhu\controller;

class Index
{
    /**
     * 小主
     */
    public function index()
    {

        $users = M('tp_users')->limit(50)->order('user_id DESC')->field('user_id,openid,nickname,mobile,reg_time,head_pic')->select();

      
        foreach($users as $k => $v){

            $d = array(
                'uniacid' => 1,
                'mobile' => $v['mobile'],
                'realname' => $v['nickname'],
                'nickname' => $v['nickname'],
                'avatar' => $v['head_pic'],
                'email' => $v['openid'].'@163.com',
                'password' => $v['openid'],

            );
            $uid = M('hs_mc_members')->insertGetId($d);

            
          
            $data = array(
                'uid' => $uid,
                'groupid' => 0,
                'createtime' => $v['reg_time'],
                'uniacid' => 1,
                'mobile' => $v['mobile'],
                'realname' => $v['nickname'],
                'nickname' => $v['nickname'],
                'avatar' => $v['head_pic'],
                'openid' => $v['openid'],

            );

            M('hs_sz_yi_member')->insert($data);

            M('tp_users')->where(['user_id'=>$v['user_id']])->delete();
        }


    
        dump($users);
    }
}
