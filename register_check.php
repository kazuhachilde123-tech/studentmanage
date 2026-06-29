<?php
session_start();
include_once "db.php";



$username = mysqli_real_escape_string($conn, $_POST['username']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

if(!empty($email) && !empty($password) && !empty($confirm_password)){
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if(mysqli_num_rows($sql) > 0){
        $_SESSION['error'] = "Email already exists!";
        header('Location: register.php');
    }else if($password !== $confirm_password){
        $_SESSION['error'] = "Password does not match!";
        header('Location: register.php');
    }else{
        $insert_sql = mysqli_query($conn, "INSERT INTO users(username, phone, email, password, usertype) VALUES('{$username}', '{$phone}','{$email}', '{$password}', 'student')");
        if($insert_sql){
            $_SESSION['success'] = "Register successfully! Please login now.";
            header('Location: login.php');
        }else{
            $_SESSION['error'] = "Failed to register. Please try again!";
            header('Location: register.php');
        }
    }
}else{
    $_SESSION['error'] = "All input field are required";
    header('Location: register.php');
}
