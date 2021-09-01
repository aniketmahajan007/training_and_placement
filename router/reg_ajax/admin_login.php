<?php
if(!isset($_POST['login_email'],$_POST['login_pass'],$_POST['login_device']) OR $_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
$log_device=filter_var($_POST['login_device'],FILTER_SANITIZE_STRING);
if($log_device==="web" || $log_device==="android" || $log_device==="ios"){}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$e=filter_var($_POST['login_email'],FILTER_SANITIZE_EMAIL);
if (!filter_var($e, FILTER_VALIDATE_EMAIL) === true){
    mysqli_close($conn);
    echo '{"status":"email"}';
    exit();
}
$pass=filter_var($_POST['login_pass'],FILTER_SANITIZE_STRING);
if(!empty($pass)){
    $nums=$conn->prepare("SELECT user_id,pass FROM register WHERE email=? AND (user_id=1 OR user_id=3 OR user_id=4) LIMIT 1");
    $nums->bind_param("s",$e);
    if(!$nums->execute()){
        $nums->close();mysqli_close($conn);
        echo '{"status":"error"}';
        exit();
    }
    $nums->store_result();
    if($nums->num_rows()){
        $nums->bind_result($user_id,$login_pass);$nums->fetch();
        $nums->close();
        if(!password_verify($pass,$login_pass)){
            mysqli_close($conn);
            echo '{"status":"passfail"}';
            exit();
        }
        $timestamp = date('Y-m-d G:i:s');
        $timestamp= date("Y-m-d G:i:s", strtotime("-480 minutes", strtotime($timestamp)));
        $token=bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
        $sha=sha1($token);
        $nums=$conn->prepare("DELETE FROM log_token WHERE device=? AND user_id=? LIMIT 1");
        $nums->bind_param("si",$log_device,$user_id);
        $nums->execute();$nums->close();
        $nums=$conn->prepare("INSERT INTO log_token (user_id,token,device) VALUES (?,?,?)");
        $nums->bind_param("iss",$user_id,$sha,$log_device);
        if(!$nums->execute()){
            $nums->close();mysqli_close($conn);
            echo '{"status":"error"}';
            exit();
        }
        $nums->close();
        mysqli_close($conn);
        echo '{"status":"success","token":"'.$sha.'"}';
        exit();
    }else{
        $nums->close();
        mysqli_close($conn);
        echo '{"status":"privilege"}';
        exit();
    }
}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
}

