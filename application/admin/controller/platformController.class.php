<?php
/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 20:14
 */

/**
 * Class platformController
 * 平台控制类
 */
class platformController{
    public function __construct()
    {
        $this->checkLogin();
    }

    /**
     * 根据登录状态跳转相应页面
     */
    private function checkLogin(){
        if (CONTROLLER=='admin' && ACTION=='login'){//action为login不需要进行验证
            return;
        }
        session_start();
        if (!isset($_SESSION['admin'])){//若未登录则自动跳转到登录界面
            $this->jump('index.php?p=admin&c=admin&a=login');
        }
    }

    /**
     * 跳转页面
     * @param $url 需要跳转的链接
     * @param string $msg 跳转相应链接前需要回显的信息 默认为空
     * @param int $time 跳转等待的时间 默认为2秒
     */
    protected function jump($url,$msg='',$time=2){
        if ($msg==''){//没有提示信息
            header("Location: $url");
        } else {//有提示信息
            require "./application/admin/view/jump.html";
        }
        die;//终止运行
    }
}