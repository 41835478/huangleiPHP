<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class GoodsController extends CommonController
{
    public function add(){
        if(IS_POST){
            $model = D('goods');

            if($info = $model->create()){

                $info['goods_size'] = implode(',',$_POST['size']);

                if($model->add($info)){
                    $this->success('添加成功',U(MODULE_NAME.'/goods/lst'));
                }else{
                    $this->error('添加失败,请重试！');
                }
            }else{

                $this->error('添加失败,请重试！');
            }
        }else{
            $a = D('category');
            $catData = $a->catTree();
            $this->assign('catData',$catData);
            $this->display();
        }
    }

    public function lst(){

        $where = "1";
        if(isset($_GET['un']) && $_GET['un']){
            $where .= " AND goods_name like '%{$_GET['un']}%'";

        }

        $admin = D('goods');
        $goodsData = $admin->field('a.*,b.cat_name')->where($where)->alias('a')->join('left join sh_category b on a.cat_id = b.id')->select();
        $this->assign('goodsData',$goodsData);
        $this->display();
    }
    public function save(){
        $id = $_GET['id'];
        $admin = D('goods');
        if(IS_POST){

            if($admin->create()){

                if($admin->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/Goods/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{

                $this->error('修改失败,请重试！');
            }
        }else{
            $this->data = $admin->find($id);
            $this->catData = D('category')->catTree();
            $this->display();
        }
    }

    public function del(){
        $id = $_GET['id'];
        $admin = D('goods');
        $admin->delete($id);
        $this->success('删除成功');

    }
}