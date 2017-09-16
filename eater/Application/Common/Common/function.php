<?php
//stdClass Object 转 数组
function objectArray($array){
    if(is_object($array)){
        $array = (array)$array;
    }
    if(is_array($array)){
        foreach($array as $key=>$value){
            $array[$key] = objectArray($value);
        }
    }
    return $array;
}

//获取随机数 用于验证码
function getRandNum($length = 4){
    $numStr = '0123456789';
    $numStr = str_repeat($numStr, $length);
    $numStr = str_shuffle($numStr);
    $str = substr($numStr,0,$length);
    return $str;
}


function get_ip($type = 0) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($_SERVER['HTTP_X_REAL_IP']){                     //nginx 代理模式下，获取客户端真实IP
        $ip=$_SERVER['HTTP_X_REAL_IP'];
    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {       //客户端的ip
        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { //浏览当前页面的用户计算机的网关
        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos    =   array_search('unknown',$arr);
        if(false !== $pos) unset($arr[$pos]);
        $ip     =   trim($arr[0]);
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];            //浏览当前页面的用户计算机的ip地址
    }else{
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    dump($ip);die;
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

// 赠送积分换算
function give_points($price){
    return round($price/10);
}

//积分抵换金额 换算
function place_points($points){
    return round($points/200,2);
}
//
//// 计算会员等级
//function member_level($money,$is_next_level = false){
//
//    $distance_next_level = 0;
//    switch($money){
//        case $money >= 0 && $money <= 3000 :
//            $level = '青铜会员';
//            $distance_next_level = round(3001 - $money,2);
//            $next_level = "白银会员";
//            break;
//        case $money >=3001 && $money <= 10000 :
//            $level = '白银会员';
//            $distance_next_level = round(10001 - $money,2);
//            $next_level = "黄金会员";
//            break;
//        case $money >= 10001 && $money <= 20000 :
//            $level = '黄金会员';
//            $distance_next_level = round(20001 - $money,2);
//            $next_level = "铂金会员";
//            break;
//        case $money >= 20001 && $money <= 50000:
//            $level = '铂金会员';
//            $distance_next_level = round(50001 - $money,2);
//            $next_level = "钻石会员";
//            break;
//        case $money >= 50001 :
//            $level = '钻石会员';
//            $distance_next_level = 0;
//            break;
//        default :
//            $level = "青铜会员";
//    }
//
//    if($is_next_level){
//        $arr = array(
//            'level' => $level,
//            'distance_next_level' => $distance_next_level,
//            'next_level' => $next_level
//        );
//        return $arr;
//    }
//    return $level;
//
//}

// 发送邮件
function sendMail($to, $title, $content) {
    Vendor('PHPMailer.PHPMailerAutoload');
    $mail = new PHPMailer(); //实例化
    $mail->IsSMTP(); // 启用SMTP
    $mail->Host=C('MAIL_HOST'); //smtp服务器的名称（这里以QQ邮箱为例）
    $mail->SMTPAuth = C('MAIL_SMTPAUTH'); //启用smtp认证
    $mail->Username = C('MAIL_USERNAME'); //发件人邮箱名
    $mail->Password = C('MAIL_PASSWORD') ; //163邮箱发件人授权密码
    $mail->From = C('MAIL_FROM'); //发件人地址（也就是你的邮箱地址）
    $mail->FromName = C('MAIL_FROMNAME'); //发件人姓名
    $mail->AddAddress($to,"尊敬的卖家");
    $mail->WordWrap = 50; //设置每行字符长度
    $mail->IsHTML(C('MAIL_ISHTML')); // 是否HTML格式邮件
    $mail->CharSet=C('MAIL_CHARSET'); //设置邮件编码
    $mail->Subject =$title; //邮件主题
    $mail->Body = $content; //邮件内容
    $mail->AltBody = "这是一个纯文本的身体在非营利的HTML电子邮件客户端"; //邮件正文不支持HTML的备用显示
    return($mail->Send());
}

/* 拆分关键词 */
function splitKeyword($str){
    \Vendor\PhpAnalysis\PhpAnalysis::$loadInit = false;
    $pa = new \Vendor\PhpAnalysis\PhpAnalysis('utf-8', 'utf-8', true);
    $pa->LoadDict();
    $pa->SetSource($str);
    $pa->StartAnalysis(true);
    $pa->differMax = true;
    $result = $pa->GetFinallyResult();    // 拆分结果
    return trim($result);
}

/* 计算价格区间 */
//function count_price_section($min_price,$max_price,$section = 5){
//
//    $cha = ceil(($max_price - $min_price) / $section);  //公差
//
//    $price_section = array();   // 价格区间数组
//
//    $first_price   = $min_price;         // 区间开始值为最小价格
//    for($i=1; $i<=$section; $i++){
//
//        // 最后一个区间
//        if($i == $section)
//            $price_section[] = $first_price.'-'.$max_price;
//        else
//            $price_section[] = $first_price.'-'.(number_format($cha + $first_price,2,'.',''));
//
//        $first_price = number_format($cha+$first_price,2,'.','');
//    }
//
//    return $price_section;
//
//
//}

/* 获取url中的参数，当指定第三个参数时，则向GET中添加一组值，没指定第三个参数，则从GET中移除$key参数*/
/* 如果不将$_GET赋值给$get的话，a标签中，会先给$_GET添加一组值，然后再判断选中状态，if($_GET['cat_id'] == $v['id']){}，这样的话，每个a标签都会变成选中状态*/
function getParameter($key,$value,$add=true){
    $get = $_GET;
    if($add){
        $get[$key] = $value;
    }else{
        unset($get[$key]);
    }
    return $get;
}
