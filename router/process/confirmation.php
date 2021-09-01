<?php
/**
 * Created by IntelliJ IDEA.
 * User: Aniket
 * Date: 17-08-2018
 * Time: 22:38
 */

if(!isset($_GET['email'],$_GET['passkey'])){
    header("Location:http://pccoetnp.epizy.com/");
    exit();
}
if($action === 'confirm' OR $action==='update'){}else{
    header("Location:http://pccoetnp.epizy.com/");
    exit();
}
$e=filter_var($_GET['email'],FILTER_SANITIZE_EMAIL);
if (!filter_var($e, FILTER_VALIDATE_EMAIL) === true){
    echo '<span style="font-size:1.25em;color:red;font-weight: 600"><br><br>Error Occurred : Not A Valid E-mail <br>Redirecting To Login Page</span>';
    header("refresh:4;url=http://pccoetnp.epizy.com/");exit();
}
$passkey=htmlspecialchars(filter_var($_GET['passkey'],FILTER_SANITIZE_STRING));
require (dirname(__FILE__).'/../core/conn.php');;
if($action==='update'){

}
if($action==="confirm"){
    $nums=$conn->prepare("SELECT user_id,email FROM temp WHERE verify_code=? AND email=? LIMIT 1");
    $nums->bind_param("ss",$passkey,$e);
    if(!$nums->execute()){
        $nums->close();mysqli_close($conn);
        header("Location:http://pccoetnp.epizy.com/confirmation.html?action=uverify");exit();
    }
    $nums->store_result();
    if(!$nums->num_rows()){
        $nums->close();mysqli_close($conn);
        header("Location:http://pccoetnp.epizy.com/confirmation.html?action=afailed");exit();
    }
    $nums->bind_result($user_id,$email);
    $nums->fetch();$nums->close();
    mysqli_autocommit($conn,FALSE);$qsuccess=1;
    $nums=$conn->prepare("INSERT INTO user_info (user_id) VALUES (?)");
    $nums->bind_param("i",$user_id);
    if(!$nums->execute()){
        $qsuccess=0;
    }
    $nums->close();
    if($qsuccess) {
        $nums=$conn->prepare("UPDATE register SET verified=1 WHERE user_id=? LIMIT 1");
        $nums->bind_param("i",$user_id);
        if(!$nums->execute()){
            $qsuccess=0;
        }
        $nums->close();
    }
    if($qsuccess){
        $nums=$conn->prepare("DELETE FROM temp WHERE verify_code=? AND email=? LIMIT 1");
        $nums->bind_param("ss",$passkey,$e);
        if(!$nums->execute()){
            $qsuccess=0;
        }
        $nums->close();
    }
    if($qsuccess){
        mysqli_commit($conn);mysqli_close($conn);
        header("Location:http://pccoetnp.epizy.com/confirmation.html?action=active");
    }else{
        mysqli_rollback($conn);mysqli_close($conn);
        header("Location:http://pccoetnp.epizy.com/confirmation.html?action=uverify");exit();
    }
}
echo '<span style="font-size:1.25em;color:red;font-weight: 600"><br><br>Error Occurred : Unknown Error Occurred</span>';
header("refresh:4;url=http://pccoetnp.epizy.com/");exit();