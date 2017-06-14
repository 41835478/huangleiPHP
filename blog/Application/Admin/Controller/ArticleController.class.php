<?php
namespace Admin\Controller;
use Admin\Controller\CommonController;
class ArticleController extends CommonController
{
        //添加
    public function add(){

        if(IS_POST){

            $model = D('article');
            $data['ar_title'] = $_POST['ar_title'];
            $data['ar_author'] = $_POST['ar_author'];
            $data['ar_content'] = $_POST['ar_content'];
            $data['ar_show_status'] = $_POST['ar_show_status'];
            $data['ar_category_id'] = $_POST['ar_category_id'];
            $data['ar_time'] = date("Y-m-d H:i:s");

            if($model->where('ar_title="'.$data['ar_title'].'"')->count() > 0){
                $this->ajaxReturn(array('status'=>false,'result'=>'换个标题吧，重复了~'));exit;
            }

            if($model->add($data)){

                $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'添加失败，请刷新重试'));exit;
            }
        }else{
            $catData = M('category')->where('cat_show_status="启用"')->select();
            $tagData = M('tag')->select();
            $this->assign(array(
                'tagData' => $tagData,
                'catData' => $catData,
            ));
            $this->display();
        }


    }

        //列表
    public function lst(){

        $where = "1";
        if(isset($_GET['search']) && $_GET['search']){
            $where .= " and ar_title = '{$_GET['search']}'";
        }

        $model = M('article');
        $artData = $model->query("
                    select a.*,b.cat_name,GROUP_CONCAT(d.tag_name separator ',') tags,GROUP_CONCAT(d.tag_background_color separator ',') colors from blog_article a 
                      left join blog_category b on a.ar_category_id = b.id 
                        left join article_tag_id c on c.article_id = a.id 
                          left join blog_tag d on c.tag_id = d.id 
                            where $where
                              group by a.id
                                order by a.id desc
                            
        ");
        $this->assign('artData',$artData);
        $this->display();
    }

        //修改
    public function save($id){

        $model = D('article');
        if(IS_POST){

            $data['id'] = $_POST['id'];
            $data['ar_title'] = $_POST['ar_title'];
            $data['ar_author'] = $_POST['ar_author'];
            $data['ar_content'] = $_POST['ar_content'];
            $data['ar_show_status'] = $_POST['ar_show_status'];
            $data['ar_category_id'] = $_POST['ar_category_id'];

            if($model->save($data) !== false){


                $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'修改失败，请刷新重试'));exit;
            }
        }else{
            $data = $model->query("
                    select a.id,a.ar_title,a.ar_author,a.ar_content,a.ar_category_id,a.ar_show_status,GROUP_CONCAT(c.tag_id separator ',') tags_id_list from blog_article a 
                        left join article_tag_id c on c.article_id = a.id 
                            where a.id=$id
                                group by a.id
                            
            ");
            $catData = M('category')->where('cat_show_status="启用"')->select();
            $tagData = M('tag')->select();
            $this->assign(array(
                'tagData' => $tagData,
                'catData' => $catData,
                'data' => $data[0],
            ));
            $this->display();
        }


    }

        //删除
    public function delete($id){

        $model = D('article');

        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败！'));
        }
    }

        //修改显示状态
    public function setShowStatus(){
        $model = M('article');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('ar_show_status','启用')){

                $this->ajaxReturn(array('status'=>true,'result'=>'已启用~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'启用失败！'));exit;
            }

        }else{
            if($model->where('id='.$id)->setField('ar_show_status','停用')){

                $this->ajaxReturn(array('status'=>true,'result'=>'已停用~'));exit;
            }else{

                $this->ajaxReturn(array('status'=>false,'result'=>'停用失败！'));exit;
            }
        }
    }
        //排序
    public function sort(){
        $num = $_POST['num'];
        $id = $_POST['id'];
        $model = M('article');

        if($model->where('id='.$id)->setField('ar_order',$num) !== false)
            $this->ajaxReturn(array('status'=>true,'result'=>'更改成功~'));
        else
            $this->ajaxReturn(array('status'=>false,'result'=>'更改失败！'));

    }

    public function getArticleContent(){
        $id = $_GET['id'];
        $model = M('article');
        if($data = $model->find($id))
            $this->ajaxReturn(array('status'=>true,'title'=>$data['ar_title'],'result'=>$data['ar_content']));
        else
            $this->ajaxReturn(array('status'=>false,'title'=>'文章标题获取失败！','result'=>'文章内容获取失败！'));

    }


}