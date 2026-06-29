<?php
session_start();
include_once 'db.php';


$sql = "SELECT * FROM teacher";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav>
        <label class="logo" for="">A-School</label>
        <ul>
            <li><a href="">Home</a></li>
            <li><a href="">Contact</a></li>
            <li class="btn btn-success"><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <div class="section1">
        <label class="img_text" for="">We Teach Students With Care</label>
        <img class="main_image" src="school.png" alt="">
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img class="welcome_img" src="playground.jpg" alt="">
            </div>
            <div class="col-md-8">
                <h1>Welcome to A-school</h1>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>

        </div>
    </div>

    <center>
        <h1>Our Teacher</h1>
    </center>
    <div class="container">

        <div class="row">
            <?php while ($teacher = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <img class="teacher" src="<?= $teacher['image'] ?>" alt="<?= $teacher['name'] ?>">
                    <h5><?= $teacher['name'] ?></h5>
                    <p><?= $teacher['description'] ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <center>
        <h1>Our Courses</h1>
    </center>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img class="teacher" src="web_development.png" alt="">
                <p>Web Development</p>
            </div>
            <div class="col-md-4">
                <img class="teacher" src="graphic_design.png" alt="">
                <p>Graphic Design</p>
            </div>
            <div class="col-md-4">
                <img class="teacher" src="digital_marketing.png" alt="">
                <p>Digital Marketing</p>
            </div>
        </div>
    </div>

    <center>
        <h1>Admission Form</h1>
    </center>
    <div class="container" style="max-width: 600px; margin: 30px auto;">
        <?php
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            if (strpos($message, 'success') !== false) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            }
            echo $message;
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo '</div>';
            unset($_SESSION['message']);
        }
        ?>
        <form action="data_check.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter your message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" value="apply" name="apply">Apply</button>
        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</html>