<?php
// Include the database connection file (config.php)
require_once(__DIR__ . '/../config.php');

if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Lấy ID của cuộc thi từ tham số truyền vào
    $competition_id = $_GET['id'];

    $delete_query = "DELETE FROM marathon WHERE MarathonID = '$competition_id'";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: show_competition.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No competition ID provided";
}
?>
