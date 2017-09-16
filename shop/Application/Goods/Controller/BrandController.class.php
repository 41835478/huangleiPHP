<?php
/**
 * 品牌
 */
namespace Goods\Controller;
use Home\Controller\CommonController;
use Think\Image;
use Think\Upload;

class BrandController extends CommonController
{

    //添加品牌
    public function add(){
        if(IS_POST){
            $model = D('brand');
            $arr = array();
            if($msg = $model->create()){

                if(isset($_FILES['brand_img']['tmp_name']) && $_FILES['brand_img']['tmp_name']){

                    $upload = new Upload();
                    $upload->maxsize = 5242880;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->savePath = 'brand/';
                    $info = $upload->upload();
                    $path = $info['brand_img']['savepath'].$info['brand_img']['savename'];
                    if($info){
                        $image = new Image();
                        $image->open('./Uploads/'.$path);
                        $image->thumb(C('BRAND_LOGO_IMG_WIDTH'),C('BRAND_LOGO_IMG_HEIGHT'))->save('./Uploads/'.$path);
                        $msg['brand_img_url'] = $path;

                    }else{
                        //上传失败
                        $msg['status'] = 3;
                        $errorMsg = $upload->getError();
                    }
                }

                if($msg['status'] == 3){
                    $arr['successStatus'] = 2;
                    $arr['message'] = $errorMsg;
                    $this->ajaxReturn($arr);
                    exit;
                }

                //1 成功 2 失败
                if($model->add($msg)){
                    $arr['successStatus'] = 1;
                    $arr['message'] = '添加成功！';
                    $this->ajaxReturn($arr);

                }else{
                    $arr['successStatus'] = 2;
                    $arr['message'] = '添加失败，请刷新重试！';
                    $this->ajaxReturn($arr);

                }

            }else{
                $arr['successStatus'] = 2;
                $arr['message'] = '数据接收失败，请刷新重试！';
                $this->ajaxReturn($arr);

            }
        }else{
            $this->display();
        }

    }

    //品牌列表
    public function lst(){
        $where = 1;
        $model = M('brand');
        if(IS_POST){

            if($_POST['brand_name'])
                $where .= " and brand_name='{$_POST['brand_name']}'";
            if($_POST['brand_add_time'])
                $where .= " and to_days(brand_add_time)=to_days('{$_POST['brand_add_time']}')";
            if($_POST['brand_country'])
                $where .= " and brand_country ='{$_POST['brand_country']}'";


        }else{

            if(isset($_GET['cty']) && $_GET['cty']){
                $where .= " AND brand_country='{$_GET['cty']}'";
            }

        }

        $brandData = $model->where($where)->select();
        $this->assign('brandData',$brandData);
        $this->display();


    }

    //修改品牌
    public function save($id){
        $model = D('brand');
        if(IS_POST){

            $arr = array();
            if($msg = $model->create()){

                if(isset($_FILES['brand_img']['tmp_name']) && $_FILES['brand_img']['tmp_name']){

                    $upload = new Upload();
                    $upload->maxsize = 5242880;
                    $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
                    $upload->savePath = 'brand/';
                    $info = $upload->upload();
                    $path = $info['brand_img']['savepath'].$info['brand_img']['savename'];
                    if($info){
                        $image = new Image();
                        $image->open('./Uploads/'.$path);
                        $image->thumb(120,60)->save('./Uploads/'.$path);
                        $msg['brand_img_url'] = $path;
                        @unlink('./Uploads/'.$_POST['old_img']);
                    }else{
                        //上传失败
                        $msg['status'] = 3;
                        $errorMsg = $upload->getError();
                    }
                }

                if($msg['status'] == 3){
                    $arr['successStatus'] = 2;
                    $arr['message'] = $errorMsg;
                    $this->ajaxReturn($arr);
                    exit;
                }

                //1 成功 2 失败
                if($model->save($msg)){
                    $arr['successStatus'] = 1;
                    $arr['message'] = '添加成功！';
                    $this->ajaxReturn($arr);

                }else{
                    $arr['successStatus'] = 2;
                    $arr['message'] = '添加失败，请刷新重试！';
                    $this->ajaxReturn($arr);

                }

            }else{
                $arr['successStatus'] = 2;
                $arr['message'] = '数据接收失败，请刷新重试！';
                $this->ajaxReturn($arr);

            }
        }else{
            $brandData = $model->find($id);
            $this->assign('brandData',$brandData);
            $this->display();
        }

    }



    //删除品牌
    public function delete($id){
        $model = D('brand');

        if($model->delete($id)){
            echo 1;
        }else{
            echo 2;
        }
    }

    // 设置状态
    public function setStatus(){
        $model = M('brand');
        $id = $_POST['id'];
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('brand_status','显示')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('brand_status','不显示')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }

    // 排序
    public function sort(){
        $num = $_POST['num'];
        $id = $_POST['id'];
        $model = M('brand');

        if($model->where('id='.$id)->setField('brand_sort',$num))
            echo 1;
        else
            echo 2;

    }

    // 批量删除
    public function plDel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model= D('brand');
            if(!$model->delete($del)){
                echo 2;exit;
            }
        }
        echo 1;

    }

    // 获取地区的信息，并转换json
    public function getCountryJson(){

        $model = M('brand');
        $data = $model->field('count(*) value,brand_country name')->group('brand_country')->select();
        echo json_encode($data);

    }


}