<?php


namespace app\index\controller;

use think\Controller;

class Tool extends Controller
{
    public function loginStatusVerify()
    {
        if (session('username') == null) {            //如果还未登录
            return $this->fetch('Login/login');
        }
    }

    /*--------------------------------------账号查找--------------------------------------*/

    public function findNumExist($num)      //查找账号是否存在
    {
        $tool = model('Tool');
        return $tool->findNumExist($num);
    }

    public function regName()       //动态验证注册用户名是否可用
    {
        $username = input('name');
        $userlist = model('Tool');
        if ($userlist->findUsername($username)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function numFindUser($num)       //根据学号查找用户名
    {
        $tool = model('Tool');
        return $tool->numFindUser($num);
    }

    public function numFindIdentity($num)       //根据学号查找身份
    {
        $tool = model('Tool');
        return $tool->numFindIdentity($num);
    }

    public function numFindBan($num)        //根据学号查找Ban状态
    {
        $tool = model('Tool');
        return $tool->numFindBan($num);
    }

    public function findAllTeacher()        //查找全部老师
    {
        $tool = model('Tool');
        return $tool->findAllTeacher();
    }

    public function findBanTeacher()        //查找被停用账号老师
    {
        $tool = model('Tool');
        return $tool->findBanTeacher();
    }

    public function findNotBanTeacher()        //查找没有被停用账号老师
    {
        $tool = model('Tool');
        return $tool->findNotBanTeacher();
    }

    public function findBanStudent()        //查找被停用账号学生
    {
        $tool = model('Tool');
        return $tool->findBanStudent();
    }

    public function findNotBanStudent()        //查找没有被停用账号学生
    {
        $tool = model('Tool');
        return $tool->findNotBanStudent();
    }

    public function findAllStudent()        //查找全部学生
    {
        $tool = model('Tool');
        return $tool->findAllStudent();
    }

    public function findAllStudentInClass($class_num)         //按课程号查找在此课堂的学生
    {
        $tool = model('Tool');
        return $tool->findAllStudentInClass($class_num);
    }

    public function findAllClass()          //查找全部课堂
    {
        $tool = model('Tool');
        return $tool->findAllClass();
    }

    /*--------------------------------------课堂管理--------------------------------------*/

    public function classNumFindClass($class_num)     //根据课程号查找课程信息
    {
        $tool = model('Tool');
        return $tool->classNumFindClass($class_num);
    }

    public function classNumFindSingleChoice($class_num)      //根据课程号查找单选题
    {
        $tool = model('Tool');
        if ($tool->classNumFindSingleChoice($class_num)) {
            return $tool->classNumFindSingleChoice($class_num);
        } else {
            return null;
        }
    }

    public function classNumFindTrueOrFalse($class_num)      //根据课程号查找判断题
    {
        $tool = model('Tool');
        if ($tool->classNumFindTrueOrFalse($class_num)) {
            return $tool->classNumFindTrueOrFalse($class_num);
        } else {
            return null;
        }
    }

    public function classNumFindShortAnswer($class_num)
    {
        $tool = model('Tool');
        if ($tool->classNumFindShortAnswer($class_num)) {
            return $tool->classNumFindShortAnswer($class_num);
        } else {
            return null;
        }
    }

    public function classNumFindAllTestQuestions($class_num)        //根据课程号查找所有题
    {
        $tool['single_choice'] = $this->classNumFindSingleChoice($class_num);
        $tool['true_or_false'] = $this->classNumFindTrueOrFalse($class_num);
        $tool['short_answer'] = $this->classNumFindShortAnswer($class_num);
        return $tool;
    }

    public function singleChoiceIdFindSingleChoice($single_choice_id)       //根据单选题id查找单选题
    {
        $tool = model('Tool');
        return $tool->singleChoiceIdFindSingleChoice($single_choice_id);
    }

    public function trueOrFalseIdFindTrueOrFalse($true_or_false_id)       //根据单选题id查找单选题
    {
        $tool = model('Tool');
        return $tool->trueOrFalseIdFindTrueOrFalse($true_or_false_id);
    }

    public function shortAnswerIdFindShortAnswer($short_answer_id)
    {
        $tool = model('Tool');
        return $tool->shortAnswerIdFindShortAnswer($short_answer_id);
    }


    /*--------------------------------------试卷库管理--------------------------------------*/
    public function paperNumFindPaper($paper_num)       //根据试卷号查找试卷信息
    {
        $tool = model('Tool');
        return $tool->paperNumFindPaper($paper_num);
    }

    public function classNumFindPaper($class_num)
    {
        $tool = model('Tool');
        return $tool->classNumFindPaper($class_num);
    }



    /*--------------------------------------将试卷库中的试题号字符串转为题信息数组--------------------------------------*/

    //单选题
    public function singleChoiceStrToArr($str)
    {
        $single_choice_arr = explode('|', $str);
        $single_choice = [];
        foreach ($single_choice_arr as $num => $i) {
            $single_choice[$num] = $this->singleChoiceIdFindSingleChoice($i);
        }
        $single_choice = array_filter($single_choice);
        return $single_choice;
    }

    //判断题
    public function trueOrFalseStrToArr($str)
    {
        $true_or_false_arr = explode('|', $str);
        $true_or_false = [];
        foreach ($true_or_false_arr as $num => $i) {
            $true_or_false[$num] = $this->trueOrFalseIdFindTrueOrFalse($i);
        }
        $true_or_false = array_filter($true_or_false);
        return $true_or_false;
    }

    //简答题
    public function shortAnswerStrToArr($str)
    {
        $short_answer_arr = explode('|', $str);
        $short_answer = [];
        foreach ($short_answer_arr as $num => $i) {
            $short_answer[$num] = $this->shortAnswerIdFindShortAnswer($i);
        }
        $short_answer = array_filter($short_answer);
        return $short_answer;
    }

    //根据答卷号查找答卷
    public function studentAnswerPaperIdFindPaper($student_answer_paper_id)
    {
        $tool = model('Tool');
        return $tool->studentAnswerPaperIdFindPaper($student_answer_paper_id);
    }

    //根据考生学号查找考卷
    public function studentNumFindPaper($student_num)
    {
        $tool = model('Tool');
        return $tool->studentNumFindPaper($student_num);
    }


    public function sendMail()         //发送邮件
    {
        return $this->redirect('Mail/index', ['email' => input('email'), 'username' => session('username')]);
    }

    public function exitLogin()         //退出登录
    {
        session('username', null);
        session('headimg', null);
        session('identity', null);
        session('num', null);
        return $this->redirect('Index/index');
    }
}