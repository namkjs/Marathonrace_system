<?php
session_start();
require_once('config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user details from the database
    $query = "SELECT * FROM User WHERE Username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['Password'];

        // Verify password
        if (password_verify($password, $stored_password)) {
            $_SESSION['username'] = $username;
            echo "Login successful!";
            header("Location: ./index.php");
        } else {
            $_SESSION['error'] = "Invalid username or password!";
            header("Location: ./login.php"); // Chuyển hướng trở lại trang đăng nhập
        }
    } else {
        $_SESSION['error'] = "Invalid username or password!";
        header("Location: ./login.php"); // Chuyển hướng trở lại trang đăng nhập
    }
}
?>
