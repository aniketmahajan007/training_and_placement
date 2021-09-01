<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
$nums=$conn->prepare("SELECT register.mem_type,register.sch_no,pnr_number,name,coursename,yearofcomplete,clgname,register.rollno,ssc,sscboard,sscyear,hsc,hscboard,hscyear,graduation,gradclg,gradyear,fysem1sgpa,fysem1per,fysem2sgpa,fysem2per,sysem1sgpa,sysem1per,sysem2sgpa,sysem2per,tysem1sgpa,tysem1per,tysem2sgpa,tysem2per,aggcgpa,aggper,livebacklog,deadbacklog,noofyd,register.mobilenumber,register.email,profession,company_name,father_email,father_number,register.gender,register.dateofbirth,peraddress,localaddress,district,hdistrict,state,register.avatar,resume,placed_status,place_in FROM user_info,register WHERE register.user_id=? AND user_info.user_id=? LIMIT 1");
$nums->bind_param("ii",$user_id,$user_id);
if(!$nums->execute()){
    echo '{"status":"error"}';
    $nums->close();
    exit();
}
$fetch=[];
$nums->bind_result($fetch['mem_type'],$fetch['sch_no'],$fetch['pnr_no'],$fetch['full_name'],$fetch['coursename'],$fetch['yearofcomplete'],$fetch['clgname'],$fetch['rollno'],$fetch['ssc'],$fetch['sscboard'],$fetch['sscyear'],$fetch['hsc'],$fetch['hscboard'],$fetch['hscyear'],$fetch['graduation'],$fetch['gradclg'],$fetch['gradyear'],$fetch['fysem1sgpa'],$fetch['fysem1per'],$fetch['fysem2sgpa'],$fetch['fysem2per'],$fetch['sysem1sgpa'],$fetch['sysem1per'],$fetch['sysem2sgpa'],$fetch['sysem2per'],$fetch['tysem1sgpa'],$fetch['tysem1per'],$fetch['tysem2sgpa'],$fetch['tysem2per'],$fetch['aggcgpa'],$fetch['aggper'],$fetch['livebacklog'],$fetch['deadbacklog'],$fetch['noofyd'],$fetch['mobilenumber'],$fetch['email'],$fetch['profession'],$fetch['company_name'],$fetch['father_email'],$fetch['father_number'],$fetch['gender'],$fetch['dateofbirth'],$fetch['peraddress'],$fetch['localaddress'],$fetch['district'],$fetch['hdistrict'],$fetch['state'],$fetch['profile_avatar'],$fetch['user_resume'],$fetch['placed_status'],$fetch['placed_in']);
$nums->fetch();
$nums->close();
mysqli_close($conn);
if($fetch['mem_type']==1){
    $fetch['mem_type']="Pccoe Student";
}else{
    $fetch['mem_type']="Other college Student";
}
echo json_encode($fetch);
