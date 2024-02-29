<?php
session_start();

?>
<!DOCTYPE html>
<html>


<head>
    <title>List of Competitions</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php if (!isset($_SESSION['username'])) {
    header("Location: /final-exam/login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
} ?>

<?php include('../includes/loggedin_admin.php'); ?>
<?php if (isset($_SESSION['success'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success']; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
    <h1>List of Competitions</h1>

    <div class="competition-list">
        <?php include('showcompetition.php'); ?>
    </div>
</body>
</html>