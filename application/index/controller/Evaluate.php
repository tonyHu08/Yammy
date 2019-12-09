<?php


namespace app\index\controller;

use think\Controller;

class Evaluate extends Controller
{
    //插入评论信息
    public function evaluate()
    {
        $evaluation = input("evaluation");
        if ($evaluation == "") {
            $evaluation = "默认评价";
        }
        $deal_id = input("dealid");
        $rate = input("rate");

        $evaluate = model('Evaluate');
        $deal = model('Deal');
        if ($deal_info = $deal->selectDealInfoByDealId($deal_id)) {
            if ($evaluate->insertEvaluation($deal_info['dealid'], $deal_info['goodsid'], $deal_info['username'], $deal_info['seller_uid'], $evaluation, $rate)) {
                $yd = model('YammyData');
                $yd->updateInformNum($deal_info['seller_uid']);
                return 1;
            }
        }else{
            return print_r(input());
        }
    }

    public function showEvaluation($goodsid)
    {
        $evaluate = model("Evaluate");
        $evaluate_list = $evaluate->getEvaluationList($goodsid);
        return $evaluate_list;
    }

}