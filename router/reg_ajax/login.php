<?php
/**
 * Created by IntelliJ IDEA.
 * User: Vinay
 * Date: 27-12-2018
 * Time: 14:57
 */
if(!isset($_POST['mem_type'],$_POST['login_pass'],$_POST['login_device']) OR $_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
$log_device=filter_var($_POST['login_device'],FILTER_SANITIZE_STRING);
if($log_device==="web" || $log_device==="android" || $log_device==="ios"){}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
if($_POST['mem_type']==="s_pccoe"){
    $mem_type=1;
    if(empty($_POST['s_scholar']) OR $_POST['s_scholar']!==filter_var($_POST['s_scholar'],FILTER_SANITIZE_STRING)){
        mysqli_close($conn);
        echo '{"status":"fields"}';
        exit();
    }
    $s_scholar=filter_var($_POST['s_scholar'],FILTER_SANITIZE_STRING);
}else if($_POST['mem_type']==="s_other"){
    $mem_type=0;
}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$pass=filter_var($_POST['login_pass'],FILTER_SANITIZE_STRING);
if(!empty($pass)){
    if($mem_type===1){
        $nums=$conn->prepare("SELECT user_id,pass,verified FROM register WHERE sch_no=? AND mem_type=? LIMIT 1");
        $nums->bind_param("si",$s_scholar,$mem_type);
    }else{
        $email=filter_var($_POST['login_email'],FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === true){
            mysqli_close($conn);
            echo '{"status":"fields"}';
            exit();
        }
        $nums=$conn->prepare("SELECT user_id,pass,verified FROM register WHERE email=? AND mem_type=? LIMIT 1");
        $nums->bind_param("si",$email,$mem_type);
    }
    if(!$nums->execute()){
        $nums->close();mysqli_close($conn);
        echo '{"status":"error"}';
        exit();
    }
    $nums->store_result();
    if($nums->num_rows()){
        $nums->bind_result($user_id,$login_pass,$verified);$nums->fetch();
        $nums->close();
        if($verified==0){
            mysqli_close($conn);
            echo '{"status":"verify_pending"}';
            exit();
        }
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
        echo '{"status":"notregister"}';
        exit();
    }
}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
}
