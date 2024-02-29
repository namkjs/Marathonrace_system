<?php
require_once(__DIR__ . '/../config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Remember to hash passwords securely

    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Insert user details into the database
    $query = "INSERT INTO User (Username, Password, is_admin) VALUES ('$username', '$hashed_password', TRUE)";
    $result = $conn->query($query);

    if ($result) {
        echo "Registration successful!";
        header("Location: ./index.php");
    } else {
        echo "Registration failed: " . $conn->error;
    }
}
?>
