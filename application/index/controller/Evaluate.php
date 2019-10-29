<?php


namespace app\index\controller;

use think\Controller;

class Evaluate extends Controller
{
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
        $deal_info = $deal->selectDealInfoByDealId($deal_id);
        if ($evaluate->insertEvaluation($deal_info['dealid'], $deal_info['goodsid'], $deal_info['username'], $evaluation, $rate)) {
            return $this->redirect('Deal/deal', ['operation' => 'evaluateSuccess']);
        }
    }

    public function showEvaluation($goodsid)
    {
        $evaluate = model("Evaluate");
        $evaluate_list = $evaluate->getEvaluationList($goodsid);
        return $evaluate_list;
    }

}