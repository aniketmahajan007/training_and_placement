<?php
if($_SERVER['REQUEST_METHOD']!=='POST'){
    header('Status: 400');exit();
}
header('Status: 200');
if(empty($_FILES["profile_avatar"]["name"]) OR !$_FILES["profile_avatar"]["size"]){
    mysqli_close($conn);echo '{"status":"fields"}';exit();
}
$checks=htmlspecialchars(filter_var($_FILES["profile_avatar"]["name"],FILTER_SANITIZE_STRING));
$check = @getimagesize($_FILES["profile_avatar"]["tmp_name"]);
if(!$check){
    mysqli_close($conn);echo '{"status":"error"}';exit();
}
$cur_size=$_FILES["profile_avatar"]["size"];
if($cur_size>1024000){
    mysqli_close($conn);
    echo '{"status":"size"}';exit();
}
$coman=array("/'/","/,/","/ /","/!/","/@/","/#/","/%/","/&/");
$ImageName=preg_replace($coman,"-",strtolower(mb_convert_encoding($checks,'UTF-8', 'HTML-ENTITIES')));
$ImageExt=mime_content_type($_FILES["profile_avatar"]["tmp_name"]);
if($ImageExt==="image/jpg" OR $ImageExt==="image/jpeg" OR $ImageExt==="image/png"){}else{
    mysqli_close($conn);echo '{"status":"format"}';exit();
}
$ImageName = substr(str_replace(array(" ","."),"-",preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName)),0,16);
$ImageName=$ImageName.'-'.rand(0,99).'.'.str_replace('image/','',$ImageExt);
$nums=$conn->prepare("SELECT avatar FROM register WHERE user_id=? LIMIT 1");
$nums->bind_param("i",$user_id);
if(!$nums->execute()){
    mysqli_close($conn);echo '{"status":"error"}';exit();
}
$nums->bind_result($savatar);$nums->fetch();
$nums->close();
if(!move_uploaded_file($_FILES["profile_avatar"]["tmp_name"], dirname(__FILE__).'/../../profile_avatar/'.$ImageName)){
    mysqli_close($conn);echo '{"status":"error"}';exit();
}
$savatar=str_replace('http://pccoetnp.epizy.com/profile_avatar/','',$savatar);
$ImageName2='http://pccoetnp.epizy.com/profile_avatar/'.$ImageName;
$nums=$conn->prepare("UPDATE register SET avatar=? WHERE user_id=? LIMIT 1");
$nums->bind_param("si",$ImageName2,$user_id);
if(!$nums->execute()){
    @unlink(dirname(__FILE__).'/../../profile_avatar/'.$ImageName);
    mysqli_close($conn);echo '{"status":"error"}';exit();
}
$nums->close();
@unlink(dirname(__FILE__).'/../../profile_avatar/'.$savatar);
echo '{"status":"success","profile_avatar":"'.$ImageName2.'"}';