<?php
namespace app\Hfmgt\controller;

class Index
{
    /**
     * 改状态
     */
    public function index()
    {
        
        $con['note'] = array('neq','分红结束');
        $res = M('hs_sz_yi_invest')->where(['type'=>2])->where($con)->limit(100)->select();
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
            if($money < $m){
                M('hs_sz_yi_invest')->where(['ordersn'=>$v['ordersn']])->update(['type'=>1,'note'=>'手动更改成分红中20190628']);
            }else{
                M('hs_sz_yi_invest')->where(['ordersn'=>$v['ordersn']])->update(['note'=>'分红结束']);
            }
        }
        dump($res);
        
    }
}
