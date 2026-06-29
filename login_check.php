<?php
session_start();
include_once "db.php";

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

if(!empty($email) && !empty($password)){
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    if(mysqli_num_rows($sql) > 0){
        $row = mysqli_fetch_assoc($sql);
        if($password === $row['password']){
            $_SESSION['id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['usertype'] = $row['usertype'];

            if($row['usertype'] == 'student'){
                header('Location: studenthome.php');
            }else if($row['usertype'] == 'admin'){
                header('Location: adminhome.php');
            }
        }else{
            $_SESSION['error'] = "Password is incorrect!";
            header('Location: login.php');
        }
    }else{
        $_SESSION['error'] = "Email does not exist!";
        header('Location: login.php');
    }
}else{
    $_SESSION['error'] = "All input field are required";
    header('Location: login.php');
}
