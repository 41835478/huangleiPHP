<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class OutStockController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('outstock');
            //接收数据
            $arr = array(
                'stock_id'=>$_POST['stock_id'],
                'sybm'=>$_POST['sybm'],
                'used'=>$_POST['used'],
                'leader'=>$_POST['leader'],
                'operator'=>$_POST['operator'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'summary'=>$_POST['summary'],
            );
            $data = M('stock')->find($arr['stock_id']);
            $arr['price'] = $data['price'] * $arr['stock'];

            if($model->data($arr)->add()){
                //出库的同时，向结算清单中添加出库信息
                $a = $model->order('id DESC')->limit('1')->select();
                $arr1 = array(
                    'stock_id'=>$_POST['stock_id'],
                    'leader'=>$_POST['leader'],
                    'operator'=>$_POST['operator'],
                    'time'=>time(),
                    'stock'=>$_POST['stock'],
                    'price'=>$arr['price'],
                    'uid'=>$a[0]['id'],
                    'status'=>0,
                );
                M('clear')->data($arr1)->add();
                $sto = M('stock');
                $goods = $sto->find($arr[stock_id]);
                $a['stock'] = $goods['stock'] - $arr['stock'];
                if($a['stock'] >= 0){
                    $sto->where('id='.$arr['stock_id'])->save($a);
                    $this->success('添加成功',U(MODULE_NAME.'/outStock/lst'));
                }else{
                    $this->error('添加失败,请重试！');
                }
            }else{
                $this->error('添加失败,请重试！');
            }
        }else{
            $this->goods = M('stock')->select();
            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $model = M('outstock');
        if(IS_POST){
            $arr = array(
                'stock_id'=>$_POST['stock_id'],
                'sybm'=>$_POST['sybm'],
                'used'=>$_POST['used'],
                'leader'=>$_POST['leader'],
                'operator'=>$_POST['operator'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'summary'=>$_POST['summary'],
            );
            $a = M('stock')->find($arr['stock_id']);
            $arr['price'] = $a['price'] * $arr['stock'];
            $arr1 = array(
                'stock_id'=>$_POST['stock_id'],
                'leader'=>$_POST['leader'],
                'operator'=>$_POST['operator'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'price'=>$arr['price'],
            );
            M('clear')->where('uid='.$_POST[id])->save($arr1);
            $data = M('outstock')->find($_POST[id]);
            if($model->where('id='.$_POST[id])->save($arr) !== false){

                $sto = M('stock');
                $goods = $sto->find($arr[stock_id]);
                //获取到修改后增加库存的数量，并修改
                $a['stock'] = $goods['stock'] - $arr['stock']+$data['stock'];
                if($a['stock'] >=0){
                    $sto->where('id='.$arr['stock_id'])->save($a);
                    $this->success('修改成功',U(MODULE_NAME.'/outStock/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }

            }else{
                $this->error('修改失败,请重试！');
            }

        }else{
            $this->data = M('outstock')->find($id);
            $this->goods = M('stock')->select();
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('outstock')->order('time DESC')->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('outstock')->delete($id);
        $this->success('删除成功！');

    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('outstock');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}