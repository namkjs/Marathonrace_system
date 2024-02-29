<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$username = $_SESSION['username'];

// Lấy UserID của người dùng đăng nhập
$query_user = "SELECT UserID FROM User WHERE Username='$username'";
$result_user = $conn->query($query_user);

if ($result_user && $result_user->num_rows > 0) {
    $row_user = $result_user->fetch_assoc();
    $userID = $row_user['UserID'];

    // Lấy danh sách cuộc thi mà UserID đã đăng ký tham gia từ bảng Participate
    $query = "SELECT marathon.MarathonID, marathon.RaceName, marathon.Date, participate.EntryNO 
              FROM marathon 
              INNER JOIN participate ON marathon.MarathonID = participate.MarathonID 
              WHERE participate.UserID = $userID";

    $result = $conn->query($query);
}
// ... (Previous code remains the same)
include('../includes/loggedin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Competitions</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php if ($result && $result->num_rows > 0) : ?>
        <h2>List of Competitions</h2>

        <?php
        // Get current date for comparison
        $currentDate = date('Y-m-d');

        // Table for competitions after today's date
        echo "<h3>Upcoming Competitions</h3>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>
                <tr>
                    <th>Competition ID</th>
                    <th>Competition Name</th>
                    <th>Date</th>
                    <th>Cancel Registration</th>
                </tr>
              </thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            if ($row['Date'] >= $currentDate) {
                echo "<tr>";
                echo "<td>" . $row['MarathonID'] . "</td>";
                echo "<td>" . $row['RaceName'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td><a href='cancel_registration.php?entry_no=" . $row['EntryNO'] . "&marathon_id=" . $row['MarathonID'] . "' class='btn btn-danger'>Cancel</a></td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";

        // Table for competitions before today's date
        echo "<h3>Past Competitions</h3>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>
                <tr>
                    <th>Competition ID</th>
                    <th>Competition Name</th>
                    <th>Date</th>
                    <th>View Competition</th>
                </tr>
              </thead>";
        echo "<tbody>";

        // Reset the data pointer in the result set to display competitions before today
        $result->data_seek(0);

        while ($row = $result->fetch_assoc()) {
            if ($row['Date'] < $currentDate) {
                echo "<tr>";
                echo "<td>" . $row['MarathonID'] . "</td>";
                echo "<td>" . $row['RaceName'] . "</td>";
                echo "<td>" . $row['Date'] . "</td>";
                echo "<td><a href='view_competition.php?entry_no=" . $row['EntryNO'] . "&marathon_id=" . $row['MarathonID'] . "' class='btn btn-primary'>View</a></td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
        ?>
    <?php else : ?>
        <p>No competitions found for this user.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>