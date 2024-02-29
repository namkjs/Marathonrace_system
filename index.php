<?php
session_start();
require_once('config.php'); // Include database connection

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Truy vấn để lấy thông tin vai trò của người dùng
    $query = "SELECT is_admin FROM User WHERE Username = '$username'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $is_admin = $row['is_admin'];

        if ($is_admin == 1) {
            header("Location: admin/home.php");
            exit();
        } else {
            header("Location: user/home.php");
            exit();
        }
    }
} else {
    header("Location: home.php");
    exit();
}
?>
