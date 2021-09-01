<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST' OR !isset($_POST['pnr_no'],$_POST['login_device'],$_POST['full_name'],$_POST['coursename'],$_POST['yearofcomplete'],$_POST['clgname'],$_POST['ssc'],$_POST['sscboard'],$_POST['sscyear'],$_POST['hsc'],$_POST['hscboard'],$_POST['hscyear'],$_POST['graduation'],$_POST['gradclg'],$_POST['gradyear'],$_POST['fysem1sgpa'],$_POST['fysem1per'],$_POST['fysem2sgpa'],$_POST['fysem2per'],$_POST['sysem1sgpa'],$_POST['sysem1per'],$_POST['sysem2sgpa'],$_POST['sysem2per'],$_POST['tysem1sgpa'],$_POST['tysem1per'],$_POST['tysem2sgpa'],$_POST['tysem2per'],$_POST['aggcgpa'],$_POST['aggper'],$_POST['livebacklog'],$_POST['deadbacklog'],$_POST['noofyd'],$_POST['mobilenumber'],$_POST['profession'],$_POST['company_name'],$_POST['father_email'],$_POST['father_number'],$_POST['peraddress'],$_POST['localaddress'],$_POST['district'],$_POST['hdistrict'],$_POST['state'],$_POST['rollno'])){
    header('Status: 400');exit();
}
header('Status: 200');
$log_device=filter_var($_POST['login_device'],FILTER_SANITIZE_STRING);
if($log_device==="web" || $log_device==="android" || $log_device==="ios"){}else{
    mysqli_close($conn);
    echo '{"status":"invalid_device"}';
    exit();
}
$fetch=[];
$fetch['full_name']=filter_var($_POST['full_name'],FILTER_SANITIZE_STRING);
$fetch['coursename']=filter_var($_POST['coursename'],FILTER_SANITIZE_STRING);
$fetch['clgname']=filter_var($_POST['clgname'],FILTER_SANITIZE_STRING);
$fetch['sscboard']=filter_var($_POST['sscboard'],FILTER_SANITIZE_STRING);
$fetch['hscboard']=filter_var($_POST['hscboard'],FILTER_SANITIZE_STRING);
$fetch['gradclg']=filter_var($_POST['gradclg'],FILTER_SANITIZE_STRING);
$fetch['profession']=filter_var($_POST['profession'],FILTER_SANITIZE_STRING);
$fetch['company_name']=filter_var($_POST['company_name'],FILTER_SANITIZE_STRING);
$fetch['district']=filter_var($_POST['district'],FILTER_SANITIZE_STRING);
$fetch['hdistrict']=filter_var($_POST['hdistrict'],FILTER_SANITIZE_STRING);
$fetch['state']=filter_var($_POST['state'],FILTER_SANITIZE_STRING);
$fetch['pnr_number']=filter_var($_POST['pnr_no'],FILTER_SANITIZE_STRING);
$fetch['rollno']=filter_var($_POST['rollno'],FILTER_SANITIZE_STRING);
if($_POST['pnr_no']!=$fetch['pnr_number'] OR $_POST['hdistrict']!=$fetch['hdistrict'] OR $_POST['state'] !=$fetch['state'] OR $_POST['district']!=$fetch['district'] OR $_POST['company_name']!=$fetch['company_name'] OR $_POST['profession']!=$fetch['profession'] OR $_POST['gradclg']!=$fetch['gradclg'] OR $_POST['hscboard']!=$fetch['hscboard'] OR $_POST['sscboard']!=$fetch['sscboard'] OR $_POST['full_name']!=$fetch['full_name'] OR $_POST['coursename']!=$fetch['coursename'] OR $fetch['clgname']!=$_POST['clgname']){
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
function validate_year($year){
    if(strlen($_POST['yearofcomplete'])>4 OR strlen($_POST['yearofcomplete'])<1){
        return false;
    }
    return true;
}
function valid_percent($percent){
    if(empty(trim($percent))){
        return "";
    }
    if($percent<1){
        return 0;
    }
    if(is_float($percent)){
        return round($percent, 2);
    }else{
        $percent=substr((int)$_POST['ssc'],0,3);
        if($percent>99){
            $percent=100;
        }
        return $percent;
    }
}
function validate_mobile($mobile)
{
    return preg_match('/^[0-9]{10}+$/', $mobile);
}
if(!validate_year($_POST['yearofcomplete'])){
    mysqli_close($conn);
    echo '{"status":"yearofcomplete"}';
    exit();
}
$fetch['yearofcomplete']=(int)$_POST['yearofcomplete'];
$fetch['ssc']=valid_percent($_POST['ssc']);
if(!validate_year($_POST['sscyear'])){
    mysqli_close($conn);
    echo '{"status":"sscyear"}';
    exit();
}
$fetch['sscyear']=(int)$_POST['sscyear'];
$fetch['hsc']=valid_percent($_POST['hsc']);
if(!validate_year($_POST['hscyear'])){
    mysqli_close($conn);
    echo '{"status":"hscyear"}';
    exit();
}
$fetch['hscyear']=(int)$_POST['hscyear'];
$fetch['graduation']=valid_percent($_POST['graduation']);
if(!validate_year($_POST['gradyear'])){
    mysqli_close($conn);
    echo '{"status":"gradyear"}';
    exit();
}
$fetch['gradyear']=(int)$_POST['gradyear'];
$fetch['fysem1sgpa']=valid_percent($_POST['fysem1sgpa']);
$fetch['fysem1per']=valid_percent($_POST['fysem1per']);
$fetch['fysem2sgpa']=valid_percent($_POST['fysem2sgpa']);
$fetch['fysem2per']=valid_percent($_POST['fysem2per']);
$fetch['sysem1sgpa']=valid_percent($_POST['sysem1sgpa']);
$fetch['sysem1per']=valid_percent($_POST['sysem1per']);
$fetch['sysem2sgpa']=valid_percent($_POST['sysem2sgpa']);
$fetch['sysem2per']=valid_percent($_POST['sysem2per']);
$fetch['tysem1sgpa']=valid_percent($_POST['tysem1sgpa']);
$fetch['tysem1per']=valid_percent($_POST['tysem1per']);
$fetch['tysem2sgpa']=valid_percent($_POST['tysem2sgpa']);
$fetch['tysem2per']=valid_percent($_POST['tysem2per']);
$fetch['aggcgpa']=valid_percent($_POST['aggcgpa']);
$fetch['aggper']=valid_percent($_POST['aggper']);
if(empty($_POST['livebacklog']) OR $_POST['livebacklog']<1){
    $fetch['livebacklog']=0;
}else{
    $fetch['livebacklog']=$_POST['livebacklog'];
}
if(empty($_POST['deadbacklog']) OR $_POST['deadbacklog']<1){
    $fetch['deadbacklog']=0;
}else{
    $fetch['deadbacklog']=$_POST['deadbacklog'];
}
if(empty($_POST['noofyd']) OR $_POST['noofyd']<1){
    $fetch['noofyd']=0;
}else{
    $fetch['noofyd']=$_POST['noofyd'];
}
if(!validate_mobile($_POST['mobilenumber'])){
    mysqli_close($conn);
    echo '{"status":"mob_number"}';
    exit();
}
$fetch['mobilenumber']=$_POST['mobilenumber'];
if(!empty($_POST['father_email'])){
    if (!filter_var($_POST['father_email'], FILTER_VALIDATE_EMAIL)) {
        mysqli_close($conn);
        echo '{"status":"f_email"}';
        exit();
    }
}
$fetch['father_email']=$_POST['father_email'];
if(!validate_mobile($_POST['father_number'])){
    mysqli_close($conn);
    echo '{"status":"father_number"}';
    exit();
}
$fetch['father_number']=$_POST['father_number'];
$fetch['peraddress']=$_POST['peraddress'];
$fetch['localaddress']=$_POST['localaddress'];

$nums=$conn->prepare("UPDATE user_info SET pnr_number=?,name=?,coursename=?,yearofcomplete=?,peraddress=?,localaddress=?,hdistrict=?,district=?,state=?,clgname=?,ssc=?,sscboard=?,sscyear=?,hsc=?,hscboard=?,hscyear=?,graduation=?,gradclg=?,gradyear=?,fysem1sgpa=?,fysem1per=?,fysem2sgpa=?,fysem2per=?,sysem1sgpa=?,sysem1per=?,sysem2sgpa=?,sysem2per=?,tysem1sgpa=?,tysem1per=?,tysem2sgpa=?,tysem2per=?,aggcgpa=?,aggper=?,livebacklog=?,deadbacklog=?,noofyd=?,profession=?,company_name=?,father_email=?,father_number=? WHERE user_id=? LIMIT 1");
$nums->bind_param("sssisssssssssssssssssssssssssssssiiissssi",$fetch['pnr_number'],$fetch['full_name'],$fetch['coursename'],$fetch['yearofcomplete'],$fetch['peraddress'],$fetch['localaddress'],$fetch['hdistrict'],$fetch['district'],$fetch['state'],$fetch['clgname'],$fetch['ssc'],$fetch['sscboard'],$fetch['sscyear'],$fetch['hsc'],$fetch['hscboard'],$fetch['hscyear'],$fetch['graduation'],$fetch['gradclg'],$fetch['gradyear'],$fetch['fysem1sgpa'],$fetch['fysem1per'],$fetch['fysem2sgpa'],$fetch['fysem2per'],$fetch['sysem1sgpa'],$fetch['sysem1per'],$fetch['sysem2sgpa'],$fetch['sysem2per'],$fetch['tysem1sgpa'],$fetch['tysem1per'],$fetch['tysem2sgpa'],$fetch['tysem2per'],$fetch['aggcgpa'],$fetch['aggper'],$fetch['livebacklog'],$fetch['deadbacklog'],$fetch['noofyd'],$fetch['profession'],$fetch['company_name'],$fetch['father_email'],$fetch['father_number'],$user_id);
if(!$nums->execute()){
    $nums->close();mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$nums->close();
$nums=$conn->prepare("UPDATE register SET mobilenumber=?,rollno=? WHERE user_id=? LIMIT 1");
$nums->bind_param("ssi",$fetch['mobilenumber'],$fetch['rollno'],$user_id);
if(!$nums->execute()){
    $nums->close();mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$nums->close();
mysqli_close($conn);
echo '{"status":"success"}';


















