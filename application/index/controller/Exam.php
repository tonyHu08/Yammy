<?php


namespace app\index\controller;
use think\Controller;

class Exam extends Controller
{
    public function index()
    {
        return $this->redirect('Student/studentExamIndex');
        if(session('identity') == 'admin') {        //管理员
            $this->assign('title','管理员中心-主页');
            return $this->fetch('Admin/index');
        }elseif(session('identity') == null ) {      //未登录
            return 'null';
            return '0';
        } elseif(session('identity') == 1) {        //老师
            $this->assign('title','教师中心-首页');
            $teacher_model = model('Teacher');
            $class_info = $teacher_model->teacherFindSelfClass(session('num'));
            $this->assign('class_info', $class_info);
            return $this->fetch('teacher/index');
        }elseif(session('identity') == 0){            //学生
            $this->assign('title','exam_主页');
            return $this->fetch('/index/index');
        }
        return 0;
    }
}