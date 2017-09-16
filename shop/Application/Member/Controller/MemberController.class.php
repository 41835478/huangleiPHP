<?php
/**
 * 会员列表
 */
namespace Member\Controller;
use Home\Controller\CommonController;
class MemberController extends CommonController
{

    public function lst(){

        /* 获取所有等级 */
        $mlModel = D('member_level');
        /* 获取所有会员*/
        $memberModel = D('member');

        $where = "1";
        if(isset($_GET['level']) && $_GET['level']){
            $where .= " and d.level_name = '{$_GET['level']}'";
        }

        $memberData = $memberModel->query("select * from 
                                            (select * from 
                                              (select a.status,a.id,a.total_cost,a.username,a.nickname,a.email,a.time,b.level_name from sh_member a 
                                                 left join sh_member_level b on a.total_cost >= b.lowest_cost
                                                    order by b.lowest_cost desc) as c 
                                                        group by c.username) as d where $where
                                          ");

        // 统计各等级各有多少人
        $countLevel = $mlModel->getCountLevel();
        
        $this->assign(array(
            'countLevel'=>$countLevel,
            'memberData' => $memberData,
        ));
        $this->display();
    }

    // ajax 异步获取统计各等级信息，供echarts饼状图使用
    public function ajaxGetCountLevel(){
        $mlModel = D('member_level');
        $countLevel = $mlModel->getCountLevel();
        $level_name = array_column($countLevel,'name');
        $this->ajaxReturn(array('level_name'=>$level_name,'countLevel'=>$countLevel));

    }

    // 设置用户状态
    public function setStatus(){
        $model = M('member');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('status','启用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('status','停用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }
    //删除品牌
    public function delete($id){
        $model = D('member');

        if($model->delete($id)){
            echo 1;
        }else{
            echo 2;
        }
    }

    /* 会员记录管理，获取积分、浏览条数、购买数目 */
    public function record(){

        $data  = M('member')->query("
            select a.id,a.nickname,a.username,a.points,count(b.id) record_number from sh_member a 
            left join sh_record b on a.id = b.user_id
            group by a.id
        ");

        $_orders = M('orders')->query("
            select a.id,count(b.id) number from sh_member a 
            left join sh_orders b on a.id = b.user_id
            group by b.ordersn,a.id
        ");

        /* 根据用户id分组 */
        $orders = array();
        foreach($_orders as $k => $v){
            if(!$v['number'])
                continue;
            $orders[$v['id']][] = $v;
        }

        /* 将用户订单信息存入$data数组中 */
        foreach($data as $k => $v){
            $data[$k]['orders_number'] = count($orders[$v['id']]);
        }
        $this->assign('data',$data);
        $this->display();

    }

    /* 获取用户的浏览记录 */
    public function getBrowseHistory(){
        if(IS_AJAX){
            $user_id = $_GET['user_id'];
            $data = M('record')->query("
                select a.time,b.id goods_id,b.goods_title,b.goods_shop_price from sh_record a 
                left join sh_goods b on a.goods_id = b.id
                where a.user_id = '{$user_id}'
            ");

            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'暂无浏览记录'));exit;
            }
        }
    }

    /* 获取用户的购物记录 */
    public function getOrderHistory(){
        if(IS_AJAX){
            $user_id = $_GET['user_id'];
            $data = M('orders')->query("
                select ordersn,status,pay_time from sh_orders 
                where user_id = '{$user_id}' and status != '待付款'
                group by ordersn
            ");

            if($data){
                $this->ajaxReturn(array('status'=>true,'result'=>$data));exit;
            }else{
                $this->ajaxReturn(array('status'=>false,'result'=>'暂无购物记录'));exit;
            }
        }
    }

    

}