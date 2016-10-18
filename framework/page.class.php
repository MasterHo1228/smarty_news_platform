<?php

/**
 * Created by IntelliJ IDEA.
 * User: MasterHo
 * Date: 2016/9/28
 * Time: 17:27
 */

/**
 * Class page
 * page基础类
 */
class page{
    private $total;//总页数
    private $size;//每页记录数
    private $url;//URL链接
    private $page;//当前页码

    public function __construct($total,$size,$url='')
    {
        //计算页数，向上取整
        $this->total = ceil($total / $size);
        //获取每页的记录数
        $this->size = $size;
        //为URL添加get参数
        $this->url = $this->setUrl($url);
        //获取当前页码
        $this->page = $this->getNowPage();
    }

    /**
     * 为URL设置GET参数，去掉page参数
     * @param $url
     * @return string
     */
    private function setUrl($url){
        if (isset($url)){
            $params = $_GET;//获取全部get参数
            unset($params['page']);//去掉page参数
            $url = http_build_query($params);//重构url
            return $url ? "?$url&" : '?';
        } else {
            return "";
        }
    }

    /**
     * 获取当前页码
     */
    private function getNowPage(){
        $page = empty($_GET['page']) ? 1 : $_GET['page'];

        if ($page < 1){
            $page = 1;
        } elseif ($page > $this->total){
            $page = $this->total;
        }
        return $page;
    }

    public function getPageList(){
        //当总页数不超过1页时 返回空值
        if ($this->total <=1){
            return '';
        }
        //拼接分页导航栏的html
        $html = '';
        if ($this->page > 4){
            $html = "<a href=\"{$this->url}page=1\">1</a>...";
        }

        for ($i=$this->page-3,$len=$this->page+3;$i<$len && $i<=$this->total;$i++){
            if ($i>0){
                if ($i==$this->page){
                    $html .= "<a href=\"{$this->url}page=$i\" class=\"curr\">$i</a>";
                } else {
                    $html .= "<a href=\"{$this->url}page=$i\">$i</a>";
                }
            }
        }

        if ($this->page+3 < $this->total){
            $html .= "...<a href=\"{$this->url}page=\"{$this->total}\">{$this->total}</a>";
        }

        return $html;
    }

    public function getLimit(){
        if ($this->total==0){
            return '0,0';
        }
        return ($this->page-1) * $this->size . ", {$this->size}";
    }
}