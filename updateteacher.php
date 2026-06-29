<?php
session_start();
include_once "db.php";

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: viewteacher.php');
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$sql = "SELECT * FROM teacher WHERE id='{$id}'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    header('Location: viewteacher.php');
    exit;
}

$teacher = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $image = $teacher['image'];

    if ($_FILES['image']['name']) {
        $new_image = $_FILES['image']['name'];
        $dst = "./image/" . $new_image;
        $dst_db = "image/" . $new_image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $dst)) {
            $_SESSION['error'] = "Failed to upload image. Please check folder permissions.";
            header("Location: updateteacher.php?id={$id}");
            exit;
        }
        $image = $dst_db;
    }

    $sql = "UPDATE teacher SET name='{$name}', description='{$description}', image='{$image}' WHERE id='{$id}'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Teacher updated successfully";
        header("Location: viewteacher.php");
    } else {
        $_SESSION['error'] = "Cannot update teacher: " . mysqli_error($conn);
        header("Location: updateteacher.php?id={$id}");
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher</title>
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
                <h2>Update Teacher</h2>
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

                <form action="updateteacher.php?id=<?php echo $teacher['id']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($teacher['name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($teacher['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <?php if ($teacher['image']): ?>
                            <div class="mb-2">
                                <img src="<?php echo htmlspecialchars($teacher['image']); ?>" width="100" height="100" style="object-fit:cover;">
                                <p class="text-muted small">Current image</p>
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Teacher</button>
                    <a href="viewteacher.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
