<?php
/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 20:45
 */

/**
 * Class adminModel
 * 后台管理模型类
 */
class adminModel extends model {
    /**
     * 验证登录
     * @return bool
     */
    public function checkByLogin(){
        //过滤字符
        $this->filter(array('username','password'),'trim');
        //接收输入字符
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = 'SELECT password,salt FROM admin WHERE username=:username ;';
        $data = $this->db->fetchRow($sql,array(':username'=>$username));
        if (!$data){
            return false;
        } else {
            if (md5($password.$data['salt']) == $data['password']){
                session_start();
                $_SESSION['admin_user'] = $_POST['username'];
                return true;
            } else {
                return false;
            }
        }
    }
}