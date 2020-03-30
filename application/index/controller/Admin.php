<?php
/**
 * Created by PhpStorm.
 * User: junweihu
 * Date: 2018/10/31
 * Time: 12:47 PM
 */

namespace app\index\controller;

use think\Controller;

class Admin extends Controller
{
    public function index()
    {
        if(session('identity') == 'admin') {      //判断是否为合法登录
            $this->assign('title','管理员中心-主页');
            return $this->fetch('');
        } else {
            return $this->error('身份认证错误，请重新登陆！');
        }
    }

    /*--------------------------------------教师管理--------------------------------------*/
    public function adminAddTeacherIndex()      //管理员添加教师主页
    {
        $this->assign('title','管理员中心-添加教师');
        return $this->fetch('');
    }

    public function adminAddTeacher()       //管理员添加教师
    {
        $data = [
            'username' => input('username'),
            'num' => input('num'),
            'email' => input('email')
        ];
        $admin = model('Admin');
        $tool = model('Tool');

        if($tool->findNum($data['num'])) {
            $this->error('教职工号已被注册，请重新输入教职工号');
        }

        if($tool->findEmail($data['email'])) {
            $this->error('邮箱已被注册，请重新输入邮箱地址');
        }
        if($admin->adminAddTeacher($data['username'], $data['num'], $data['email'])) {
            return $this->success('添加教师成功！初始密码为123456');
        } else {
            return $this->error('添加教师失败！');
        }
    }

    public function adminBanTeacherIndex()       //管理员停用教师账号主页
    {
        $tool = new Tool();
        $teacher = $tool->findNotBanTeacher();
        $this->assign('teacher', $teacher);
        $this->assign('title', '管理员中心-停用教师');
        return $this->fetch('');
    }

    public function adminBanTeacher()       //管理员停用教师账号
    {
        $num = input('num');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 0) {
            return $this->error('该账号为学生账号，请在学生管理菜单中进行管理');
        }

        if($tool->numFindBan($num) == 1) {
            return $this->error('该账号已被停用');
        }

