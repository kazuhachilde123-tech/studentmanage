<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="header">
        <span class="header-title">Admin Dashboard</span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <div class="sidebar">
            <div class="sidebar-section">
                <h3>Student</h3>
                <ul>
                    <li><a href="addstudent.php">My Courses</a></li>
                    <li><a href="viewstudent.php">My result</a></li>
                </ul>
            </div>
        </div>

        <div class="main-content">
            <h2>Sidebar Accordion</h2>
            <p>In this example, we have added an accordion and a dropdown menu inside the side navigation. Click on both to understand how they differ from each other. The accordion will push down the content, while the dropdown lays over the content.</p>
        </div>
    </div>
</body>
</html>