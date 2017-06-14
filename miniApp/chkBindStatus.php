<?php
/**
 * 判断用户是否已经绑定
 */
$openid = $_GET['openid'];

if($openid){
    $conn = mysqli_connect('sqld.duapp.com:4050','9d47069cf067489ca73c3a985dcf9726','e313ef242f184744bd9964b3c27c918b','YlBPLPyFSOVgoyEvPOTY');
    $sql = "select * from mini_user where openid = '{$openid}'";
    $result = mysqli_query($conn,$sql);
    if($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        echo json_encode(array('status'=>true,'result'=>'已绑定','info'=>$row));
    }else{
        echo json_encode(array('status'=>false,'result'=>'未绑定'));
    }
    mysqli_close($conn);
}else{
    echo json_encode(array('status'=>false,'result'=>'未获取到openid，刷新重试'));
}





