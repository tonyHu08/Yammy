<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/11/26
 * Time: 9:35 AM
 */

namespace app\index\model;

use think\Model;

class Student extends Model
{
    //根据学生学号查找学生所在的课堂信息
    public function studentNumFindClass($student_num)
    {
        $info = db('class_student')->where('student_num', $student_num)->select();
        return $info;
    }

    //插入学生答卷信息
    public function insertStudentTestResult($student_num, $student_name, $class_num, $class_name, $teacher_num, $teacher_name, $paper_num, $paper_name, $sum_score, $score, $single_choice_answer, $true_or_false_answer, $short_answer_answer, $single_choice, $true_or_false, $short_answer)
    {
        $info = db('student_answer_paper')->insert(['student_num' => $student_num, 'student_name' => $student_name, 'class_num' => $class_num, 'class_name' => $class_name, 'teacher_num' => $teacher_num, 'teacher_name' => $teacher_name, 'paper_num' => $paper_num, 'paper_name' => $paper_name, 'sum_score' => $sum_score, 'score' => $score, 'single_choice_answer' => $single_choice_answer, 'true_or_false_answer' => $true_or_false_answer, 'short_answer_answer' => $short_answer_answer, 'time' => time(), 'single_choice' => $single_choice, 'true_or_false' => $true_or_false, 'short_answer' => $short_answer]);
        return $info;
    }
}