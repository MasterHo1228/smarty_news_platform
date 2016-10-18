<?php
/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 20:44
 */

/**
 * Class adminController
 * 管理员控制类
 */
class adminController extends platformController {
    /**
     * 登录方法
     */
    public function loginAction(){
        if (!empty($_POST)){
            $adminModel = new adminModel();
            if ($adminModel->checkByLogin()){//登录成功
                session_start();
                $_SESSION['admin'] = 'yes';
                //跳转网页
                $this->jump('index.php?p=admin&c=news&a=list');
            } else {//登录失败
                $this->jump("index.php?p=admin","用户名或密码错误！");
                die;
            }
        }
        require './application/admin/view/admin_login.html';
    }

    /**
     * 登出方法
     */
    public function logoutAction(){
        $_SESSION = null;
        session_destroy();
        //跳转
        $this->jump("index.php?p=admin","登出成功！");
    }
}