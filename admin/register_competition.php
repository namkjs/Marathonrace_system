<?php
session_start();
require_once(__DIR__ . '/../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $competition_id = $_POST['competition_id'];
    $competition_name = $_POST['competition_name'];
    $time_of_event = $_POST['time_of_event'];
#1/1/1970
    $event_timestamp = strtotime($time_of_event);

    $checkQuery = "SELECT * FROM marathon WHERE marathonid = '$competition_id'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        // If competition ID already exists, set an error message in a session variable
        $_SESSION['error'] = "Competition ID already exists. Please choose a different ID.";
        header("Location: registation_form.php"); // Redirect to the registration form
        exit();
    } elseif ($event_timestamp < time()) {
        // If event time is earlier than current time, set an error message
        $_SESSION['error'] = "Event time cannot be in the past. Please select a future time.";
        header("Location: registation_form.php"); // Redirect to the registration form
        exit();
    } else {
        // Insert new competition details into the database
        $insertQuery = "INSERT INTO marathon (marathonid, racename, date) 
                        VALUES ('$competition_id', '$competition_name', '$time_of_event')";
        $insertResult = $conn->query($insertQuery);

        if ($insertResult) {
            $_SESSION['success'] = "Competition registration successful!";
        } else {
            $_SESSION['error'] = "Competition registration failed: " . $conn->error;
        }
        header("Location: show_competition.php"); // Redirect to another page after registration
        exit();
    }
} else {
    $_SESSION['error'] = "Error: Access denied.";
    header("Location: registation_form.php"); // Redirect to the registration form
    exit();
}
?>
