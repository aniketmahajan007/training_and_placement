<?php
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Status: 400');exit();
}
header('Status: 200');
mysqli_close($conn);
if($user_id==3 || $user_id==1 || $user_id==4){
    echo '{"status":"admin"}';
}else{
    echo '{"status":"privileges"}';
}
