<?php

/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 17:03
 */
class platformController{

    public function __construct() {//实例化
        $this->smt = new Smarty; //自动加载Smarty
        //必要的配置
        $this->smt->setTemplateDir('./application/home/view/');//模板目录
        $this->smt->setCompileDir('./application/home/runtime/view_c/');//模板缓存目录
        //配置分界标识符
        $this->smt->left_delimiter = '{{';
        $this->smt->right_delimiter = '}}';
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
            require "./application/home/view/jump.html";
        }
        die;//终止运行
    }
}