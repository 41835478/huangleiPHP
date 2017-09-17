<?php
namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Image;
use Think\Upload;
header('Content-type:text/html;charset=utf8');
date_default_timezone_set('PRC');   //为了避免time()的时间不准，设置时区为中国
class CompanyController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('company');
            $arr = array(
                'content'=>$_POST['content'],
                'time'=>time(),
            );
            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/company/lst'));
            }else{
                $this->error('添加失败,请重试！');
            }
        }else{
            $this->display();
        }
    }
    //修改
    public function save(){
        $id = $_GET['id'];
        $model = M('company');
        if(IS_POST){
            if($model->create()){
                if($model->save() !== false){
                    $this->success('修改成功',U(MODULE_NAME.'/company/lst'));
                    exit;
                }else{
                    $this->error('修改失败,请重试！');
                }
            }else{
                //获取错误信息
                $this->error($model->getError());
            }
        }else{
            $this->data = M('company')->find($id);
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('company')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('company')->delete($id);
        $this->success('删除成功');

    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('company');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

    public function upload(){
        $config = array(
            'rootPath'      =>  './Uploads/', //保存根路径
            'savePath'      =>  'Company/',  //保存路径

        );
        //调用tp框架中的 上传文件方法
        $upload = new Upload($config);
        if($info = $upload->upload()){  
            //为Ueditor返回一个json数组
            echo json_encode(array(
                'url' => $info['upfile']['savepath'].$info['upfile']['savename'],
                'title' => htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
                'original' =>$info['upfile']['name'],
                'state' => 'SUCCESS',
            ));
        }else{
            echo json_encode(array(
                'state' =>$upload->getError(),
            ));
        }
    }

}