<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;

class AppController extends Controller {

    /*
     * 登录
     * */
    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        $user = M("volunteer");
        $data = $user->where("username='%s' AND password='%s'", $username, $password)->find();
        if($data) {
            echo $data['id'];
        } else {
            echo "0";
        }
    }

    // app用户注册
    public function register() {
        $username = I('username');
        $password = I('password');
        $password = md5($password);

        $user = M('volunteer');
        $result = $user->where("username='%s'", $username)->find();
        if($result) {
            echo "0";
            return; // 已存在该用户
        } else {
            $user->username = $username;
            $user->password = $password;
            $result = $user->add();
            // 返回用户id
            echo $result;
        }
    }

    // 获取活动列表
    public function getActivityList() {
        $activity = M('activity');
        $list = $activity->where('isend=0')->field('id, name, summary, photo')->select();
        $this->ajaxReturn($list, 'json');
    }

    // 按活动id获取活动详情
    public function getActivityInfoById() {
        $id = I('id');
        $activity = M('activity');
        $data = $activity->where('id=%d', $id)->find();
        $this->ajaxReturn($data, 'json');
    }

    // 上传图片工具函数
    private function uploadPhoto($filekey){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      'Public/Uploads/'; // 设置附件上传根目录
        // 上传单个文件
        $info   =   $upload->uploadOne($_FILES[$filekey]);
        if(!$info) {// 上传错误提示错误信息
            return 0; // 上传失败
        }else{// 上传成功 获取上传文件信息
            $dir =  '/LoveInn/Public/Uploads/' . $info['savepath'].$info['savename'];
            return $dir;
        }
    }

    // 获取个人信息
    public function getVolunteerInfo() {
        $id = I('id');
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->find();
        $this->ajaxReturn($data, 'json');
    }

    // 上传个人头像
    public function uploadAvatar() {
        $id = I('id');
        $uploadResult = $this->uploadPhoto('avatar');
        if($uploadResult == 0) {
            echo '0'; // 上传失败
        } else {
            $volunteer = M('volunteer');
            $volunteer->avatar = $uploadResult;
            $result = $volunteer->where('id=%d', $id)->save();
            if($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    // 获取个人头像地址
    public function getAvatar() {
        $id = I("id");
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->getField('avatar');
        echo $data;
    }

    // 获取学生证地址
    public function getStucard() {
        $id = I("id");
        $volunteer = M('volunteer');
        $data = $volunteer->where('id=%d', $id)->getField('stucard');
        echo $data;
    }


    // 修改个人信息
    public function changeVolunteerInfo() {
        $id = I('id');
        $realname = I('realname');
        $age = I('age');
        $sex = I('sex');
        $idcard = I('idcard');
        $phone = I('phone');
        $address = I('email');
        $info = I('info');
        $uploadStuCardResult = $this->uploadPhoto('stucard');
        if($uploadStuCardResult == 0) {
            echo '0';
        } else {
            $new_volunteer = M('volunteer');
            $new_volunteer->realname = $realname;
            $new_volunteer->age = $age;
            $new_volunteer->sex = $sex;
            $new_volunteer->idcard = $idcard;
            $new_volunteer->phone = $phone;
            $new_volunteer->address = $address;
            $new_volunteer->info = $info;
            $new_volunteer->stucard = $uploadStuCardResult;
            $new_volunteer->ispass = 0;
            $result = $new_volunteer->where('id=%d', $id)->save();
            if($result) {
                echo '1';
            } else {
                echo '0';
            }
        }
    }
}