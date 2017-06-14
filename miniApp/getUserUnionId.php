<?php
/**
 *  通过微信提供的解密方法，获取用户的unionID
 */

include_once "./wx/wxBizDataCrypt.php";


$appid = $_GET['appid'];    //wx4f4bc4dec97d474b
$sessionKey = $_GET['session_key'];           // tiihtNczf5v6AKRyjwEUhQ==

$encryptedData = $_GET['encryptedData'];

$iv = $_GET['iv'];       //r7BXXKkLb8qrSNn05n0qiA==

$pc = new WXBizDataCrypt($appid, $sessionKey);
$errCode = $pc->decryptData($encryptedData, $iv, $data );

if ($errCode == 0) {
    echo json_encode(array('status'=>true,'unionId'=>$data));
} else {
    echo json_encode(array('status'=>false,'result'=>$errCode));
}

//CiyLU1Aw2KjvrjMdj8YKliAjtP4gsMZM
//                QmRzooG2xrDcvSnxIMXFufNstNGTyaGS
//                9uT5geRa0W4oTOb1WT7fJlAC+oNPdbB+
//3hVbJSRgv+4lGOETKUQz6OYStslQ142d
//                NCuabNPGBzlooOmB231qMM85d2/fV6Ch
//                evvXvQP8Hkue1poOFtnEtpyxVLW1zAo6
//                /1Xx1COxFvrc2d7UL/lmHInNlxuacJXw
//                u0fjpXfz/YqYzBIBzD6WUfTIF9GRHpOn
//                /Hz7saL8xz+W//FRAUid1OksQaQx4CMs
//                8LOddcQhULW4ucetDf96JcR3g0gfRK4P
//                C7E/r7Z6xNrXd2UIeorGj5Ef7b1pJAYB
//                6Y5anaHqZ9J6nKEBvB4DnNLIVWSgARns
///8wR2SiRS7MNACwTyrGvt9ts8p12PKFd
//                lqYTopNHR1Vf7XjfhQlVsAJdNiKdYmYV
//                oKlaRv85IfVunYzO0IKXsyl7JCUjCpoG
//                20f0a04COwfneQAGGwd5oa+T8yO5hzuy
//                Db/XcxxmK01EpqOyuxINew==




