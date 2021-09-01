<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST' OR !isset($_POST['uid'],$_POST['email'],$_POST['com_name']) OR strlen($_POST['com_name'])<3){
    header('Status: 400');exit();
}
header('Status: 200');
if($user_id==3 || $user_id==1 || $user_id==4){}else{
    mysqli_close($conn);
    echo '{"status":"privileges"}';
    exit();
}
if(empty($_POST['email']) AND empty($_POST['uid'])){
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
if(empty($_POST['uid'])){
    $u=-1;
    $e=$_POST['email'];
}
if(empty($_POST['email'])){
    $u=(int)$_POST['uid'];
    if($u<1){
        mysqli_close($conn);
        echo '{"status":"n_exist"}';
        exit();
    }
    $e='';
}
$com_name=filter_var($_POST['com_name'],FILTER_SANITIZE_STRING);
if($u==-1){
    $nums=$conn->prepare("SELECT user_id FROM register WHERE email=? LIMIT 1");
    $nums->bind_param("s",$e);
    if(!$nums->execute()){
        echo '{"status":"error"}';
        $nums->close();
        exit();
    }
    $nums->store_result();
    if($nums->num_rows()!=1){
        $nums->close();
        echo '{"status":"n_exist"}';
        exit();
    }
    $nums->bind_result($u);$nums->fetch();$nums->close();
}else{
    $nums=$conn->prepare("SELECT 1 FROM register WHERE user_id=? LIMIT 1");
    $nums->bind_param("i",$u);
    if(!$nums->execute()){
        echo '{"status":"error"}';
        $nums->close();
        exit();
    }
    $nums->store_result();
    if($nums->num_rows()!=1){
        $nums->close();
        echo '{"status":"n_exist"}';
        exit();
    }
    $nums->close();
}
$nums=$conn->prepare("UPDATE user_info SET placed_status=1,place_in=?,placed_on=NOW() WHERE user_id=? LIMIT 1");
$nums->bind_param("si",$com_name,$u);
if(!$nums->execute()){
    echo '{"status":"error"}';
    $nums->close();
    exit();
}
$nums->close();
echo '{"status":"success"}';
