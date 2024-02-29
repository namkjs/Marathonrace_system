<?php
require_once(__DIR__ . '/../config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset($_POST['competition_id']) && isset($_POST['competition_name']) && isset($_POST['time_of_event'])) {
        $competition_id = $_POST['competition_id'];
        $competition_name = $_POST['competition_name'];
        $time_of_event = $_POST['time_of_event'];

        // Update competition details in the database
        $query = "UPDATE marathon
                  SET racename = '$competition_name', 
                      date = '$time_of_event' 
                  WHERE marathonid = $competition_id";

        $updateResult = $conn->query($query);

        // Check if update was successful
        if ($updateResult) {
            echo "Competition information updated successfully!";
            header("Location: /final-exam/index.php");
        } else {
            echo "Error updating competition information: " . $conn->error;
        }
    } else {
        echo "Missing required fields.";
    }
} else {
    echo "Invalid request method.";
}
?>
