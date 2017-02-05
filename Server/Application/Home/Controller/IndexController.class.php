<?php
namespace Home\Controller;

use Think\Controller;
use Think\Exception;

class IndexController extends Controller {

    // 自动运行方法,判断是否登录
    public function _initialize() {
        //当前为登录页时不执行该操作
        if (ACTION_NAME != "login") {
            //判断session['adminaccount']是否为空，是的话跳转到登陆界面
            if (!isset($_SESSION['account'])) {
                echo "<script>alert('用户未登录或登陆超时');</script>";
                $this->redirect("/Home/Index/login");
            } else {
                //显示登录的管理员帐号
                $adminaccount = $_SESSION['account'];
                $power = $_SESSION['power'];
                if($power == 0) {
                    $admin = M('admin')->where("account='" . $adminaccount . "'")->select();
                } else {
                    $admin = M('agency')->where("username='" . $adminaccount . "'")->select();
                    $ispass = $admin[0]['ispass'];
                    $_SESSION['ispass'] = $ispass;
                    $this->assign("ispass", $ispass);
                }

                $name = $admin[0]['name'];
                $this->assign("name", $name);
                $this->assign("power", $power);
            }
        }
    }

    // 主页
    public function index()
    {
        $vo = M('volunteer')->order('id')->select();
        $this->assign("list", $vo);
        $this->display();
    }

    //登录页
    public function login() {
        //不加载模板页
        C('LAYOUT_ON', FALSE);
        $this->display();
        if (IS_POST) {

            $adminaccount = $_POST['adminaccount'];
            $password = $_POST['password'];
            $flag = $_POST['flag'];
            //这里使用md5加密
            $password = md5($password);
            if ($adminaccount == "" || $password == "") {
                echo "<script>alert('请输入用户名和密码！');history.go(-1);</script>";
            } else {
                if($flag == 0) {
                    $admin = M('admin');
                    $result = $admin->where('account="%s" and password="%s"', $adminaccount, $password)->select();
                } else {
                    $agency = M('agency');
                    $result = $agency->where('username="%s" and password="%s"', $adminaccount, $password)->select();
                }

                if ($result) {
                    //将用户账号及权限存入session
                    $_SESSION['account'] = $adminaccount;
                    if($flag == 0) { // 0表示管理员
                        $_SESSION['power'] = 0;
                    } else { // 1表示组织者
                        $_SESSION['power'] = 1;
                    }
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登陆成功');</script>";
                    $this->redirect("/Home/Index");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('登录失败');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
                }
            }
        }
    }

    public function quitlogin() {
        $_SESSION['account'] = null;
        $_SESSION['power'] = null;
        if($_SESSION['ispass']) {
            $_SESSION['ispass'] = null;
        }
        $this->redirect('/Home/Index/login');
    }


    /*判断当前登录的用户是否为组织者, 若不是, 则没有权限执行该操作, 返回主页*/
    private function isAgencyLogin() {
        $power = $_SESSION['power'];
        if($power == 0) { // 0表示管理员
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('您没有权限执行该操作!');</script>";
            $this->redirect("/Home/Index");
        }
    }

    /*判断当前登录的用户是否为管理者, 若不是, 则没有权限执行该操作, 返回主页*/
    private function isAdminLogin() {
        $power = $_SESSION['power'];
        if($power == 1) { // 1表示组织者
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('您没有权限执行该操作!');</script>";
            $this->redirect("/Home/Index");
        }
    }




    /**************************************************************************************/
    /*管理员管理后台*/
    /**************************************************************************************/


