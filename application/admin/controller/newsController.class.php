<?php
/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 21:58
 */

/**
 * Class newsController
 * 新闻控制类
 */
class newsController extends platformController {
    /**
     * 加载新闻列表
     */
    public function listAction(){
        //实例化news模型
        $newsModel = new newsModel();
        //获取管理员用户名
        $adminUserName = $newsModel->getAdminUserName();
        //获取新闻总数
        $num = $newsModel->getNumber();
        //实例化分页类
        $page = new page($num,$GLOBALS['config'][PLATFORM]['pagesize']);
        //取得所有留言数据
        $data = $newsModel->getAll($page->getLimit());
        //获取分页导航链接
        $pageList = $page->getPageList();
        //载入视图文件
        require './application/admin/view/news_list.html';
    }

    /**
     * 加载发布新闻页
     */
    public function addAction(){
        //实例化news模型
        $newsModel = new newsModel();
        //获取管理员用户名
        $adminUserName = $newsModel->getAdminUserName();
        require './application/admin/view/news_add.html';
    }

    /**
     * 发布新闻
     */
    public function publishAction(){
        if(empty($_POST)){
            return false;
        }
        //实例化news模型
        $newsModel = new newsModel();
        //调用insert方法
        $pass = $newsModel->insert();
        //判断是否执行成功
        if($pass){
            //成功时
            $this->jump('index.php?p=admin&c=news&a=list','新闻发布成功');
        }else{
            //失败时
            $this->jump('index.php?p=admin&c=news&a=list','新闻发布失败');
        }
    }

    /**
     * 编辑新闻
     */
    public function editAction(){
        if (!isset($_GET['id'])){
            return false;
        }
        //实例化comment模型
        $newsModel = new newsModel();
        $data = $newsModel->getById();
        if ($data==false){
            $this->jump('index.php?p=admin&c=news&a=list',"找不到这条记录！");
        }
        require './application/admin/view/news_edit.html';
    }

    /**
     * 更新新闻
     */
    public function updateAction(){
        if (empty($_POST)){
            return false;
        }
        //实例化comment模型
        $newsModel = new newsModel();
        if ($newsModel->save()){
            $this->jump('index.php?p=admin&c=news&a=list',"新闻修改成功！");
        } else {
            die("更新记录失败！");
        }
    }

    /**
     * 删除新闻
     */
    public function deleteAction(){
        if (!isset($_GET['id'])){
            return false;
        }
        //实例化comment模型
        $newsModel = new newsModel();
        if ($newsModel->deleteById()){
            $this->jump('index.php?p=admin&c=news&a=list',"新闻删除成功！");
        } else {
            die("更新记录失败！");
        }
    }
}