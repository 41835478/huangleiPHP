<?php
/**
 * 商品分类
 */
namespace Goods\Controller;
use Home\Controller\CommonController;
class CategoryController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){
            $model = D('Category');

            if($model->create()){
                if($model->add()){
                    echo 1;
                }else{
                    echo 2;
                }
            }else{
                echo 2;
            }
        }else{
            $catData = D('Category')->catTree();

            $recData = M('recommend')->field('id,rec_name')->where("rec_type='分类'")->select();
            $this->assign('recData',$recData);
            $this->assign('catData',$catData);

            $this->display();
        }

    }



    //列表
    public function lst(){
        $model = D('Category');
        $catData = $model->catTree();
        $recData = M('recommend')->where("rec_type='分类'")->select();
        $this->assign('data',$catData);
        $this->assign('recData',$recData);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('Category');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false)

                    echo 1;
                else
                    echo 2;

            }else{
                echo 2;
            }
        }else{
            $data = $model->find($id);
                //取出当前分类的被推荐内容
            $rec = M('recommend_item')->where('value_id='.$data['id'].' and type="分类"')->select();

                //整合成一维数组,只包含rec_id
            $rec_arr = array();
            foreach($rec as $k => $v){
                $rec_arr[] = $v['rec_id'];
            }

            $catData = D('Category')->catTree();        //所有分类
            $recData = M('recommend')->field('id,rec_name')->where("rec_type='分类'")->select();  //所有推荐位

            $this->assign(array(
                'data' => $data,
                'catData' => $catData,
                'recData' => $recData,
                'rec' => $rec_arr
            ));
            $this->display();
        }
    }

    //删除
    public function delete(){
        $model = D('Category');
        $id = $_POST['id'];
        $model->delete();
        //获取当前id的所有子id
        $priId = $model->getChildrenPriId($id);
        //将当前id也放到子id的数组中
        $priId[] = $id;
        $priId = implode(',',$priId);
        $model->execute("delete from sh_recommend_item where value_id IN ($priId) and type = '分类'");
        if($model->delete($priId)){
            echo 1;
        }else{
            echo 2;
        }


    }

}