<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit;
}

session_destroy();
header('Location: login.php');
