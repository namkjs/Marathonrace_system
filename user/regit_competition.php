<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $marathon_id = $_GET['id'];

    // Get UserID from the User table
    $query_user = "SELECT UserID FROM User WHERE Username = '$username'";
    $result_user = $conn->query($query_user);

    if ($result_user && $result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        $user_id = $row_user['UserID'];
        $query_info = "SELECT * FROM participant WHERE UserID = $user_id";
        $result_info = $conn->query($query_info);
        $temp = 0;
        while ($row = $result_info->fetch_assoc()) {
            foreach ($row as $column) {
                if ($column === NULL) {
                    $temp++;
                    break; 
                }
            }
        }
        if ($temp == 0){
            $query_check = "SELECT * FROM Participate WHERE UserID = $user_id AND MarathonID = $marathon_id";
            $result_check = $conn->query($query_check);

            if ($result_check && $result_check->num_rows == 0) {
                // Get the entry number for the competition registration
                $query_entry_no = "SELECT COUNT(*) AS total FROM Participate WHERE MarathonID = $marathon_id";
                $result_entry_no = $conn->query($query_entry_no);

                if ($result_entry_no && $row = $result_entry_no->fetch_assoc()) {
                    $entry_no = $row['total'] + 1; // New value for EntryNO
                    $query_insert = "INSERT INTO Participate (MarathonID, UserID, EntryNO, Hotel, TimeRecord, Standings) 
                                    VALUES ($marathon_id, $user_id, $entry_no, NULL, NULL, NULL)";
                    $result_insert = $conn->query($query_insert);

                    if ($result_insert) {
                        $_SESSION['success_message'] = "Registration successful!";
                    } else {
                        $_SESSION['error_message'] = "Registration failed: " . $conn->error;
                    }
                } else {
                    $_SESSION['error_message'] = "Error retrieving the registration count!";
                }
            } else {
                $_SESSION['error_message'] = "You have already registered for this competition!";
            }
        } else {
            $_SESSION['error_message'] = "Please provide user information before registering";
        }
    }
} else {
    $_SESSION['error_message'] = "Invalid request or user not logged in!";
}

header("Location: show_competition.php");
exit();
?>
