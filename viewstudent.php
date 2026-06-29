<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $sql = "DELETE FROM users WHERE id='{$delete_id}' AND usertype='student'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Student deleted successfully";
    } else {
        $_SESSION['error'] = "Cannot delete student: " . mysqli_error($conn);
    }

    header("Location: viewstudent.php");
    exit;
}

$sql = "SELECT id, username, email, phone FROM users WHERE usertype='student'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
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
                <h1>View Students</h1>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger">
                        <?php
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success">
                        <?php
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($info = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td>
                                    <?php echo "{$info['id']}";?>
                                </td>
                                <td>
                                    <?php echo "{$info['username']}";?>
                                </td>
                                <td><?php echo "{$info['email']}";?></td>
                                <td><?php echo "{$info['phone']}";?></td>
                                <td>
                                    <a href="updatestudent.php?id=<?php echo $info['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="viewstudent.php?delete_id=<?php echo $info['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>