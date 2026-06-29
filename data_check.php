<?php
session_start();
include_once "db.php";

if(isset($_POST['apply'])){
    $data_name=$_POST['name'];
    $data_email=$_POST['email'];
    $data_phone=$_POST['phone'];
    $data_message=$_POST['message'];

    $sql= "INSERT INTO admission(name, email, phone, message) VALUES ('{$data_name}','{$data_email}', '{$data_phone}', '{$data_message}')";
    $result = mysqli_query($conn, $sql);

    if($result){
        $_SESSION['message'] = "your application sent success";
        header("Location: index.php");
    }else{
        $_SESSION['message'] = "your application sent failed";
        header("Location: index.php");
    }
}
?>