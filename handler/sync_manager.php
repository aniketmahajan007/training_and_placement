<?php
ob_start();
require('../router/core/apicore.php');
if (!isset($secure) OR $secure !=0) {
    header('Status: 400');
    exit();
}
if (!isset($_GET['requesting']) OR $_GET['requesting'] < 1 OR $_GET['requesting'] > 5) {
    header('Status: 400');
    exit();
}
header("Content-Type: application/json");
switch ((int)$_GET['requesting']) {
    case 1:
        require('../router/reg_ajax/log_out.php');
        break;
    case 2:
        require('../router/ajax-load/user_data.php');
        break;
    case 3:
        require('../router/update/edit_user_data.php');
        break;
    case 4:
        require('../router/update/update_pic.php');
        break;
    case 5:
        require('../router/update/update_resume.php');
        break;
    default:
        header('Status: 400');
        break;
}