        $admin = model('Admin');
        if($admin->adminBanTeacher($num)) {
            return $this->success('停用教师账号成功！');
        } else {
            return $this->error('停用教师账号失败！');
        }
    }

    public function adminRecoverTeacherIndex()       //管理员恢复教师账号
    {
        $tool = new Tool();
        $teacher = $tool->findBanTeacher();
        $this->assign('teacher', $teacher);
        $this->assign('title', '管理员中心-恢复教师');
        return $this->fetch('');
    }

    public function adminRecoverTeacher()       //管理员恢复教师账号
    {
        $num = input('num');
        $admin = model('Admin');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 0) {
            return $this->error('该账号为学生账号，请在学生管理菜单中进行管理');
        }

        if($tool->numFindBan($num) == 0) {
            return $this->error('该账号未被停用');
        }

        if($admin->adminRecoverTeacher($num)) {
            return $this->success('恢复教师账号成功！');
        } else {
            return $this->error('恢复教师账号失败！');
        }
    }

    public function adminSearchTeacherIndex()        //管理员查找教师账号
    {
        $tool = new Tool();
        $teacher = $tool->findAllTeacher();
        $this->assign('teacher', $teacher);
        $this->assign('title', '管理员中心-查找教师');
        return $this->fetch('');
    }

    public function adminSearchTeacher()        //管理员查找教师账号
    {
        $num = input('num');
        $admin = model('Admin');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 0) {
            return $this->error('该账号为学生账号，请在学生管理菜单中进行管理');
        }

        $teacher_info = $admin->adminSearchTeacher($num);
        $this->assign('teacher_info', $teacher_info);
        $this->assign('title', '管理员中心-查找教师');
        return $this->fetch('');
    }

    /*--------------------------------------学生管理--------------------------------------*/

    public function adminAddStudentIndex()      //管理员添加学生主页
    {
        $this->assign('title', '管理员中心-添加学生');
        return $this->fetch('');
    }

    public function adminAddStudent()       //管理员添加学生
    {
        $data = [
            'username' => input('username'),
            'num' => input('num'),
            'email' => input('email')
        ];
        $admin = model('Admin');
        $tool = model('Tool');

        if($tool->findNum($data['num'])) {
            $this->error('该学号已被注册，请重新输入学号');
        }

        if($tool->findEmail($data['email'])) {
            $this->error('邮箱已被注册，请重新输入邮箱地址');
        }
        if($admin->adminAddStudent($data['username'], $data['num'], $data['email'])) {
            return $this->success('添加学生成功！初始密码为123456');
        } else {
            return $this->error('添加学生失败！');
        }
    }

    public function adminBanStudentIndex()       //管理员停用学生账号主页
    {
        $tool = new Tool();
        $student = $tool->findNotBanStudent();
        $this->assign('student', $student);
        $this->assign('title', '管理员中心-停用学生');
        return $this->fetch('');
    }

    public function adminBanStudent()       //管理员停用学生账号
    {
        $num = input('num');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 1) {
            return $this->error('该账号为教师账号，请在教师管理菜单中进行管理');
        }

        if($tool->numFindBan($num) == 1) {
            return $this->error('该账号已被停用');
        }

        $admin = model('Admin');
        if($admin->adminBanStudent($num)) {
            return $this->success('停用学生账号成功！');
        } else {
            return $this->error('停用学生账号失败！');
        }
    }

    public function adminRecoverStudentIndex()       //管理员恢复学生账号主页
    {
        $tool = new Tool();
        $student = $tool->findBanStudent();
        $this->assign('student', $student);
        $this->assign('title', '管理员中心-恢复学生');
        return $this->fetch('');
    }

    public function adminRecoverStudent()       //管理员恢复学生账号
    {
        $num = input('num');
        $admin = model('Admin');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 1) {
            return $this->error('该账号为教师账号，请在教师管理菜单中进行管理');
        }

        if($tool->numFindBan($num) == 0) {
            return $this->error('该账号未被停用');
        }

        if($admin->adminRecoverStudent($num)) {
            return $this->success('恢复学生账号成功！');
        } else {
            return $this->error('恢复学生账号失败！');
        }
    }

    public function adminSearchStudentIndex()        //管理员查找学生账号主页
    {
        $tool = new Tool();
        $student = $tool->findAllStudent();
        $this->assign('student', $student);
        $this->assign('title', '管理员中心-查找学生');
        return $this->fetch('');
    }

    public function adminSearchStudent()        //管理员查找学生账号
    {
        $num = input('num');
        $admin = model('Admin');
        $tool = new Tool();

        if(!$tool->findNumExist($num)) {
            return $this->error('该账号不存在，请重新输入');
        }

        if($tool->numFindIdentity($num) == 1) {
            return $this->error('该账号为教师账号，请在教师管理菜单中进行管理');
        }

        $student_info = $admin->adminSearchStudent($num);
        $this->assign('student_info', $student_info);
        $this->assign('title', '管理员中心-搜索学生');
        return $this->fetch('');
    }

    /*--------------------------------------课堂管理--------------------------------------*/

    public function adminAddClassIndex()         //管理员添加课堂主页
    {
        $tool = new Tool();
        $this->assign('teacher', $tool->findAllTeacher());
        $this->assign('title', '管理员中心-添加课堂');
        return $this->fetch('');
    }

    public function adminAddClass()         //管理员添加课堂
    {
        $data = [
            'class_name' => input('class_name'),
            'class_num' => input('class_num'),
            'time' => input('time'),
            'teacher_num' => input('teacher_num'),
            'basic_information' => input('basic_information')
        ];

        $admin = model('Admin');
        $tool = model('Tool');
        $controller_tool = new Tool();
        $teacher = $controller_tool->numFindUser($data['teacher_num']);
        if($tool->findRepetitionClassNum($data['class_num'])) {
            return $this->error('该课程号已存在，请重新输入');
        }
        if($admin->adminAddClass($data['class_name'], $data['class_num'], $data['time'], $teacher, $data['teacher_num'], $data['basic_information'])) {
            return $this->success('课堂创建成功');
        }
    }

    public function adminCompileClassIndex()         //管理员编辑课堂主页
    {
        $tool = new Tool();
        $this->assign('teacher', $tool->findAllTeacher());
        //调用查询课堂信息的方法
        return $this->adminSearchClass();
    }

    public function adminCompileClass()         //管理员编辑课堂
    {
        $data = [
            'class_name' => input('class_name'),
            'class_num' => input('class_num'),
            'time' => input('time'),
            'teacher_num' => input('teacher_num'),
            'basic_information' => input('basic_information')
        ];
        $admin = model('Admin');
        $controller_tool = new Tool();
        $teacher = $controller_tool->numFindUser($data['teacher_num']);
        if($admin->adminCompileClass($data['class_name'], $data['class_num'], $data['time'], $teacher, $data['teacher_num'], $data['basic_information'])) {
            return $this->success('课堂修改成功');
        }
    }

    public function adminSearchClassIndex()          //管理员按课程号搜索课程信息
    {
        $func = input('func');
        switch($func) {
            case 'search':
                $this->assign('title', '管理员中心-查询课堂信息');
                $this->assign('inside_title', '查询课堂信息');
                break;
            case 'compile':
                $this->assign('title', '管理员中心-编辑课堂信息');
                $this->assign('inside_title', '编辑课堂信息');
                break;
            case 'ban':
                $this->assign('title', '管理员中心-停用课堂');
                $this->assign('inside_title', '停用课堂');
                break;
        }
        $tool = new Tool();
        $class = $tool->findAllClass();
        $this->assign('class', $class);
        return $this->fetch('');
    }

    public function adminSearchClass()          //管理员按课程号搜索课程信息
    {
        $class_num = input('class_num');
        $tool = new Tool();
        $class_info = $tool->classNumFindClass($class_num);
        $class_student = $tool->findAllStudentInClass($class_num);
        if($class_info) {
            $this->assign('class_student', $class_student);
            $this->assign('class_info', $class_info);
            $this->assign('title', '管理员中心-搜索课堂');
            return $this->fetch('');
        } else {
            return $this->error('查询不到此课程号');
        }
    }

    public function adminBanClass()         //管理员按课程号停用课程
    {
        $class_num = input('class_num');
        $admin = model('Admin');
        if($admin->adminBanClass($class_num)) {
            return $this->success('停用课堂成功！');
        } else {
            return $this->error('停用课堂失败！');
        }
    }

    public function adminRecoverClass()         //管理员按课程号恢复课程
    {
        $class_num = input('class_num');
        $admin = model('Admin');
        if($admin->adminRecoverClass($class_num)) {
            return $this->success('恢复课堂成功！');
        } else {
            return $this->error('恢复课堂失败！');
        }
    }

    public function adminAddClassStudentIndex()      //管理员添加课堂学生主页
    {
        $class_num = input('class_num');
        $tool = new Tool();
        $class_info = $tool->classNumFindClass($class_num);
        $student = $tool->findAllStudent();
        $class_student = $tool->findAllStudentInClass($class_num);

        //只显示不在课堂的学生
        $k = 0;     //循环数
        foreach($student as $i) {
            foreach($class_student as $j) {
                if($i['num'] == $j['student_num']) {
                    unset($student[$k]);        //删除已在此课堂中的学生
                }
            }
            $k++;
        }
        if($class_info) {
            $this->assign('student', $student);
            $this->assign('class_info', $class_info);
            $this->assign('title', '管理员中心-添加课堂学生');
            return $this->fetch('');
        } else {
            return $this->error('查询不到此课程号');
        }
    }

    public function adminAddClassStudent()      //管理员添加课堂学生
    {
        $student_num = input()['student_num'];
        $class_num = input('class_num');
        $tool = new Tool();
        $admin = model('Admin');
        $class_info = $tool->classNumFindClass($class_num);
        foreach($student_num as $num) {
            $student_name = $tool->numFindUser($num);
            if(!$admin->adminAddClassStudent($class_info['class_num'], $class_info['class_name'], $num, $student_name, $class_info['teacher'], $class_info['teacher_num'])) {
                return $this->error('添加失败！');
            }
        }
        return $this->success('添加成功！');
    }
}