<?php
/**
 * Created by IntelliJ IDEA.
 * User: Aniket
 * Date: 17-08-2018
 * Time: 22:38
 */
ob_start();
$action=filter_var($_GET['action'],FILTER_SANITIZE_STRING);
require (dirname(__FILE__).'/../router/process/confirmation.php');