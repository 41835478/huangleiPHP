<?php
header('Content-type:text/html;charset=utf8');
error_reporting(E_ALL^E_NOTICE^E_WARNING);

$zjh = $_GET['zjh'];
$mm  = $_GET['mm'];
$className = $_GET['className'];
//$className="计算机14-3";
$conn   = mysqli_connect('sqld.duapp.com:4050','9d47069cf067489ca73c3a985dcf9726','e313ef242f184744bd9964b3c27c918b','YlBPLPyFSOVgoyEvPOTY');
//$conn = mysqli_connect("localhost",'root','','hkhand');
if(!$className || $className == 'undefined'){

    if($zjh == "" || $mm == ""){
        echo json_encode(array('status'=>false,'result'=>'未获取到学号信息'));exit;
    }
    /* 获取班级信息 */
    $sql    = "select class from heikeji where zjh = '{$zjh}'";
    $result = mysqli_query($conn,$sql);
    $row    = mysqli_fetch_assoc($result);
    $className = $row['class'];
    if(!$row){
        $cookie = login($zjh,$mm);
        if(!$cookie){
            echo json_encode(array('status'=>false,'result'=>'学号或密码错误'));exit;
        }
        $html = httpGet('http://60.219.165.24/xjInfoAction.do?oper=xjxx','',false,$cookie);

        //在学籍信息页面，取到班级信息，由此判定这个人的班级
        preg_match_all('/<td align="left" width="275">([^<]*)<\/td>/',$html,$bj);
        $className = mb_convert_encoding(trim($bj[1][27]),"UTF-8","GB2312");
    }

}



if(preg_match('/^.*(\d{2})-(\d{1,2})$/',$className)){       //匹配 计算机14-3 或 采矿13-1 字样

    $ex     = explode('-',$className);
    $grade  = $ex[0];
    $class  = $ex[1];
    $sql    = "select * from course where match(class) against('{$grade}'in boolean mode)";
    $status = '1';

}else if(preg_match('/.*\d{2}[^-].*/',$className)){             //匹配 特殊班级， 比如 采矿14级卓越班
    $conn   = mysqli_connect('localhost','root','','hkhand');
    $sql    = "select * from course where class = '$className'";
    $status = '2';

}else {
    echo json_encode(array('status'=>false,'result'=>'未获取到课程信息'));exit;
}

$result = mysqli_query($conn,$sql);
$data   = array();
$color  = array('#fdc081','#54e9bd','#a3e866','#5fe58a','#fbaece','#d5aef6','#ffe062','#bce728','#f766ab','#7ec0fc');
$courseColor = array();

while($row = mysqli_fetch_assoc($result)){

    $info = explode('-',$row['class']);
    $info[2] = isset($info[2]) ? $info[2] : $info[1];
    /**
     * $info[0] : 计算机14
     * $info[1] : 1
     * $info[2] : 3
     */
    if($info[1] <= $class && $info[2] >= $class || $status == '2')
    {

        $explode = explode(',',$row['classWeek']);
        /**
         * $week[1] : 起始周
         * $week[2] : 结束周
         * $week[3] : 起始周=结束周   例 16周
         */
        foreach($explode as $k => $v){
            preg_match('/(\d{1,2})-(\d{1,2})|(\d{1,2})/',$v,$week);
            if($week[1] && $week[2]){
                $row['start_week'][] = $week[1];
                $row['end_week'][]   = $week[2];
            }else{
                $row['start_week'][] = $week[3];
                $row['end_week'][]   = $week[3];
            }
        }

        /** 判断单双周 */
        if(strpos($row['classWeek'],'单') !== false){
            $row['week_type'] = '单周';
        }elseif(strpos($row['classWeek'],'双') !== false){
            $row['week_type'] = '双周';
        }else{
            $row['week_type'] = '正常';
        }
        $row['course'] = $row['place'].'@'.$row['cou_name'];

        /* 相同的课用相同的颜色*/
        if($courseColor[$row['cou_name']]){
            $row['bgcolor'] = $courseColor[$row['cou_name']];
        }else{
            $diff = array_diff($color,$courseColor);
            sort($diff);
            $diffColor = $diff[rand(0,count($diff)-1)];
            $courseColor[$row['cou_name']] = $diffColor;
            $row['bgcolor'] = $diffColor;
        }

        $data[$row['week']][$row['section']][] = $row;
    }
    ksort($data[$row['week']]);

}

ksort($data);
//echo "<pre>";
//print_r($data);
//echo "</pre>";
echo json_encode(array('status'=>true,'result'=>$data,'class'=>$className));
mysqli_close($conn);



function login($zjh,$mm)
{
    $post = array(
        "zjh" => $zjh,
        "mm"  => $mm,
    );
    $res = httpGet('http://60.219.165.24/loginAction.do',$post,true);
    $result = iconv("GBK", "UTF-8", $res);
    list($header, $body) = explode("\r\n\r\n", $result, 2);
    preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
    $cookie = substr($matches[1][0], 1);
    if(preg_match_all("/s_top.jsp|mainFrame.jsp/", $result, $matches)){
        return $cookie;
    }else{
        return false;
    }
}

function httpGet($url, $post = null, $returnHeader = false, $cookie = '', $referer = ''){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, $returnHeader);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    if($post){
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    }

    if ($cookie) {
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }

    if ($referer) {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
    }

    $result = curl_exec($ch);

    curl_close($ch);
    return $result;
}