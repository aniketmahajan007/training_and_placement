<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Status: 400');
    exit();
}
header('Status: 200');
if (empty($_FILES["user_resume"]["name"]) OR !$_FILES["user_resume"]["size"]) {
    mysqli_close($conn);
    echo '{"status":"fields"}';
    exit();
}
$checks = htmlspecialchars(filter_var($_FILES["user_resume"]["name"], FILTER_SANITIZE_STRING));
$cur_size = $_FILES["user_resume"]["size"];
if ($cur_size > 2048000) {
    mysqli_close($conn);
    echo '{"status":"size"}';
    exit();
}
$coman = array("/'/", "/,/", "/ /", "/!/", "/@/", "/#/", "/%/", "/&/");
$ImageName = preg_replace($coman, "-", strtolower(mb_convert_encoding($checks, 'UTF-8', 'HTML-ENTITIES')));
$ImageExt = mime_content_type($_FILES["user_resume"]["tmp_name"]);
if ($ImageExt !== "application/pdf") {
    mysqli_close($conn);
    echo '{"status":"format"}';
    exit();
}
$ImageName = substr(str_replace(array(" ", "."), "-", preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName)), 0, 16);
$ImageName = $ImageName . '-' . rand(0, 99) . '.' . str_replace('application/', '', $ImageExt);
$nums=$conn->prepare("SELECT resume FROM user_info WHERE user_id=? LIMIT 1");
$nums->bind_param("i",$user_id);
if(!$nums->execute()){
    mysqli_close($conn);echo '{"status":"error"}';exit();
}
$nums->bind_result($sresume);$nums->fetch();
$nums->close();
if (!move_uploaded_file($_FILES["user_resume"]["tmp_name"], dirname(__FILE__) . '/../../user_resume/' . $ImageName)) {
    mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$sresume=str_replace('http://pccoetnp.epizy.com/user_resume/','',$sresume);
$ImageName2 = 'http://pccoetnp.epizy.com/user_resume/' . $ImageName;
$nums = $conn->prepare("UPDATE user_info SET resume=? WHERE user_id=? LIMIT 1");
$nums->bind_param("si", $ImageName2, $user_id);
if (!$nums->execute()) {
    @unlink(dirname(__FILE__) . '/../../user_resume/' . $ImageName);
    mysqli_close($conn);
    echo '{"status":"error"}';
    exit();
}
$nums->close();
@unlink(dirname(__FILE__) . '/../../user_resume/'.$sresume);
echo '{"status":"success","user_resume":"' . $ImageName2 . '"}';