<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
if($user_id==3 || $user_id==1 || $user_id==4){}else{
    echo '{"status":"privileges"}';
}
$nums=$conn->prepare("SELECT register.user_id,register.email,register.mobilenumber,user_info.placed_status,user_info.name,user_info.resume FROM register,user_info WHERE register.user_id=user_info.user_id ORDER BY register.user_id");
if(!$nums->execute()){
    echo '{"status":"error"}';
    $nums->close();
    exit();
}
$nums->bind_result($fetch['uid'],$fetch['email'],$fetch['mob_number'],$fetch['p_status'],$fetch['u_name'],$fetch['resume_url']);
while($nums->fetch()){
    $temp[]=array('Uid'=>$fetch['uid'],'user_email'=>$fetch['email'],'mob_number'=>$fetch['mob_number'],'p_status'=>$fetch['p_status'],'u_name'=>$fetch['u_name'],'resume_url'=>$fetch['resume_url']);
}$nums->close();
echo json_encode($temp);
