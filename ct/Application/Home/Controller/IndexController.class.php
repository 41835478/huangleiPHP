<?php
namespace Home\Controller;
use Think\Controller;
header('Content-type:text/html;charset=utf8');
class IndexController extends Controller {
    public function index(){
        //精品案例
        $this->cas = M('case')->limit(4)->order("time DESC")->select();
        $this->img = M('images')->select();

        //资讯中心
        $this->act = M('active')->limit(7)->order("top desc,topTime desc")->select();

        //工程案例
        $this->project = M('project')->limit(6)->where("status='否'")->order("time DESC")->select();
        $this->projectImg = M('pro_images')->select();
        $this->one = M('project')->where("status='是'")->limit(1)->order("time DESC")->select();
        $this->display();
    }
    //关于我们
    public function about(){
        $this->com = M('company')->limit(1)->select();
        $this->emp = M('employ')->limit(1)->select();
        $this->display();
    }
    //案例展示
    public function cas(){
        $this->cat = M('category')->select();
        $where = 1;
        if(isset($_GET['un']) && $_GET['un']){
            $where = 'cat_id='.$_GET['un'];
            $id =$_GET['un'];
            $this->catName = M('category')->find($id);
        }
        $this->case = M('case')->where($where)->order("time DESC")->select();

        $this->img = M('images')->select();
        $this->display();
    }
    public function caseShow(){
        $id = $_GET['id'];
        $cas = M('case')->find($id);
        $img = M('images')->where('case_id='.$id)->select();

        $this->ajaxReturn($img);
    }
    //资讯中心
    public function newslst(){
        $this->actData = M('active')->where(array('cat'=>'最新活动'))->order("time DESC")->select();
        $this->newData = M('active')->where(array('cat'=>'新闻中心'))->order("time DESC")->select();
        $this->zhuData = M('active')->where(array('cat'=>'装修知识'))->order("time DESC")->select();
        $this->display();
    }
    //工程案例
    public function Project(){
        $this->data = M('project')->order("time DESC")->select();
        $this->img = M('pro_images')->select();
        $this->display();
    }
    //施工现场
    public function build(){
        $this->data = M('build')->order("time DESC")->select();
        $this->img = M('build_images')->select();
        $this->display();
    }
    //工程案例 详细内容
    public function img(){
        $id = $_GET['id'];
        $this->data = M('project')->find($id);
        $this->imgs = M('pro_images')->where('pro_id='.$id)->select();
        $this->display();
    }
    //施工现场 详细内容
    public function buildImg(){
        $id = $_GET['id'];
        $this->data = M('build')->find($id);
        $this->imgs = M('build_images')->where('build_id='.$id)->select();
        $this->display();
    }
    //资讯中心详细，ajax实现
    public function ajaxShow(){
        //此处必须用GET接收，post会导致值不会改变
        $id =$_GET['id'];
        $data = M('active')->find($id);
        $this->ajaxReturn($data);
    }

    public function news(){
        $id = $_GET['id'];
        $this->msg = M('active')->find($id);
        $this->display();
    }
    public function comCas(){
        $id = $_GET['id'];
        $this->data = M('case')->find($id);
        $this->img = M('images')->where('case_id='.$id)->select();
        $this->cat = M('category')->select();
        $this->display();
    }

    //发送邮件

    public function mail(){
        if(IS_POST){

            if(empty($_POST['phoneNum']) || empty($_POST['name']) || empty($_POST['mianji']) || empty($_POST['loupan']) ){
                echo "<script>
                        alert('请正确填写信息，谢谢！');
                        window.history.back(-1);
                      </script>";
            }else{
                $phoneNum = $_POST['phoneNum'];
                $name = $_POST['name'];
                $area = $_POST['mianji'];
                $building = $_POST['loupan'];
                $str = "姓名:$name".'<br />'."电话:$phoneNum".'<br />'."楼盘:$building".'<br />'."面积:$area".'<br />';

                if(sendMail('1251966602@qq.com','有人预约量房啦！',$str)){
                    echo "<script>
                        alert('提交成功，我们将即可与您联系！');
                        window.history.back(-1);
                      </script>";
                }else{
                    echo "<script>
                        alert('提交失败，敬请谅解！');
                        window.history.back(-1);
                      </script>";
                }

            }
        }else{
            echo "<script>
            alert('提交失败，请重试！');
            ";
        }
    }

}