    // 活动种类管理
    public function categorys() {
        $category = M('category');
        $list = $category->select();
        $this->assign("list", $list);
        $this->display();
        if(IS_POST) { // 添加
            if(isset($_POST['add'])) {
                $new_category = M('category');
                $data['name'] = $_POST['category_name'];
                $select_re = $new_category->where('name="%s"', $data['name'])->find();
                if($select_re) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('活动名重复');</script>";
                    $this->redirect("/Home/Index/categorys");
                }
                $result = $new_category->add($data);
//                $result = $new_category->add();
                if($result) {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo "<script>alert('添加成功');</script>";
                    $this->redirect("/Home/Index/categorys");
                } else {
                    echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                    echo '<script type="text/javascript">alert("添加失败")</script>';
                    $this->redirect("/Home/Index/categorys");
                }
            }
        }
    }

    // 删除种类
    public function delcategory() {
        $this->isAdminLogin();
        $id = I('request.id');
        $category = M('category');
        $result = $category->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/categorys");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/categorys");
        }
    }

    // 修改种类信息, ajax接口
    public function change_category() {
        $this->isAdminLogin();
        $id = I('post.id');
        $name = I('post.category_change_name');
        $a_category = M('category');
        $select_re = $a_category->where('name="%s"', $name)->find();
        if($select_re) { // 重复
            $this->ajaxReturn('0');
            return;
        }
        $a_category->name = $name;
        $result1 = $a_category->where('id=%d', $id)->save();
        if($result1) { // 成功
            $this->ajaxReturn("1");
        } else { // 失败
            $this->ajaxReturn("-1");
        }
    }

    // 活动列表管理
    public function activities() {
        $this->isAdminLogin();
        $activities = D('ActivityView');
        $list = $activities->where('isend=0')->order('category_name')->select();
        $this->assign('list', $list);
        $this->display();
    }

    // 删除活动
    public function delactivity() {
        $this->isAdminLogin();
        $id = I('id');
        $activity = M('activity');
        $result = $activity->where('id=%d', $id)->delete();
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/activities");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/activities");
        }
    }

    // 查看报名列表
    public function applies() {
        $this->isAdminLogin();
        $applies = D('ApplyView');
        $list = $applies->distinct(true)->field('activity_id,activity_name')->where('isjoin=1')->select();
        foreach ($list as &$item) {
            $activity_id = $item['activity_id'];
            $item['sub'] = $applies->where('activityid=%d and isjoin=1',$activity_id)->field('id,user_id,user_name,time,rate,isjoin,user_realname')->select();
        }
        $this->assign('list', $list);
        $this->display();
    }


    // 志愿者列表_已通过审核
    public function volunteers() {
        $this->isAdminLogin();
        $volunteer = M('volunteer');
        $data = $volunteer->where('ispass=1')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 删除志愿者
    public function delvolunteer() {
        $this->isAdminLogin();
        $id = I('request.id');
        $volunteer = M('volunteer');
        $result = $volunteer->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/volunteers");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/volunteers");
        }
    }

    // 志愿者列表_待审核
    public function volunteers_auth() {
        $this->isAdminLogin();
        $volunteer = M('volunteer');
        $data = $volunteer->where('ispass=0')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 通过志愿者实名认证
    public function volunteer_auth_success() {
        $this->isAdminLogin();
        $id = I('request.id');
        $volunteer = M('volunteer');
        $result = $volunteer->where('id=%d', $id)->setField('ispass', 1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过成功');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过失败');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        }
    }

    // 拒绝志愿者实名认证
    public function volunteer_auth_deny() {
        $this->isAdminLogin();
        $id = I("request.id");
        $volunteer = M('volunteer');
        $result = $volunteer->where('id=%d', $id)->setField('ispass', -1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝成功');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝失败');</script>";
            $this->redirect("/Home/Index/volunteers_auth");
        }
    }


    // 组织者列表_已通过审核
    public function agencys() {
        $this->isAdminLogin();
        $agency = M('agency');
        $data = $agency->where('ispass=1')->select();
        $this->assign("list", $data);
        $this->display();
    }

    // 删除组织者
    public function delagency() {
        $this->isAdminLogin();
        $id = I('request.id');
        $agency = M('agency');
        $result = $agency->delete($id);
        if($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('删除成功');</script>";
            $this->redirect("/Home/Index/agencys");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo '<script type="text/javascript">alert("删除失败")</script>';
            $this->redirect("/Home/Index/agencys");
        }
    }

    // 组织者待实名认证列表
    public function agencys_auth() {
        $this->isAdminLogin();
        $agency = M('agency');
        $data = $agency->where('ispass=0')->select();
        $this->assign('list', $data);
        $this->display();
    }

    // 通过组织者实名认证
    public function agency_auth_success() {
        $this->isAdminLogin();
        $id = I('request.id');
        $agency = M('agency');
        $result = $agency->where('id=%d', $id)->setField('ispass', 1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过成功');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核通过失败');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        }
    }

    // 拒绝组织者实名认证
    public function agency_auth_deny() {
        $this->isAdminLogin();
        $id = I("request.id");
        $agency = M('agency');
        $result = $agency->where('id=%d', $id)->setField('ispass', -1);
        if ($result) {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝成功');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        } else {
            echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
            echo "<script>alert('审核拒绝失败');</script>";
            $this->redirect("/Home/Index/agencys_auth");
        }
    }






    /*****************************************************************************************/
    /*组织者管理后台*/
    /*****************************************************************************************/
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

    public function a_myinfo() {
        $this->isAgencyLogin();
        $agency = M('agency');
        $data = $agency->where('username="%s"', $_SESSION['account'])->find();
        $id = $data['id'];
        if($data['photo'] == null) {
            $data['hasphoto'] = 0;
        } else {
            $data['hasphoto'] = 1;
        }
        if($data['certification'] == null) {
            $data['hascertification'] = 0;
        } else {
            $data['hascertification'] = 1;
        }
        $this->assign('data', $data);
        $this->display();
        if(IS_POST) {
            $new_agency = M('agency');
            $new_agency->name = $_POST['name'];
            $new_agency->address = $_POST['address'];
            $new_agency->contact = $_POST['contact'];
            if(!$_FILES['photo']['name'] == "") { // 若上传的图片为空
                $uploadPhotoResult = $this->uploadPhoto('photo');
                if(!$uploadPhotoResult == 0) {
                    $new_agency->photo = $uploadPhotoResult;
                }
            }
            if(!$_FILES['certification']['name'] == "") {
                $uploadCertificationResult = $this->uploadPhoto('certification');
                if(!$uploadCertificationResult == 0) {
                    $new_agency->certification = $uploadCertificationResult;
                }
            }
            $new_agency->ispass = 0; //改为待审核状态
            $result = $new_agency->where('id=%d', $id)->save();
            if ($result) {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('修改成功, 请等待审核');</script>";
                $this->redirect("/Home/Index/a_myinfo");
            } else {
                echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />';
                echo "<script>alert('修改失败');</script>";
//                dump($result);
                $this->redirect("/Home/Index/a_myinfo");
            }
        }
    }

}