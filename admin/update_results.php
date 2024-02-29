<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Kiểm tra nếu không có ID cuộc thi được chuyển từ trang trước
if (!isset($_POST['competition_id'])) {
    echo "Missing competition ID.";
    exit();
} else {
    $competition_id = $_POST['competition_id'];
}

// Xử lý cập nhật kết quả của các người tham gia cuộc thi
$participants_data = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'time_record_') !== false) {
        $entryNO = substr($key, strlen('time_record_'));
        $timeRecord = $_POST['time_record_' . $entryNO];
        $participants_data[] = ['EntryNO' => $entryNO, 'TimeRecord' => $timeRecord];
    }
}

// Function to update Standings based on TimeRecord
function updateStandings($participants_data) {
    // Sort array based on TimeRecord
    usort($participants_data, function($a, $b) {
        return $a['TimeRecord'] <=> $b['TimeRecord'];
    });

    // Update Standings based on new order
    foreach ($participants_data as $index => $participant) {
        $participant['Standings'] = $index + 1;
        $participants_data[$index] = $participant; // Update the array with new Standings
    }

    return $participants_data;
}

// Call updateStandings after TimeRecord is edited
$participants_data = updateStandings($participants_data);

foreach ($participants_data as $participant) {
    $entryNO = $participant['EntryNO'];
    $timeRecord = $participant['TimeRecord'];
    $standings = $participant['Standings'];

    // Thực hiện cập nhật dữ liệu trong cơ sở dữ liệu
    $query_update = "UPDATE participate SET TimeRecord = '$timeRecord', Standings = '$standings' WHERE EntryNO = $entryNO AND MarathonID = $competition_id";
    $result_update = $conn->query($query_update);

    if (!$result_update) {
        echo "Error updating results.";
        exit();
    }
}

// Chuyển hướng người dùng trở lại trang chỉnh sửa kết quả
header("Location: edit_result.php?competition_id=$competition_id");
?>
