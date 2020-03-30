<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/1
 * Time: 11:08 PM
 */

namespace app\index\model;

use think\Model;

class Teacher extends Model
{
    //教师添加单选题
    public function teacherAddSingleChoice($topic, $A, $B, $C, $D, $soleve_thinking, $teacher, $teacher_num, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('single_choice')->insert(['topic' => $topic, 'A' => $A, 'B' => $B, 'C' => $C, 'D' => $D, 'soleve_thinking' => $soleve_thinking, 'teacher' => $teacher, 'teacher_num' => $teacher_num, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师添加判断题
    public function teacherAddTrueOrFalse($topic, $soleve_thinking, $teacher, $teacher_num, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('true_or_false')->insert(['topic' => $topic, 'soleve_thinking' => $soleve_thinking, 'teacher' => $teacher, 'teacher_num' => $teacher_num, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师添加简答题
    public function teacherAddShortAnswer($topic, $soleve_thinking, $teacher_name, $teacher_num, $difficulty, $class_num, $class_name)
    {
        $info = db('short_answer')->insert(['topic' => $topic, 'soleve_thinking' => $soleve_thinking, 'teacher_name' => $teacher_name, 'teacher_num' => $teacher_num, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name]);
        return $info;

    }

    //教师查询选择题
    public function teacherSingleChoice($teacher_num)
    {
        $info = db('single_choice')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

    //教师查询判断题
    public function teacherTrueOrFalse($teacher_num)
    {
        $info = db('true_or_false')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

    //教师查询简答题
    public function teacherShortAnswer($teacher_num)
    {
        $info = db('short_answer')->where('teacher_num', $teacher_num)->select();
        return $info;
    }

    //教师删除单选题题目
    public function teacherDeleteSingleChoice($single_choice_id)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->update(['delete' => 1]);
        return $info;
    }

    //教师删除判断题题目
    public function teacherDeleteTrueOrFalse($true_or_false_id)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->update(['delete' => 1]);
        return $info;
    }

    //教师删除简答题题目
    public function teacherDeleteShortAnswer($short_answer_id)
    {
        $info = db('short_answer')->where('short_answer_id', $short_answer_id)->update(['delete' => 1]);
        return $info;
    }

    //教师编辑单选题主页
    public function teacherCompileSingleChoiceIndex($single_choice_id)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->find();
        return $info;
    }

    //教师编辑单选题
    public function teacherCompileSingleChoice($topic, $A, $B, $C, $D, $soleve_thinking, $single_choice_id, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('single_choice')->where('single_choice_id', $single_choice_id)->update(['topic' => $topic, 'A' => $A, 'B' => $B, 'C' => $C, 'D' => $D, 'soleve_thinking' => $soleve_thinking, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }


    //教师编辑判断题主页
    public function teacherCompileTrueOrFalseIndex($true_or_false_id)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->find();
        return $info;
    }

    //教师编辑判断题
    public function teacherCompileTrueOrFalse($topic, $soleve_thinking, $true_or_false_id, $difficulty, $class_num, $class_name, $answer)
    {
        $info = db('true_or_false')->where('true_or_false_id', $true_or_false_id)->update(['topic' => $topic, 'soleve_thinking' => $soleve_thinking, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name, 'answer' => $answer]);
        return $info;
    }

    //教师编辑简答题主页
    public function teacherCompileShortAnswerIndex($short_answer_id)
    {
        $info = db('short_answer')->where('short_answer_id', $short_answer_id)->find();
        return $info;
    }

    //教师编辑简答题
    public function teacherCompileShortAnswer($topic, $soleve_thinking, $short_answer_id, $difficulty, $class_num, $class_name)
    {
        $info = db('short_answer')->where('short_answer_id', $short_answer_id)->update(['topic' => $topic, 'soleve_thinking' => $soleve_thinking, 'difficulty' => $difficulty, 'class_num' => $class_num, 'class_name' => $class_name]);
        return $info;
    }

    //教师查找自己的课堂
    public function teacherFindSelfClass($teacher_num)
    {
        $info = db('class')->where('teacher_num', $teacher_num)->select();
        return $info;
    }


    /*--------------------------------------试卷库管理--------------------------------------*/

    //教师添加试卷
    public function teacherAddPaper($paper_name, $teacher_name, $teacher_num, $class_name, $class_num, $single_choice, $true_or_false, $short_answer, $single_choice_score, $true_or_false_score, $short_answer_score)
    {
        $info = db('paper')->insert(['paper_name' => $paper_name, 'teacher_name' => $teacher_name,
            'teacher_num' => $teacher_num, 'class_name' => $class_name, 'class_num' => $class_num,
            'single_choice' => $single_choice, 'true_or_false' => $true_or_false, 'short_answer' => $short_answer,
            'del' => 0, 'single_choice_score' => $single_choice_score, 'true_or_false_score' => $true_or_false_score,
            'short_answer_score' => $short_answer_score]);
        return $info;
    }

    //教师查找自己的所有试卷
    public function teacherFindSelfPaper($teacher_num)
    {
        $info = db('paper')->where('teacher_num', $teacher_num)->where('del', 0)->select();
        return $info;
    }

    //教师删除试卷
    public function teacherDeletePaper($paper_num)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['del' => 1]);
        return $info;
    }

    //教师恢复试卷
    public function teacherRecoverPaper($paper_num)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['del' => 0]);
        return $info;
    }

    //教师查找已删除的试卷
    public function teacherFindDeletedPaper($teacher_num)
    {
        $info = db('paper')->where('teacher_num', $teacher_num)->where('del', 1)->select();
        return $info;
    }

    //教师更改试卷中包含的判断题
    public function teacherUpdatePaperTrueOrFalse($paper_num, $true_or_false)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['true_or_false' => $true_or_false]);
        return $info;
    }

    //教师更改试卷中包含的选择题
    public function teacherUpdatePaperSingleChoice($paper_num, $single_choice)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['single_choice' => $single_choice]);
        return $info;
    }

    //教师更改试卷中包含的简答题
    public function teacherUpdatePaperShortAnswer($paper_num, $short_answer)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['short_answer' => $short_answer]);
        return $info;
    }

    //教师修改单选题分数
    public function teacherChangeSingleChoiceScore($paper_num, $single_choice_score)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['single_choice_score' => $single_choice_score]);
        return $info;
    }

    //教师修改判断题分数
    public function teacherChangeTrueOrFalseScore($paper_num, $true_or_false_score)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['true_or_false_score' => $true_or_false_score]);
        return $info;
    }

    //教师修改简答题分数
    public function teacherChangeShortAnswerScore($paper_num, $short_answer_score)
    {
        $info = db('paper')->where('paper_num', $paper_num)->update(['short_answer_score' => $short_answer_score]);
        return $info;
    }

    //教师根据试卷号查找学生试卷
    public function teacherCheckStudentPaperSelectStudentPaper($paper_num)
    {
        $info = db('student_answer_paper')->where('paper_num', $paper_num)->select();
        return $info;
    }

    //教师给简答题判分
    public function teacherModifShortAnswerScore($student_answer_paper_id,$short_answer_score)
    {
        $info = db('student_answer_paper')->where('student_answer_paper_id',$student_answer_paper_id)->update(['short_answer_score'=>$short_answer_score]);
        return $info;
    }
}