<?php
/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 22:03
 */

/**
 * Class newsModel
 * 新闻模型类
 */
class newsModel extends model {
    /**
     * 查找所有新闻简略数据
     * @param $limit 要显示的新闻数量
     * @return 返回信息集合数组
     */
    public function getAll($limit){
        if ($_SESSION['admin_user']!='admin'){//当登录后台系统的不是admin的话，则只加载对应用户所发表的新闻
            $author = $_SESSION['admin_user'];
            $sql = "SELECT id,author,title,content,date,ip FROM news WHERE author='{$author}' ORDER BY id DESC LIMIT $limit;";
        } else {
            $sql = "SELECT id,author,title,content,date,ip FROM news ORDER BY id DESC LIMIT $limit;";
        }

        $data = $this->db->fetchAll($sql);
        return $data;
    }

    /**
     * 获取管理员用户名
     * @return 返回管理员用户名
     */
    public function getAdminUserName(){
        return $_SESSION['admin_user'];
    }

    /**
     * 新闻总数
     * @return 返回新闻总数量
     */
    public function getNumber(){
        $data = $this->db->fetchRow("SELECT COUNT(*) FROM news ;");
        return $data['COUNT(*)'];
    }

    /**
     * 根据对应新闻ID获取新闻详细信息
     * @return 返回信息集合数组
     */
    public function getById(){
        $id = (int)$_GET['id'];
        $sql = "SELECT author,title,content FROM news WHERE id=$id";
        $data = $this->db->fetchRow($sql);

        if ($data != false){
            $data['title'] = str_replace('<br />','',$data['title']);
            $data['content'] = str_replace('<br />','',$data['content']);
        }
        return $data;
    }

    /**
     * 往数据库添加数据
     * @return 返回是否执行成功
     */
    public function insert(){
        //输入过滤
        $this->filter(array('id'),'intval');
        $this->filter(array('author','title','content'),'htmlspecialchars');
        $this->filter(array('content'),'nl2br');

        //接收输入数据
        $data['author'] = $_POST['author'];
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];
        //为其他字段赋值
        $data['date'] = date('Y-m-d H:i:s');
        $data['ip'] = $_SERVER["REMOTE_ADDR"];//用户端的IP地址

        //拼接SQL语句
        $sql = "insert into `news` set ";
        foreach($data as $k=>$v){
            $sql .= "`$k`='$v',";
        }
        $sql = rtrim($sql,','); //去掉最右边的逗号
        //执行SQL并返回
        return $this->db->query($sql);
    }

    /**
     * 保存更改
     * @return 返回是否执行成功
     */
    public function save(){
        //输入过滤
        $this->filter(array('id'),'intval');
        $this->filter(array('author','title','content'),'htmlspecialchars');
        $this->filter(array('content'),'nl2br');

        $id = $_POST['id'];
        $data['author'] = $_POST['author'];
        $data['title'] = $_POST['title'];
        $data['content'] = $_POST['content'];

        //拼接sql语句
        $sql = "UPDATE news SET ";
        foreach ($data as $k=>$v){
            $sql .= "$k=:$k,";
        }
        $sql = rtrim($sql,',');//去掉最右边的逗号
        $sql .= " where id =$id ;";

        //通过预处理执行SQL
        $this->db->execute($sql,$data,$flag);
        //返回是否执行成功
        return $flag;
    }

    /**
     * 根据对应的新闻ID删除新闻
     * @return 返回是否执行成功
     */
    public function deleteById(){
        $id = (int)$_GET['id'];
        $sql = "DELETE FROM news WHERE id=:id ;";
        $this->db->execute($sql,array(':id'=>$id),$flag);
        return $flag;
    }
}