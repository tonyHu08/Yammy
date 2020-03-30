<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/31
 * Time: 2:41 PM
 */

namespace app\index\model;

use think\Model;

class Admin extends Model
{
    //管理员添加教师账号
    public function adminAddTeacher($username, $num, $email)
    {
        $info = db('userlist')->insert(['username' => $username, 'password' => 123456, 'num' => $num, 'email' => $email,
            'regtime' => time(), 'active' => 0, 'ban' => 0, 'headimg' => '/static/headimg/moren.png', 'identity' => 1]);
        return $info;
    }

    //管理员停用教师账号
    public function adminBanTeacher($num)
    {
        $info = db('userlist')->where('num', $num)->update(['ban' => 1]);
        return $info;
    }

    //管理员恢复教师账号
    public function adminRecoverTeacher($num)
    {
        $info = db('userlist')->where('num', $num)->update(['ban' => 0]);
        return $info;
    }

    //管理员查找教师账号
    public function adminSearchTeacher($num)
    {
        $info = db('userlist')->where('num', $num)->find();
        return $info;
    }

    /*--------------------------------------学生管理--------------------------------------*/


    //管理员添加学生账号
    public function adminAddStudent($username, $num, $email)
    {
        $info = db('userlist')->insert(['username' => $username, 'password' => 123456, 'num' => $num, 'email' => $email,
            'regtime' => time(), 'active' => 0, 'ban' => 0, 'headimg' => '/static/headimg/moren.png', 'identity' => 0]);
        return $info;
    }

    //管理员停用学生账号
    public function adminBanStudent($num)
    {
        $info = db('userlist')->where('num', $num)->update(['ban' => 1]);
        return $info;
    }

    //管理员恢复学生账号
    public function adminRecoverStudent($num)
    {
        $info = db('userlist')->where('num', $num)->update(['ban' => 0]);
        return $info;
    }

    //管理员查找学生账号
    public function adminSearchStudent($num)
    {
        $info = db('userlist')->where('num', $num)->find();
        return $info;
    }


    /*--------------------------------------课堂管理--------------------------------------*/

    //管理员添加课堂
    public function adminAddClass($class_name, $class_num, $time, $teacher, $teacher_num, $basic_information)
    {
        $info = db('class')->insert(['class_name' => $class_name, 'class_num' => $class_num, 'time' => $time, 'teacher' => $teacher,
            'teacher_num' => $teacher_num, 'basic_information' => $basic_information, 'creat_time' => time(), 'ban' => 0]);
        return $info;
    }


    //管理员修改课堂
    public function adminCompileClass($class_name, $class_num, $time, $teacher, $teacher_num, $basic_information)
    {
        $info = db('class')->where('class_num', $class_num)->update(['class_name' => $class_name, 'time' => $time, 'teacher' => $teacher,
            'teacher_num' => $teacher_num, 'basic_information' => $basic_information, 'creat_time' => time(), 'ban' => 0]);
        return $info;
    }

    //管理员停用课堂
    public function adminBanClass($class_num)
    {
        $info = db('class')->where('class_num', $class_num)->update(['ban' => 1]);
        return $info;
    }

    //管理员恢复课堂
    public function adminRecoverClass($class_num)
    {
        $info = db('class')->where('class_num', $class_num)->update(['ban' => 0]);
        return $info;
    }

    //管理员添加课堂学生
    public function adminAddClassStudent($class_num, $class_name, $student_num, $student_name, $teacher_name, $teacher_num)
    {
        $info = db('class_student')->insert(['class_num' => $class_num, 'class_name' => $class_name, 'student_num' => $student_num,
            'student_name' => $student_name, 'teacher_num' => $teacher_num, 'teacher_name' => $teacher_name]);
        return $info;
    }
}