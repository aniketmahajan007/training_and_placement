<?php
/**
 * Created by IntelliJ IDEA.
 * User: Aniket
 * Date: 29-07-2020
 * Time: 13:45
 */
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST,OPTIONS");
header("Access-Control-Allow-Headers: Authority,Tnpbot");
if($_SERVER['REQUEST_METHOD']==="OPTIONS"){
    header('Status: 200');exit();
}
if(!isset($_SERVER['HTTP_AUTHORITY'],$_SERVER['HTTP_TNPBOT'])){
    header('Status: 403');
    exit();
}
$secure=9;
if($_SERVER['HTTP_TNPBOT']==="null"){
    $key=$_SERVER['HTTP_AUTHORITY'];
    if(password_verify(';Adjmdb44rqp2rzE3R5uDEx2MJXKRsW',$key)){
        $secure=1;// login pass verify
    }else{
        header('Status: 400');exit();
    }
}else{
    require (dirname(__FILE__).'/conn.php');
    $nums=$conn->prepare("SELECT user_id FROM log_token WHERE token=? AND device=? LIMIT 1");
    $nums->bind_param("ss",$_SERVER['HTTP_TNPBOT'],$_POST['login_device']);
    if(!$nums->execute()){
        echo '{"status":"error"}';
        $nums->close();
        exit();
    }
    $nums->store_result();
    if($nums->num_rows()==0){
        $nums->close();
        echo '{"status":"tokenmiss"}';exit();
    }else{
        $nums->bind_result($user_id);$nums->fetch();
    }
    $nums->close();
    $secure=0;
}
if(!isset($conn)){
    require(dirname(__FILE__) . '/conn.php');}