<?php
namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Image;
use Think\Upload;

header("Content-type:text/html;charset=utf8");
date_default_timezone_set('PRC');   //为了避免time()的时间不准，设置时区为中国
class ActiveController extends CommonController
{
    //添加
    public function add(){
        if(IS_POST){
            $model = D('Active');

            $time = time();
            $arr = array(
                'cat'=>$_POST['cat'],
                'summary'=>$_POST['summary'],
                'title'=>$_POST['title'],
                'content'=>$_POST['content'],
                'time'=>$time,
                'top'=>$_POST['top'],
                'topTime'=>$time,
                'mark'=>$_POST['mark']
            );
            $images = '';
            if(isset($_FILES['active']) && $_FILES['active']['tmp_name']) {
                /************   添加图片到一个指定位置**********************/
                $upload = new \Think\Upload();   // 实例化
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
                $upload->rootPath = './Uploads/'; // 设置附件上传目录
                $upload->savePath = 'Active/'; // 设置附件上传目录
                $info = $upload->upload();
                $images = $info['active']['savepath'] . $info['active']['savename'];
                $image = new \Think\Image();    //实例化
                $image->open('./Uploads/'.$images);
                $image->thumb(200, 150)->save('./Uploads/'.$images);
            }
            $arr['images'] = $images;
            if($model->data($arr)->add()){
                $this->success('添加成功',U(MODULE_NAME.'/Active/lst'));
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
        $model = M('Active');


        if(IS_POST){
            $uid = $_POST['id'];
            $arr = array(
                'cat'=>$_POST['cat'],
                'summary'=>$_POST['summary'],
                'title'=>$_POST['title'],
                'content'=>$_POST['content'],
                'top'=>$_POST['top'],
                'mark'=>$_POST['mark'],
                'topTime'=>time(),
            );

            if(isset($_FILES['active']) && $_FILES['active']['tmp_name']) {
                $oldlogo = $_POST['oldlogo'];
                if($oldlogo){
                    @unlink('./Uploads/'.$oldlogo);
                }

                $upload = new \Think\Upload();   // 实例化
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                //./Uploads/代表  和入口文件（index.html）同级的一个文件夹
                $upload->rootPath = './Uploads/'; // 设置附件上传目录
                $upload->savePath = 'Active/'; // 设置附件上传目录
                $info = $upload->upload();
                $images = $info['active']['savepath'] . $info['active']['savename'];
                $image = new \Think\Image();    //实例化
                $image->open('./Uploads/'.$images);
                $image->thumb(220, 160)->save('./Uploads/'.$images);
                $arr['images'] = $images;
            }

            if($model->where('id='.$uid)->save($arr) !== false){
                $this->success('修改成功',U(MODULE_NAME.'/Active/lst'));
                exit;
            }else{
                $this->error('修改失败,请重试！');
            }
        }else{
            $this->data = M('Active')->find($id);
            $this->display();
        }
    }
    //列表
    public function lst(){
        $this->data = M('Active')->order('time desc')->select();
        $this->display();
    }
    //删除
    public function del(){
        $id = $_GET['id'];
        D('Active')->delete($id);
        $this->success('删除成功');

    }
    //批量删除
    public function bdel(){
        $dels = $_POST['dels'];
        if($dels){
            $del = implode(',',$dels);
            $model = D('Active');
            $model->delete($del);
        }
        $this->success('删除成功！');
    }

    public function upload(){
        $config = array(
            'rootPath'      =>  './Uploads/', //保存根路径
            'savePath'      =>  'Active/',  //保存路径

        );
        //调用tp框架中的 上传文件方法
        $upload = new Upload($config);
        if( $info = $upload->upload()){
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