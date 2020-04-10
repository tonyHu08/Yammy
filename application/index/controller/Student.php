<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/25
 * Time: 2:09 PM
 */

namespace app\index\controller;

use think\Controller;

class Student extends Controller
{
    public function index()
    {
        $this->assign('title', 'exam_主页');
        return $this->fetch('');
    }

    //学生考试选题主页
    public function studentExamIndex()
    {
        $student_model = model('Student');
        $class = $student_model->studentNumFindClass(session('num'));
        $paper = [];
        $tool = new Tool();
        foreach($class as $num => $i) {
            if($tool->classNumFindPaper($i['class_num'])) {
                $paper[$i['class_name']] = $tool->classNumFindPaper($i['class_num']);
            } else {
                $paper[$i['class_name']][0] = null;
                $paper[$i['class_name']]['class_name'] = $i['class_name'];
            }
        }
        $this->assign('paper', $paper);
        $this->assign('title', 'Exam|选择考试');
        return $this->fetch('');
    }

    //学生考试主页
    public function studentTestIndex()
    {
        $paper_num = input('paper_num');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = $tool->singleChoiceStrToArr($paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($paper['true_or_false']);
        $short_answer = $tool->shortAnswerStrToArr($paper['short_answer']);
        $this->assign('paper', $paper);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        $this->assign('short_answer', $short_answer);
        $this->assign('title', '考试');
        return $this->fetch('');
    }

    //学生考试
    public function studentTestResult()
    {
        $paper_num = input('paper_num');
        $student_model = model('Student');
        $tool = new Tool();
        $paper = $tool->paperNumFindPaper($paper_num);
        $single_choice = $tool->singleChoiceStrToArr($paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($paper['true_or_false']);
        $short_answer = $tool->shortAnswerStrToArr($paper['short_answer']);
        $short_answer_answer = null;
        $true_or_false_answer = null;
        $single_choice_answer = null;
        $sum_score = 0;
        $score = 0;
        if($paper['single_choice'] != null) {
            if(!isset(input()['single_choice'])){
                return $this->error('漏选了选择题！');
            }
            $single_choice_answer = input()['single_choice'];
            foreach($single_choice as $num => $i) {
                if(!isset($single_choice_answer[$i['single_choice_id']])) {
                    return $this->error('漏选了选择题');
                }
                $sum_score += $paper['single_choice_score'];
                if($single_choice_answer[$i['single_choice_id']] == $i['answer']) {
                    $score += $paper['single_choice_score'];
                    $single_choice[$num]['judge'] = 'true';
                    $single_choice[$num]['student_answer'] = $single_choice_answer[$i['single_choice_id']];
                } else {
                    $single_choice[$num]['judge'] = 'false';
                    $single_choice[$num]['student_answer'] = $single_choice_answer[$i['single_choice_id']];
                }
            }
            $single_choice_answer = join('|', $single_choice_answer);
        }
        if($paper['true_or_false'] != null) {
            if(!isset(input()['true_or_false'])){
                return $this->error('漏选了判断题！');
            }
            $true_or_false_answer = input()['true_or_false'];
            foreach($true_or_false as $num => $i) {
                if(!isset($true_or_false_answer[$i['true_or_false_id']])) {
                    return $this->error('漏选了判断题');
                }
                $sum_score += $paper['true_or_false_score'];
                if($true_or_false_answer[$i['true_or_false_id']] == $i['answer']) {
                    $score += $paper['true_or_false_score'];
                    $true_or_false[$num]['judge'] = 'true';
                    $true_or_false[$num]['student_answer'] = $true_or_false_answer[$i['true_or_false_id']];
                } else {
                    $true_or_false[$num]['judge'] = 'false';
                    $true_or_false[$num]['student_answer'] = $true_or_false_answer[$i['true_or_false_id']];
                }
            }
            $true_or_false_answer = join('|', $true_or_false_answer);
        }
        if($paper['short_answer'] != null) {
            if(!isset(input()['short_answer'])){
                return $this->error('漏选了简答题！');
            }
            $short_answer_answer = input()['short_answer'];
            foreach($short_answer as $num => $i) {
                if(!isset($short_answer_answer[$i['short_answer_id']])) {
                    return $this->error('漏选了简答题');
                }
                $short_answer[$num]['student_answer'] = $short_answer_answer[$i['short_answer_id']];
            }
            $short_answer_answer = join('|', $short_answer_answer);
        }
        if(!$student_model->insertStudentTestResult(session('num'), session('username'), $paper['class_num'], $paper['class_name'], $paper['teacher_num'], $paper['teacher_name'], $paper['paper_num'], $paper['paper_name'], $sum_score, $score, $single_choice_answer, $true_or_false_answer, $short_answer_answer, $paper['single_choice'], $paper['true_or_false'], $paper['short_answer'])) {
            return $this->error('上传失败！');
        }
        $this->assign('sum_score', $sum_score);
        $this->assign('score', $score);
        $this->assign('paper', $paper);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        $this->assign('short_answer', $short_answer);
        $this->assign('title', 'Exam|考试结果');
        return $this->fetch('');
    }

    //考生选择查看已考试卷
    public function studentSelectPaper()
    {
        $tool = new Tool();
        $papers = $tool->studentNumFindPaper(session('num'));
        $this->assign('title', '查看试卷');
        $this->assign('papers', $papers);
        return $this->fetch('');
    }

    //学生查看选择的考卷
    public function studentCheckStudentPaper()
    {
        $student_answer_paper_id = input('student_answer_paper_id');
        $tool = new Tool();
        $answer_paper = $tool->studentAnswerPaperIdFindPaper($student_answer_paper_id);
        $paper = $tool->paperNumFindPaper($answer_paper['paper_num']);
        $single_choice = $tool->singleChoiceStrToArr($answer_paper['single_choice']);
        $true_or_false = $tool->trueOrFalseStrToArr($answer_paper['true_or_false']);
        $short_answer = $tool->shortAnswerStrToArr($answer_paper['short_answer']);
        # 如果有选择题
        if($answer_paper['single_choice_answer'] != null) {
            $single_choice_answer = explode('|', $answer_paper['single_choice_answer']);
            foreach($single_choice as $num => $i) {
                if($single_choice_answer[$num] == $i['answer']) {
                    $single_choice[$num]['judge'] = 'true';
                    $single_choice[$num]['student_answer'] = $single_choice_answer[$num];
                } else {
                    $single_choice[$num]['judge'] = 'false';
                    $single_choice[$num]['student_answer'] = $single_choice_answer[$num];
                }
            }
        } else {
            $single_choice = null;
        }
        #如果有判断题
        if($answer_paper['true_or_false_answer'] != null) {
            $true_or_false_answer = explode('|', $answer_paper['true_or_false_answer']);
            foreach($true_or_false as $num => $i) {
                if($true_or_false_answer[$num] == $i['answer']) {
                    $true_or_false[$num]['judge'] = 'true';
                    $true_or_false[$num]['student_answer'] = $true_or_false_answer[$num];
                } else {
                    $true_or_false[$num]['judge'] = 'false';
                    $true_or_false[$num]['student_answer'] = $true_or_false_answer[$num];
                }
            }
        } else {
            $true_or_false = null;
        }
        #如果有简答题
        if($answer_paper['short_answer_answer'] != null) {
            $short_answer_answer = explode('|', $answer_paper['short_answer_answer']);
            foreach($short_answer_answer as $num => $i) {
                $short_answer[$num]['student_answer'] = $short_answer_answer[$num];
            }
        } else {
            $short_answer = null;
        }

        $this->assign('sum_score', $answer_paper['sum_score']);
        $this->assign('score', $answer_paper['score']);
        $this->assign('paper', $paper);
        $this->assign('single_choice', $single_choice);
        $this->assign('true_or_false', $true_or_false);
        $this->assign('short_answer', $short_answer);
        $this->assign('answer_paper', $answer_paper);
        $this->assign('title', '查看考卷');
        return $this->fetch('');
    }
}