<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
$device=filter_var($_POST['login_device'],FILTER_SANITIZE_STRING);
if($device==="web" || $device==="android" || $device==="ios"){}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$nums=$conn->prepare("DELETE FROM log_token WHERE token=? AND device=? LIMIT 1");
$nums->bind_param("ss",$_SERVER['HTTP_TNPBOT'],$device);
if(!$nums->execute()){
    echo '{"status":"error"}';
    $nums->close();
    exit();
}
$nums->close();
echo '{"status":"success"}';