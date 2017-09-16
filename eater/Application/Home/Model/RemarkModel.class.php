<?php
namespace Home\Model;
use Think\Model;
use Think\Page;
use Think\Upload;

class RemarkModel extends Model
{

    // 验证表单中的字段
    function valid(){
        if(!$this->chk_remark()){
            return array('status'=>false,'result'=>'评论内容，不能为空！');
        }
        if(!$this->chk_remark_points('desc')){
            return array('status'=>false,'result'=>'麻烦给“描述相符”打分，谢谢~');
        }
        if(!$this->chk_remark_points('logistics')){
            return array('status'=>false,'result'=>'麻烦给“物流服务”打分，谢谢~');
        }
        if(!$this->chk_remark_points('service')){
            return array('status'=>false,'result'=>'麻烦给“服务态度”打分，谢谢~');
        }
        return array('status'=>true,'result'=>'表单成立');

    }

    // 验证评论内容是否为空
    function chk_remark(){
        foreach($_POST['remark_content'] as $k => $v){
            if(empty(trim($v))){
                return false;
            }
        }
        return true;
    }

    // 根据评分类型，判断是否打分
    function chk_remark_points($type){
        foreach($_POST[$type] as $k => $v){
            if(empty(trim($v))){
                return false;
            }
        }
        return true;
    }

    // 获取所有晒图的图片地址，并返回
    public function get_remark_image_url($remark_id){

        $upload = new Upload();
        $upload->savePath = 'remark/';
        
        $remark_image = array();
        foreach($_FILES as $k => $v){

            $arr = explode('&',$k);
            // 上传
            $info = $upload->upload(array('share_img'=>$_FILES[$k]));

            // 循环所有上传后的信息，整合成二维数组，保存，用于addAll
            foreach($info as $k1 => $v1){
                $data = array();
                $data['remark_id'] = $remark_id[$arr[1]];
                $data['image_url'] = $v1['savepath'].$v1['savename'];
                $remark_image[] = $data;
            }
        }
        return $remark_image;
    }

    // 获取评论
    public function get_remark($goods_id){

        $count = $this->where("goods_id = '{$goods_id}'")->count();

        $page = new Page($count,10);
        $data = $this->query("
                    select a.time,c.nickname,a.goods_attr,a.desc_points,a.logistics_points,a.service_points,a.remark_content,GROUP_CONCAT(b.image_url) image from sh_remark a 
                      left join sh_remark_image b on a.id = b.remark_id 
                        left join sh_member c on a.user_id = c.id 
                        where a.goods_id = {$goods_id}
                         group by a.id
                          order by a.time desc
                            limit $page->firstRow,$page->listRows");

        $show = preg_replace('/href="(.*?)"/','',$page->show());
        return array('page'=>$show,'data'=>$data);
    }

    // 计算 好中差评
    public function count_percent($goods_id){

        $remark = $this->where("goods_id = '{$goods_id}'")->select();

        $hao_people   = 0;
        $zhong_people = 0;
        $cha_people   = 0;

        $people = 0;
        foreach($remark as $k => $v){
            $points = $v['desc_points'] + $v['logistics_points'] + $v['service_points'];
            switch($points){
                case $points >=12 && $points <= 15 :
                    $hao_people++;break;
                case $points >= 7 && $points < 12 :
                    $zhong_people++;break;
                case $points >=1 && $points < 7 :
                    $cha_people++;break;
                default :
                    break;
            }
            $people++;
        }
        $hao   = round($hao_people / $people * 100,1);
        $zhong = round($zhong_people / $people * 100,1);
        $cha   = round($cha_people / $people * 100,1);
        return array('hao'=>$hao.'%','zhong'=>$zhong.'%','cha'=>$cha.'%');

    }

    /* 获取店铺评分 */
    public function getStoreScore($store_id){

        $score = $this->query("select *,sum(desc_points) desc_points,sum(logistics_points) logistics_points,sum(service_points) service_points,count(*) number from sh_remark 
                                where store_id = '{$store_id}' 
                                  group by store_id;");
        $desc_points      = $score[0]['desc_points'];
        $logistics_points = $score[0]['logistics_points'];
        $service_points   = $score[0]['service_points'];
        $number           = $score[0]['number'];
        $arr = array(
            'desc'      => round($desc_points / $number,2),
            'logistics' => round($logistics_points / $number,2),
            'service'   => round($service_points / $number,2),
        );
        return $arr;

    }


}