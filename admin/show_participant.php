<?php
require_once(__DIR__ . '/../config.php'); // Include database connection
include('../includes/loggedin_admin.php');

// Check if 'competition_id' parameter exists in the URL
if (isset($_GET['competition_id'])) {
    // Get the competition ID from the URL
    $competition_id = $_GET['competition_id'];

    // Fetch participant details based on the competition ID from Participate table
    $query = "SELECT p.EntryNO, u.Name, u.BestRecord, u.Sex, u.Age 
                FROM Participate p
                JOIN Participant u ON p.UserID = u.UserID
                WHERE p.MarathonID = $competition_id";

    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        echo "<h2>List of Participants</h2>";
        echo "<div class='container mt-4'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Entry Number</th>";
        echo "<th scope='col'>Name</th>";
        echo "<th scope='col'>Best Record</th>";
        echo "<th scope='col'>Sex</th>";
        echo "<th scope='col'>Age</th>";
        echo "<th scope='col'>Action</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['EntryNO'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['BestRecord'] . "</td>";
            echo "<td>" . $row['Sex'] . "</td>";
            echo "<td>" . $row['Age'] . "</td>";
            echo "<td><button type='button' class='btn btn-danger' onclick=\"deleteParticipant(" . $row['EntryNO'] . ")\">Delete</button></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        // JavaScript function to handle deletion
        echo "<script>
            function deleteParticipant(entryNumber) {
                if (confirm('Are you sure you want to delete this participant?')) {
                    window.location.href = 'delete_participant.php?entry_number=' + entryNumber + '&competition_id=$competition_id';
                }
            }
        </script>";

    } else {
        echo "<p class='alert alert-warning mt-4'>No participants found for this competition.</p>";
    }
} else {
    echo "<p class='alert alert-danger mt-4'>Invalid competition ID.</p>";
}
?>
