<?php
session_start();
require_once(__DIR__ . '/../config.php');

if (isset($_GET['entry_no']) && isset($_GET['marathon_id'])) {
    $entry_no = $_GET['entry_no'];
    $marathon_id = $_GET['marathon_id'];

    // Xóa thông tin đăng ký của người dùng dựa vào EntryNO, MarathonID và UserID
    $query = "DELETE FROM Participate WHERE EntryNO = $entry_no AND MarathonID = $marathon_id";

    if ($conn->query($query) === TRUE) {
        // Nếu xóa thành công, quay trở lại trang list_competition.php
        header("Location: list_competition.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid request.";
}

?>
