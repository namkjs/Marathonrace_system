<?php
require_once(__DIR__ . '/../config.php'); // Include database connection

if (isset($_GET['entry_number']) && isset($_GET['competition_id'])) {
    $entry_number = $_GET['entry_number'];
    $competition_id = $_GET['competition_id'];

    // Perform deletion query
    $delete_query = "DELETE FROM Participate WHERE EntryNO = $entry_number AND MarathonID = $competition_id";
    $result = $conn->query($delete_query);

    if ($result) {
        echo "Participant deleted successfully.";
        $redirect_url = "show_participant.php?competition_id=" . $competition_id;
        header("Location: $redirect_url");
    } else {
        echo "Error deleting participant: " . $conn->error;
    }
} else {
    echo "Invalid parameters provided.";
}
?>
