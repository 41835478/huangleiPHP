<?php
namespace Admin\Model;
use Think\Model;
class ArticleModel extends Model
{
    public function _after_insert($data){
        $id = $data['id'];
        foreach($_POST['article_tag_id_list'] as $k => $v){
            $this->execute("insert into article_tag_id values(null,{$v},{$id})");
        }

    }

    public function _before_delete($data,$option){

        $this->execute("delete from article_tag_id where article_id={$data['where']['id']}");

    }

    public function _before_update(&$data,$option){
            //删掉之前标签
        $this->_before_delete($option);

            //添加新的标签
        $arr['id'] = $option['where']['id'];
        $this->_after_insert($arr);
    }


}