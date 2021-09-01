<?php
if(!isset($_POST['mem_type'],$_POST['dob_date'],$_POST['reg_email'],$_POST['reg_pass'],$_POST['reg_cpass'],$_POST['gender'],$_POST['mobilenumber']) OR $_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
if($_POST['mem_type']==="s_pccoe"){
    $mem_type=1;
    if(!isset($_POST['s_scholar']) OR empty($_POST['s_scholar']) OR $_POST['s_scholar']!==filter_var($_POST['s_scholar'],FILTER_SANITIZE_STRING)){
        mysqli_close($conn);
        echo '{"status":"fields"}';
        exit();
    }
    $s_scholar=filter_var($_POST['s_scholar'],FILTER_SANITIZE_STRING);
}else if($_POST['mem_type']==="s_other"){
    $mem_type=0;
    $s_scholar='';
}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
if($_POST['gender'] === "Male" OR $_POST['gender'] === "Female"){}else{
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$mobile=filter_var($_POST['mobilenumber'],FILTER_SANITIZE_STRING);
if($mobile!==$_POST['mobilenumber'] || strlen($mobile)!=10){
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$e=filter_var(trim($_POST['reg_email']),FILTER_SANITIZE_EMAIL);
if (!filter_var($e, FILTER_VALIDATE_EMAIL) === true){
    mysqli_close($conn);
    echo '{"status":"email"}';
    exit();
}
$p=filter_var($_POST['reg_pass'],FILTER_SANITIZE_STRING);
if(empty($p) OR strlen($p) < 7 OR strlen($p) > 20 OR $p!==$_POST['reg_pass'] OR !preg_match("#[0-9]+#", $p) OR !preg_match("#[a-zA-Z]+#", $p)){
    mysqli_close($conn);
    echo '{"status":"pass1"}';exit();
}
if($p!==$_POST['reg_cpass']){
    mysqli_close($conn);
    echo '{"status":"pass2"}';exit();
}
$dob=str_replace('-','',$_POST['dob_date']);
if(!checkdate(substr($dob,4,2),substr($dob,6,2),substr($dob,0,4))){
    mysqli_close($conn);
    echo '{"status":"d_o_b"}';exit();
}
$dob=$_POST['dob_date'];
$nums=$conn->prepare("SELECT 1 FROM temp WHERE email=? LIMIT 1");
$nums->bind_param("s",$e);
if(!$nums->execute()){
    $nums->close();mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$nums->store_result();$check=$nums->num_rows();$nums->close();
if($check){
    mysqli_close($conn);
    echo '{"status":"verification"}';
    exit();
}
if($mem_type===1){
    $nums=$conn->prepare("SELECT 1 FROM register WHERE email=? OR sch_no=? LIMIT 1");
    $nums->bind_param("ss",$e,$s_scholar);
}else{
    $nums=$conn->prepare("SELECT 1 FROM register WHERE email=? LIMIT 1");
    $nums->bind_param("s",$e);
}
if(!$nums->execute()){
    $nums->close();mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$nums->store_result();$num=$nums->num_rows();$nums->close();
if($num){
    mysqli_close($conn);
    echo '{"status":"register"}';exit();
}
$pass=password_hash($p,PASSWORD_DEFAULT,array('cost'=>10));
$code=md5(uniqid(rand()));
$timestamp = date('Y-m-d G:i:s');
$gen = htmlspecialchars(filter_var($_POST['gender'], FILTER_SANITIZE_STRING),ENT_QUOTES);
//email verification
use PHPMailer\PHPMailer\PHPMailer;
require dirname(__FILE__).'/../phpmail/PHPMailer-master/Exception.php';
require dirname(__FILE__).'/../phpmail/PHPMailer-master/PHPMailer.php';
require dirname(__FILE__).'/../phpmail/PHPMailer-master/SMTP.php';
$config = parse_ini_file(dirname(__FILE__).'/../core/gmail.ini');
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = $config['sender'];
$mail->Password   = $config['pass'];
$mail->IsHTML(true);
$mail->AddAddress($e);
$mail->SetFrom($config['sender'], "Pccoe");
$mail->Subject = "Verify Your Pccoe Tnp Account";
$content = "Hi, <br>Thanks for your registration in Tnp Project, to complete your registration.<br>Please click on below link to verify your E-mail.<br><br>
<a href='http://pccoetnp.epizy.com/process/confirmation.php?action=confirm&email=".$e."&passkey=".$code."'>http://pccoetnp.epizy.com/Confirm_Email</a>
<br><br><span style='color:gray'>Note: Activation link will be valid for 7 days.</span>";

$mail->MsgHTML($content);
if(!$mail->Send()) {
    mysqli_close($conn);
    echo '{"status":"unsuccess"}';
    exit();
}
mysqli_autocommit($conn,FALSE);$qsuccess=1;
$nums = $conn->prepare("INSERT INTO register(email,pass,dateofbirth,gender,mobilenumber,mem_type,sch_no) VALUES(?,?,?,?,?,?,?)");
$nums->bind_param("sssssis",$e,$pass,$dob,$gen,$mobile,$mem_type,$s_scholar);
if(!$nums->execute()){
    $nums->close();
    $qsuccess=0;
}else{
    $user_id=$nums->insert_id;
    $nums->close();
}
if($qsuccess){
    $nums = $conn->prepare("INSERT INTO temp (verify_code,user_id,email) VALUES (?,?,?)");
    $nums->bind_param("sss",$code,$user_id,$e);
    if(!$nums->execute()) {
        $nums->close();
        $qsuccess = 0;
    }
    $nums->close();
}
if($qsuccess){
    mysqli_commit($conn);mysqli_close($conn);
    echo '{"status":"success"}';
}else{
    mysqli_rollback($conn);mysqli_close($conn);
    echo '{"status":"unsuccess"}';
}