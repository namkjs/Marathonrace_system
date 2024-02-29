<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get username and userID
$username = $_SESSION['username'];
$query_user = "SELECT UserID FROM User WHERE Username='$username'";
$result_user = $conn->query($query_user);

if ($result_user && $result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $userID = $row_user['UserID'];
} else {
    echo "Error: User not found.";
    exit();
}
include('../includes/loggedin.php');

// Get entry number and marathon ID from URL parameters
$entryNo = $_GET['entry_no'];
$marathonID = $_GET['marathon_id'];

// Validate entry number and marathon ID
if (!is_numeric($entryNo) || !is_numeric($marathonID)) {
    echo "Invalid entry or marathon ID.";
    exit();
}

// Query to get competition details and user's participation info
$query = "SELECT marathon.*, participate.*, 
participant.Name, participant.Nationality, participant.Sex, participant.Age, participant.Email, participant.Phone, participant.Address
FROM marathon
INNER JOIN participate ON marathon.MarathonID = participate.MarathonID
INNER JOIN participant ON participate.UserID = participant.UserID
WHERE participate.EntryNO = $entryNo
AND participate.MarathonID = $marathonID";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Competition Details</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
// Display competition details using Bootstrap classes
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div class="container mt-5">
        <h2>Competition Information</h2>
        <div class="row">
            <div class="col-md-6">
                <p><b>Competition ID:</b> <?= $row['MarathonID'] ?></p>
                <p><b>Competition Name:</b> <?= $row['RaceName'] ?></p>
                <p><b>Date:</b> <?= $row['Date'] ?></p>
            </div>
        </div>

        <h2>User Information</h2>
        <div class="row">
            <div class="col-md-6">
                <p><b>Name:</b> <?= $row['Name'] ?></p>
                <p><b>Nationality:</b> <?= $row['Nationality'] ?></p>
                <p><b>Sex:</b> <?= $row['Sex'] ?></p>
                <p><b>Age:</b> <?= $row['Age'] ?></p>
                <p><b>Email:</b> <?= $row['Email'] ?></p>
                <p><b>Phone:</b> <?= $row['Phone'] ?></p>
                <p><b>Address:</b> <?= $row['Address'] ?></p>
            </div>
        </div>

        <h2>Participation Information</h2>
        <div class="row">
            <div class="col-md-6">
                <p><b>Entry Number:</b> <?= $row['EntryNO'] ?></p>
                <p><b>Hotel:</b> <?= $row['Hotel'] ?></p>
                <p><b>Time Record:</b> <?= $row['TimeRecord'] ?></p>
                <p><b>Standings:</b> <?= $row['Standings'] ?></p>
            </div>
        </div>
        <!-- Implement cancellation button using Bootstrap if desired -->
        <!-- ... -->
    </div>
    <?php
} else {
    echo "<div class='container mt-5'>No information found for this competition.</div>";
}
?>

<!-- Bootstrap JS (Optional, for some components) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
