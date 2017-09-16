<?php
/**
 * 商品推荐
 */
namespace Goods\Controller;
use Home\Controller\CommonController;

class RecommendController extends CommonController
{

    //添加
    public function add(){

        if(IS_POST){
            $model = D('recommend');
            if($model->create()){
                if($model->add()){
                    $this->ajaxReturn(array('status'=>true,'result'=>'添加成功~'));exit;
                }else{
                    $this->ajaxReturn(array('status'=>false,'result'=>$model->getDbError()));exit;
                }
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));exit;
            }
        }else{
            $this->display();
        }

    }

    // 列表
    public function lst(){
        $model = M('recommend');
        $recData = $model->select();

        $num = M('recommend_item')->where('pending_status = "审核中"')->count();

        $this->assign('recData',$recData);
        $this->assign('num',$num);
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('recommend');
        if(IS_POST){

            if($model->create()){
                if($model->save()!== false)
                    $this->ajaxReturn(array('status'=>true,'result'=>'修改成功~'));
                else
                    $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>$model->getError()));
            }
        }else{

            $recData = $model->find($id);
            $this->assign('data',$recData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('recommend');
        if($model->delete($id)){
            $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
        }else{
            $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
        }

    }


    //批量删除
    public function plDel(){
        $model = D('recommend');
        $ids = $_POST['dels'];
        if($ids){
            $ids = implode(',',$ids);
            if(!$model->delete($ids)){
                $this->ajaxReturn(array('status'=>false,'result'=>'删除失败，刷新重试！'));
                exit;
            }
        }
        $this->ajaxReturn(array('status'=>true,'result'=>'删除成功~'));
    }

    
    
        // 商品推荐申请
    public function pending_rec(){
        if(IS_POST){

            $value_id = $_POST['value_id'];
            $recId = $_POST['rec_id'];

            if($recId && $value_id){

                $model = M('recommend_item');
                $_recGoodsId = $model->field('rec_id')->where("value_id = '{$value_id}' and type = '商品'")->select();
                $recGoodsId = array_column($_recGoodsId,'rec_id');
                    // 获取两个数组中不相同的，为了不删除已经被推荐的商品
                $arr_diff = implode(',',array_diff($recGoodsId,$recId));


                if($arr_diff){  // 如果值存在，代表，原来推荐的被取消，从数据库删除
                    $where = "rec_id IN({$arr_diff})";
                    $model->where("value_id = '{$value_id}' and type = '商品' and $where")->delete();
                }

                    // 添加两个数组中的不同的推荐id，添加进数据库
                $arr_diff1 = array_diff($recId,$recGoodsId);

                foreach($arr_diff1 as $k => $v){

                        // 如果用户选择了 暂不选择，跳过
                    if($v == 0)
                        continue;

                    $model->add(array(
                        'rec_id' => $v,
                        'value_id' => $value_id,
                        'type' => '商品',
                        'pending_status' => '审核中'
                    ));
                }
                $this->ajaxReturn(array('status' => true,'result' => '提交申请成功~'));exit;

            }else{
                $this->ajaxReturn(array('status' => false,'result' => '提交失败，稍后重试!'));exit;
            }

        }else{


                //  推荐数据
            $recData = M('recommend')->field('id,rec_name,is_checkbox')->where('rec_type = "商品"')->select();
                // 整理出单选的推荐和多选的推荐
            $radioRecData = array();
            $checkboxRecData = array();
            foreach($recData as $k => $v){
                if($v['is_checkbox'] == '可以'){
                    $checkboxRecData[] = $v;
                }else{
                    $radioRecData[] = $v;
                }
            }

            $where = "pending_status = '通过审核'";
                // 如果登录的角色是商家，就取出该商家店铺的所有商品
            if($_SESSION['rid'] == '9'){
                $store_id = M('store')->where("user_id = '{$_SESSION['uid']}'")->getField('id');
                $where .= " AND store_id = '{$store_id}'";
            }

                // 商品信息
            $goodsData = M('goods')->field('id,goods_title')->where($where)->select();
            $this->assign(array(
                'radioRecData' => $radioRecData,
                'checkboxRecData' => $checkboxRecData,
                'goodsData' => $goodsData,
            ));

            if(isset($_GET['gid']) && $_GET['gid']){
                $rec_item = M('recommend_item')->field('rec_id')->where("value_id = '{$_GET['gid']}' and type = '商品'")->select();
                $this->assign('rec_item',$rec_item);

            }

            $this->display();
        }

    }

//    // ajax获取商品推荐
//    public function ajaxGetGoodsRecData(){
//        $id = $_GET['id'];
//        $data = M('recommend_item')->field('rec_id')->where("value_id = '{$id}' and type = '商品'")->select();
//        echo json_encode($data);exit;
//    }

        // 所有商品推荐的信息
    public function pending_rec_lst(){
        $recData = M('recommend_item')->
                        field('a.id,a.pending_status,b.rec_name,c.goods_number,c.goods_title')->
                        alias('a')->
                        join("left join sh_recommend b on a.rec_id = b.id")->
                        join("left join sh_goods c on a.value_id = c.id")->
                        where('type = "商品"')->
                        select();
        $this->assign('recData',$recData);
        $this->display();
    }

        // 删除该商品推荐
    public function pending_rec_delete(){
        $id = $_GET['id'];
        if(M('recommend_item')->delete($id)){
            $this->ajaxReturn(array('status' => true,'result' => '删除成功~'));exit;
        }else{
            $this->ajaxReturn(array('status' => false,'result' => '删除失败！'));exit;

        }
    }
        // ajax设置商品推荐审核状态
    public function set_pending_status(){
        $id = $_POST['id'];
        $status = $_POST['status'];
        $model = M('recommend_item');
        if($status == "1"){
            if($model->where('id='.$id)->setField('pending_status','通过审核') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'操作成功~'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'操作失败！'));
            }
        }else{
            if($model->where('id='.$id)->setField('pending_status','审核未通过') !== false){
                $this->ajaxReturn(array('status'=>true,'result'=>'操作成功~'));
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'操作失败！'));
            }
        }

    }


}