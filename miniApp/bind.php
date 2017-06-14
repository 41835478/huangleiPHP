<?php
/**
 * 用户绑定
 */




$openid = $_GET['openid'];
$session_key = $_GET['session_key'];
$zjh = $_GET['zjh'];
$mm  = $_GET['mm'];
if($openid && $session_key && $zjh && $mm){

    $post="zjh=$zjh&mm=$mm";
    if (login($post))
    {

        $conn = mysqli_connect('sqld.duapp.com:4050','9d47069cf067489ca73c3a985dcf9726','e313ef242f184744bd9964b3c27c918b','YlBPLPyFSOVgoyEvPOTY');

        $select = "select * from mini_user where openid = '{$openid}'";
        $result = mysqli_query($conn,$select);
        if($result->num_rows > 0){
            $sql = "update mini_user set zjh='{$zjh}',mm='{$mm}' where openid = '{$openid}'";
        }else{
            $time = date("Y-m-d H:i:s");
            $sql  = "insert into mini_user values(null,'{$openid}','{$session_key}','{$zjh}','{$mm}','{$time}')";
        }

        if(mysqli_query($conn,$sql)){
            echo json_encode(array('status'=>true,'result'=>'绑定成功'));
        }else{
            echo json_encode(array('status'=>false,'result'=>'绑定失败，稍后再试'));
        }
        mysqli_close($conn);exit;
    }
    else
    {
        echo json_encode(array('status'=>false,'result'=>'学号或密码错误'));exit;
    }


}else{
    echo json_encode(array('status'=>false,'result'=>'学号和密码不能为空'));exit;
}


//判断学号和密码是否错误
function login($post){

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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);  //http_build_query转化成a&b参数的形式
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

