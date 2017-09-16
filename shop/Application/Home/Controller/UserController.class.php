<?php
/**
 * 用户列表
 */
namespace Home\Controller;
use Home\Controller\CommonController;
use Think\Upload;

class UserController extends CommonController
{
    //添加
    public function add(){

        if(IS_POST){
            $model = D('user');
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
            //取出所有角色
            $roleData = M('role')->where('id != 1')->select();
            $this->assign('roleData',$roleData);
            $this->display();
        }

    }

    //列表
    public function lst(){
        /**********************获取所有用户*****************/
        $where = 1;
        if(isset($_GET['search']) && $_GET['search']){
            $where .= " AND a.user_name like '%".$_GET['search']."%'";
        }
        if(isset($_GET['ri']) && $_GET['ri']){
            $where .= " AND a.role_id = {$_GET['ri']}";
        }

        $model = D('user');
        $userData = $model->query("select a.*,b.role_name from sh_user a left join sh_role b on a.role_id = b.id where $where");

        /****************获取所有角色********************/
        $roleModel = D('role');

        $roleData = $roleModel->alias('a')->field('a.*,count(b.id) num')->join("left join sh_user b on a.id=b.role_id")->group('a.id')->select();
        $sum = 0;
        foreach($roleData as $v){
            $sum +=$v['num'];
        }

        $this->assign(array(
            'userData'=>$userData,
            'roleData'=>$roleData,
            'sum'=>$sum,
        ));
        $this->display();
    }

    //修改
    public function save($id){
        $model = D('user');
        
        if(IS_POST){
            if($id == 1)
                die('呵呵哒');
            if($model->create()){
                if($model->save() !== false)
                    echo 1;
                else
                    echo 2;

            }else{
                echo 2;
            }
        }else{
            $userData = $model->find($id);
            $this->assign('data',$userData);
            //取出所有角色
            $roleData = M('role')->where('id != 1')->select();
            $this->assign('roleData',$roleData);
            $this->display();
        }
    }

    //删除
    public function delete($id){
        $model = D('user');
        if($id == 1)
            die('呵呵哒');
        if($model->delete($id))
            echo 1;
        else
            echo 2;
    }

    //批量删除
    public function plDel(){
        $model = D('user');
        $ids = $_POST['dels'];
        if(in_array('1',$ids)){
            die('呵呵哒');
        }


        if($ids){
            $ids = implode(',',$ids);
            if(!$model->delete($ids)){
                echo 2;
                exit;
            }
        }
        echo 1;

    }

    public function setStatus(){
        $model = M('user');
        $id = $_POST['id'];
        if($id == 1)
            die('呵呵哒');
        $status = $_POST['status'];
        if($status){
            if($model->where('id='.$id)->setField('status','开启')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }

        }else{
            if($model->where('id='.$id)->setField('status','禁用')){
                echo 1;
                exit;
            }else{
                echo 2;
                exit;
            }
        }
    }






    //导出excel
    public function exportExcel(){
        header("Content-Typ:text/html;charset=utf-8");
        vendor('Excel.PHPExcel.Writer.IWriter');
        vendor('Excel.PHPExcel.Writer.Excel5');
        vendor('Excel.PHPExcel');
        vendor('Excel.PHPExcel.IOFactory');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "用户名");//设置列的值
        $objPHPExcel->getActiveSheet()->setCellValue('B1', "密码");//设置列的值
        $objPHPExcel->getActiveSheet()->setCellValue('C1', "所属角色");//设置列的值


        $arr=M('user')->alias('a')->join('sh_role b on a.role_id=b.id')->select();
        $count = count($arr); //求出有多少行;
        $i=2;       //注意这是2;因为第一行我们已经设置了表头信息
        for($j=0;$j<$count;$j++)
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$i,$arr[$j]['user_name'])   //注意这里没有分号结束
                ->setCellValue('B'.$i,$arr[$j]['user_pwd'])
                ->setCellValue('C'.$i,$arr[$j]['role_name']);
            $i++;
        }
        $objPHPExcel->getActiveSheet(0)->setTitle('用户信息总览');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition:attachment;filename="用户信息总览.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    //导入Excel文件
    public function importExcel(){
        if(IS_POST){

            $upload = new Upload();
            $upload->exts = array('xls');// 设置附件上传类型
            $info = $upload->upload();
            $path = './Uploads/'.$info['excel']['savepath'].$info['excel']['savename'];

        }

        header("content-type:text/html;charset=utf-8");
        vendor('Excel.PHPExcel');
        vendor('Excel.PHPExcel.IOFactory');
        vendor('Excel.PHPExcel.Reader.Excel5');
        $objReader = new \PHPExcel_Reader_Excel5;//注意和导出的类不一样哦
        $objPHPExcel = $objReader->load($path); //上传的文件，或者是指定的文件
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow(); //取得总行数

        for($j=2;$j<=$highestRow;$j++)
        {
            $username = $objPHPExcel->getActiveSheet()->getCell("A".$j)->getValue();//获取B列的值
            $password = $objPHPExcel->getActiveSheet()->getCell("B".$j)->getValue();//获取C列的值
            if(!M('user')->add(array('user_name'=>$username,'user_pwd'=>$password))){
                $this->error('导入Excel失败，请按规定格式导入！');
            }
        }
        $this->success('导入Excel成功！');
        @unlink($path);

    }


}