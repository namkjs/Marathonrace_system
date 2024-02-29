<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $id_query = "SELECT UserID FROM User WHERE Username = '$username'";
    $id_result = $conn->query($id_query);
    $id_row = $id_result->fetch_assoc();
    $userID = $id_row['UserID'];
    $name = $_POST['name'];
    $nationality = $_POST['nationality'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
    $marathon_best_record = $_POST['marathon_best_record'];
    $passport_no = $_POST['passport_no'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Kiểm tra tên có đáp ứng điều kiện validation không
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        // Nếu tên không hợp lệ, hiển thị thông báo và chuyển hướng người dùng quay lại trang chỉnh sửa thông tin cá nhân
        $_SESSION['error'] = "Name can only contain letters and spaces.";
        header("Location: edit_profile.php");
        exit();
    }
    if ($age < 10 || $age > 80) {
        $_SESSION['error'] = "Age must be between 10 and 80.";
        header("Location: edit_profile.php");
        exit();
    }
    if (!preg_match("/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/", $marathon_best_record)) {
        $_SESSION['error'] = "Marathon Best Record must follow the format 'hh:mm:ss'.";
        header("Location: edit_profile.php");
        exit();
    }
    // Check if Passport Number follows the defined format
    if (!preg_match("/^[a-zA-Z0-9\-\.]{6,15}$/", $passport_no)) {
        $_SESSION['error'] = "Passport Number is invalid.";
        header("Location: edit_profile.php");
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format";
        header("Location: edit_profile.php");
        exit();
    }
    if (!preg_match("/^[0-9]+$/", $phone)) {
        $_SESSION['error'] = "Phone number can only contain digits.";
        header("Location: edit_profile.php");
        exit();
    }
    
    // Update thông tin cá nhân trong bảng Participant
    $update_query = "UPDATE Participant SET 
                        Name = '$name', 
                        Nationality = '$nationality', 
                        Sex = '$sex', 
                        Age = '$age', 
                        BestRecord = '$marathon_best_record', 
                        PassportNO = '$passport_no', 
                        Address = '$address', 
                        Email = '$email', 
                        Phone = '$phone' 
                    WHERE UserID = '$userID'";

    $update_result = $conn->query($update_query);

    if ($update_result) {
        echo "Profile updated successfully!";
        header("Location: view_profile.php");

    } else {
        echo "Error updating profile: " . $conn->error;
    }
} else {
    echo "Invalid request!";
}
?>
