<?php
/**
 * 新闻模块控制器类
 */
class newsController extends platformController {
	/**
	 * 加载新闻列表
	 */
	public function listAction(){
        //实例化news模型
        $newsModel = new newsModel();
        //获取新闻总数
        $num = $newsModel->getNumber();
        $this->smt->assign('num', $num);
        //实例化分页类
        $page = new page($num,$GLOBALS['config'][PLATFORM]['pagesize']);
        //取得所有新闻简略数据
        $data = $newsModel->getAll($page->getLimit());
        $this->smt->assign('data', $data);
        //获取分页导航链接
        $pageList = $page->getPageList();
        $this->smt->assign('pageList', $pageList);
        //载入视图文件
//		require './application/home/view/news_list.html';
        $this->smt->display('news_list.html');
	}

    /**
     * 显示新闻详细内容
     */
	public function detailAction(){
        if (!isset($_GET['id'])){//当未检测到ID值时，直接返回
            $this->jump('index.php','未找到该新闻！');
            return false;
        } else {
            $newsModel = new newsModel();
            $data = $newsModel->getDetail();
            if ($data == null){
                $this->jump('index.php','找不到这条记录！');
            } else {
                $this->smt->assign('data', $data);
            }
        }
//        require './application/home/view/news_detail.html';
        $this->smt->display('news_detail.html');
    }
}
