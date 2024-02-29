<?php
$servername = "localhost"; // Change to your MySQL server address
$username = "root"; // Change to your MySQL username
$password = "123456"; // Change to your MySQL password
$database = "final_exam"; // Change to your database name
// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $database, 3308);
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

?>
