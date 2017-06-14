<?php

//
//    echo date("Y-m-d",'1495836000');
//
//
//    echo date("Y-m-j");
    $timestamp = strtotime(date("2017-5-29"));  //今天的时间戳

    var_dump($timestamp);
    $start = strtotime("2017-02-26");   //学期开始时间
    var_dump($start);
    $week = ceil(($timestamp - $start)/(60*60*24*7));     //当前周
    echo $week;
    $data = array();
    for($i=1;$i<=7;$i++){
        $data[$i] = date("j",$timestamp - ((date('w')-$i)*60*60*24));
    }

    $arr = array(
        'month' => date('n'),
        'day'   => $data,
        'week'  => $week
    );

    echo json_encode(array('status'=>true,'result'=>$arr));

