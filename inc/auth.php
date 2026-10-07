<?php
// Enable error display temporarily for local debugging
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once '../class/db_connection.php';

$addItems = new AddItems();
$assetController = new assetsController;
$select = new Select();
$operation = new Operations();
$db = new Connection();
$register = new Register();
$getAllUser = new get_All_User();

if(!empty($_SESSION['id'])) {
    $user = $select->selectUserById($_SESSION['id']);
    $id = $user['id'];
    $username = $user['username'];
    $role = $user['role'];

    
} else {
    header("Location: ../php/login.php");
}