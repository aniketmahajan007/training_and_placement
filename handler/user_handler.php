<?php
/**
 * Created by IntelliJ IDEA.
 * User: Aniket
 * Date: 29-07-2020
 * Time: 13:45
 */
ob_start();
require('../router/core/apicore.php');
if (!isset($secure) OR $secure !=1) {
    header('Status: 400');
    exit();
}
if (!isset($_GET['requesting']) OR $_GET['requesting'] < 1 OR $_GET['requesting'] > 3) {
    header('Status: 400');
    exit();
}
header("Content-Type: application/json");
switch ((int)$_GET['requesting']) {
    case 1:
        require('../router/reg_ajax/registration.php');
        break;
    case 2:
        require('../router/reg_ajax/login.php');
        break;
    case 3:
        require('../router/reg_ajax/admin_login.php');
        break;
    default:
        header('Status: 400');
        break;
}
