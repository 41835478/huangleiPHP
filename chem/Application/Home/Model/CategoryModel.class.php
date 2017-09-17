<?php
namespace Home\Model;
use Think\Model;
use Think\Page;

class CategoryModel extends Model{

    //自定义一个search方法，返回admin表中的数据，并且返回分页代码
        //目的，减少代码量，逻辑更清晰
    public function search(){
        $where = 1;
        if(isset($_GET['un']) && $_GET['un']){
            $where = 'username LIKE "%'.$_GET['un'].'%"';
        }
        //每页显示的条数
        $perpage = 15;
        $totalRecord = $this->where($where)->count();   //记录总条数
        $page = new Page($totalRecord,$perpage);
        return array(
            'data'=> $this->where($where)->limit($page->firstRow.','.$page->listRows)->select(),
            'page'=> $page->show(),
        );
    }
    public function catTree(){
        $data = $this->select();
        return $this->_reSort($data);
    }
    /*
     * 无限级分类的核心原理：就是递归！！！
     *          先找出父类，再根据父类id找出子类，每深入一层$level+1 ： 用来代表级别
     */
    private function _reSort($data,$parent_id = 0,$level = 0){
        static $ret = array();
        foreach($data as $v){
            //找出父类，也就是parent_id=0
            if($v['parent_id'] == $parent_id){
                $v['level'] = $level;
                //找到父类后，将父类内容放到ret数组中
                $ret[] = $v;
                //再一次调用递归函数，深入一层，若存在很多子类，则不停的深入
                $this->_reSort($data,$v['id'],$level+1);
            }
        }
        return $ret;
    }
    //获取一个分类的所有子分类的ID
    public function getChildrenId($catID){
        $data = $this->select();
        return $this->_getChildrenId($data,$catID);
    }
    //递归函数，根据父类将所有子分类的id整合在一起
    private function _getChildrenId($data,$parent_id){
        static $ret = array();
        foreach($data as $v){

            if($v['parent_id'] == $parent_id){
                $ret[] = $v['id'];
                $this->_getChildrenId($data,$v['id']);
            }
        }
        return $ret;
    }

    //钩子函数，删除之前调用此函数
    protected function _before_delete($options){

        //因为删除多条和删除一条的时候 id分别数组和int型的一个数值，所以根据数组判断是否为删除多条
        if(is_array($options['where']['id'])){
            //因$options['where']['id'][1]的形式是字符串，用explode形式将其转换成数组形式，以便于遍历
            $id = explode(',',$options['where']['id'][1]);
            $child = array();
            foreach($id as $v){
                $child = $this->getChildrenId($v);
            }
            //去掉重复的id
            $child = array_unique($child);
            $child = implode(',',$child);
            $this->execute("delete from category where id IN($child)");

        }else{
            $a = $options['where']['id'];
            //单选删除 根据删除的id，找到对应的所有子分类，并整合成用‘逗号’隔开的字符串，删除掉
            //注意 此处 必须要在ececute中写sql语句删除，若调用delete方法，会陷入死循环，因为这是一个删除之前的钩子函数
            $child = $this->getChildrenId($options['where']['id']);
            if(empty($child)){
                $this->execute("delete from category where id='$a'");
            }else{
                //将数组id整合成字符串的形式 用implode函数
                $child = implode(',',$child);
                $this->execute("delete from category where id IN($child)");
            }

        }

    }
}