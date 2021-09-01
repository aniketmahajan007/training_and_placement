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
        require('../router/admin/admin_checker.php');
        break;
    case 2:
        require('../router/admin/admin_s_table_info.php');
        break;
    case 3:
        require('../router/admin/student_profile.php');
        break;
    case 4:
        require('../router/admin/placed.php');
        break;
    default:
        header('Status: 400');
        break;
}
