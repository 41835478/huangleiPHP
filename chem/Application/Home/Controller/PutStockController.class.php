<?php
namespace Home\Controller;
use Home\Controller\CommonController;
class PutStockController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('putstock');
            $arr = array(
                'stock_id'=>$_POST['stock_id'],
                'acceptor'=>$_POST['acceptor'],
                'buyer'=>$_POST['buyer'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'summary'=>$_POST['summary'],
            );
            if($model->data($arr)->add()){
                $sto = M('stock');
                $goods = $sto->find($arr[stock_id]);
                $a['stock'] = $goods['stock'] + $arr['stock'];
                $sto->where('id='.$arr['stock_id'])->save($a);
                $this->success('添加成功',U(MODULE_NAME.'/putStock/lst'));
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
        $model = M('putstock');
        if(IS_POST){
            $arr = array(
                'stock_id'=>$_POST['stock_id'],
                'acceptor'=>$_POST['acceptor'],
                'buyer'=>$_POST['buyer'],
                'time'=>time(),
                'stock'=>$_POST['stock'],
                'summary'=>$_POST['summary'],
            );
            $data = M('putstock')->find($_POST[id]);
            if($model->where('id='.$_POST['id'])->save($arr) !== false){
                $sto = M('stock');
                $goods = $sto->find($arr[stock_id]);
                //获取到修改后增加库存的数量，并修改
                $a['stock'] = $goods['stock'] + $arr['stock']-$data['stock'];
                $sto->where('id='.$arr['stock_id'])->save($a);
                $this->success('修改成功',U(MODULE_NAME.'/putStock/lst'));
                exit;
            }else{
                $this->error('修改失败,请重试！');
            }
        }else{
            $this->data = M('putstock')->find($id);
            $this->goods = M('stock')->select();
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('putstock')->order('time DESC')->select();
        $this->goods = M('stock')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('putstock')->delete($id);
        $this->success('删除成功！');

    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('putstock');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

}