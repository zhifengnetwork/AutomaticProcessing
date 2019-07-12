<?php
namespace app\Dream136\controller;

class Index
{

    // www.shshuimoc.cn
    // www.chuangda0311.com
    public function index(){


        exit;


        $con['idcard'] = array('like','%www.chuangda0311.com%');

        $c = M('hs_sz_yi_member')->where($con)->select();

        foreach($c as $k => $v){

            dump($v['idcard']);
            $idcard =  str_replace("www.chuangda0311.com","www.dream136.cn",$v['idcard']);      
            dump($idcard);

            M('hs_sz_yi_member')->where(['id'=>$v['id']])->update(['idcard'=>$idcard]);
        }



        // dump($c);

    }




    /**
     * 改状态
     */
    public function a()
    {
       
        exit;


        $con['id'] = array('gt',795);
        $c = M('hs_sz_yi_invest01')->where($con)->select();

        dump(count($c));

        foreach($c as $k => $v){
            
            $c[$k]['id'] = $v['id'] + 1000;

            $v['id'] = $v['id'] + 1000;
            

            //把v存进去 hs_sz_yi_member
            M('hs_sz_yi_invest')->insert($v);

        }

        dump($c);
    }



    /**
     * 改状态
     */
    public function c()
    {
       
        
        // $con['note'] = array('neq','分红结束');

        // ->where(['type'=>2])->where($con)

        // 

        $res = M('hs_sz_yi_invest')->select();

        foreach($res as $k => $v){
            // ["money"] => string(7) "5000.00"
            // ["bonus"] => string(7) "9000.00"
            // ["maxBonus"] => string(4) "2.00"
            $money =  M('hs_sz_yi_mybonus_log')->where(['openid'=>$v['openid']])->sum('bonus');
            if((int)$v['maxBonus'] == 1){
                $m = (float)$v['money'] * 1.5;
            }
            if((int)$v['maxBonus'] == 2){
                $m = (float)$v['money'] * 1.8;
            }
            if($money > $m){

                dump("money::".$money);
                dump("m:::".$m);

                $result = M('hs_sz_yi_mybonus_log')->where(['openid'=>$v['openid']])->order('id desc')->find();
                
                // dump($v['id']);

                // dump($result);

                $result['id1'] = $result['id'];

                unset($result['id']);
                
                dump($result);
               
            

                $result['credit3before'] = M('hs_sz_yi_member')->where(['openid'=>$v['openid']])->value('credit3');

                dump($result['credit3before']);

                dump($result['bonus']);


                // //扣钱
                $after = (float)$result['credit3before'] - (float)$result['bonus'];
                dump($after);


                $t = M('hs_sz_yi_member')->where(['openid'=>$result['openid']])->update(['credit3'=> $after ] );
                dump($t);

                $result['credit3after'] = M('hs_sz_yi_member')->where(['openid'=>$v['openid']])->value('credit3');
              
                M('hs_zy_yi_del_log')->insert($result);

            
                
                M('hs_sz_yi_mybonus_log')->where(['id'=>$result['id1']])->delete();
                
                exit;


                //删除最新的一行
               // %%%%  M('hs_sz_yi_invest')->where(['ordersn'=>$v['ordersn']])->update(['type'=>1,'note'=>'手动更改成分红中20190628']);

            }else{

               // %%%  M('hs_sz_yi_invest')->where(['ordersn'=>$v['ordersn']])->update(['note'=>'分红结束']);
            }
        }


        // dump($res);
        
    }



}
