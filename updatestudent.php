<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: viewstudent.php');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT id, username, email, phone FROM users WHERE id='{$id}' AND usertype='student'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header('Location: viewstudent.php');
    exit;
}

$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $sql = "UPDATE users SET username='{$username}', email='{$email}', phone='{$phone}' WHERE id='{$id}' AND usertype='student'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Student updated successfully";
        header("Location: viewstudent.php");
    } else {
        $_SESSION['error'] = "Cannot update student: " . mysqli_error($conn);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link rel="stylesheet" href="admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="header">
        <span class="header-title"><a href="adminhome.php">Admin Dashboard</a></span>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="admin-container">
        <?php include 'admin_sidebar.php'; ?>

        <div class="main-content">
            <div class="content">
                <h2>Update Student</h2>
                <form action="updatestudent.php?id=<?php echo $student['id']; ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo ($student['username']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo ($student['email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo ($student['phone']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Student</button>
                    <a href="viewstudent.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
