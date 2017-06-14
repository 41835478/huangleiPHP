<?php
/**
 *  @card_id : 卡号 
 *  @card_pwd : 卡密码
 *  根据卡号和卡密码 获取余额等信息 
 */


$card_id  = $_GET['card_id'];  // 获取卡号
$card_pwd = $_GET['card_pwd']; // 获取卡密码
//$card_id = "4510002410542";
//$card_pwd = "8xjxibsm";



if($card_id && $card_pwd){
	
	$verify = getCodeKey();                            // 获取目标网站的验证码和key
	$code   = getCodeByImage($verify['code_img']);     // 通过验证码图片地址，自动识别验证码中的数字
	$key    = $verify['key'];                          // 表单验证所需的key
		

    /**************判断卡号和口令是否正确，正确返回cookie和数据，错误返回false*************/
    $login  = "card_id={$card_id}&password={$card_pwd}&code={$code}&key={$key}";
    $result = login($login);
    $cookie = $result['cookie'];
    if(!$cookie){
        echo json_encode(array('status'=>false,'result'=>'您输入的网卡信息有误，请核查'));exit;
    }
    /* 截取需要的一部分，下面用正则匹配的速度会快很多 */
    preg_match("/doc \+=\"<tr bgcolor='#e5e5e5'>(.*?)\"/",$result['result'],$html);
    $str = $html[1];

    /**************获取select的值，进入页面，抓取剩余金额*************/
    $pattern = "/<input type='radio' CHECKED name='select' value=(.*?)>/i";
    preg_match($pattern, $str, $matches);
    $select = "select=" . urlencode($matches[1]);   // select值，确认时候使用

    /* 账号余额 */
    $table = httpGet('http://202.97.210.38:9002/cardb_acct_bal.ktcl',$select,false,$cookie);
    preg_match_all("/\d{1,3}\.\d{1,2}/",$table,$ye);
    $money = $ye[0][0];

    /* 启用时间 */
    preg_match_all("/(\d{4})年(\d{1,2})月(\d{1,2})日|未知/",$str,$time);
    $start_time = $time[1][0].'-'.$time[2][0].'-'.$time[3][0];


    /* 判断卡的种类，0026为100元卡，0024为50元卡 */
    $type_code = substr($card_id,4,4);
    if($type_code == "0026"){

        $remaining_time = $money * 3;
        $card_type      = '100元300小时卡';

    }else if($type_code == "0024"){

        $remaining_time = $money * 2;
        $card_type      = '50元100小时卡';

    }else{
        $remaining_time = '未知';
        $card_type      = '未知';
    }

    $arr = array(
        'status'       => true,         // 查询状态
        'card_id'      => $card_id,     // 卡号
        'balance'      => $money,       // 剩余金额
        'enable_time'  => $time[0][0],  // 启用时间
        'expire_days'  =>(31-((strtotime(date("Y-m-d"))-strtotime($start_time)) / (60*60*24))).'天',    // 剩余天数
        'card_type'    => $card_type,   // 卡种类
        'remaining_time' => $remaining_time // 剩余小时

    );

    echo json_encode($arr);exit;

}else{
    echo json_encode(array('status'=>false,'result'=>'卡号和密码不能为空'));exit;
}


function getCodeByImage($image_url){
    require_once './OCR/OCR.php';
    $ocr = new OCR($image_url);
    $captcha = $ocr->getCaptcha();
    return $captcha;
}



// 判断卡号和口令是否正确，正确返回cookie和数据，否则返回false
function login($post){

    $res = httpGet('http://202.97.210.38:9002/usr_cardb_proc.ktcl',$post,true);
    $result = iconv("GBK", "UTF-8", $res);
    list($header, $body) = explode("\r\n\r\n", $result, 2);
    preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
    $cookie = substr($matches[1][0], 1);
    if(!preg_match_all("/<img src='\.\/selfimages\/delay-00.gif'>/", $result, $matches)){
        return array('cookie'=>$cookie,'result'=>$result);
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

/* 获取验证码图片以及key */
function getCodeKey(){
    // 请求网卡查询地址
    $data = httpGet("http://202.97.210.38:9002/usr_cardb_main.ktcl");

    /* 获取验证码图片*/
    $pattern = '/<img src=.\/fjimages(.*?) >/i';
    preg_match($pattern, $data, $matches);
    $code_img = $matches[1];         // 验证码图片地址

    /* 获取key*/
    $pattern = '/<input type=hidden name=\'key\' value=\'(.*?)\'>/i';
    preg_match($pattern, $data, $matches);
    $key = $matches[1];         // 获取网卡查询所需的key

    // 获取验证所需的信息
    $arr = array(
        'code_img'  => 'http://202.97.210.38:9002/fjimages'.$code_img,
        'key'       => $key,
    );
    return $arr;
}

//doc +="<tr bgcolor='#e5e5e5'><td align=center><input type='radio' CHECKED name='select' value=16712010></td><td align=center nowrap>4510002668715</td><td align=center nowrap>16712010</td><td align=center nowrap>哈尔滨节点</td><td align=center nowrap>人民币</td><td align=center nowrap>2017年5月9日</td><td align=center nowrap>31天</td><td align=center nowrap>正常</td>"



