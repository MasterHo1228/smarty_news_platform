<?php
/**
 * news模型类
 */
class newsModel extends model{
    /**
     * 查找所有新闻简略数据
     * @param $limit 要显示的新闻数量
     */
	public function getAll($limit){
        $order = '';
        if (isset($_GET['sort']) && $_GET['sort']=='desc'){
            $order = "ORDER BY id DESC";
        }
        $sql = "SELECT id,author,title,date FROM news $order LIMIT $limit;";
        $data = $this->db->fetchAll($sql);
        return $data;
    }

    /**
     * 新闻总数
     */
    public function getNumber(){
        $data = $this->db->fetchRow("SELECT COUNT(*) FROM news ;");
        return $data['COUNT(*)'];
    }

    /**
     * 获取新闻详细内容
     * @return 新闻内容集合数组
     */
    public function getDetail(){
        if (isset($_GET['id'])){
            $newsID = (int)$_GET['id'];
            $sql = "SELECT author,title,content,date FROM news WHERE id=$newsID;";
            $data = $this->db->fetchRow($sql);
        }
        return $data;
    }
}
