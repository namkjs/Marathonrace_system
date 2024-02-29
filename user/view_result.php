<?php
// Include the database connection file (config.php)
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra nếu không có ID cuộc thi được chuyển từ trang trước
if (!isset($_GET['marathon_id'])) {
    echo "Missing marathon ID.";
    exit();
} else {
    $marathonID = $_GET['marathon_id'];
}

// Lấy thông tin cơ bản của người tham gia cuộc thi từ bảng Participants
$query = "SELECT participate.EntryNO, participant.Name, participate.TimeRecord, participate.Standings 
          FROM participate 
          INNER JOIN participant ON participate.UserID = participant.UserID 
          WHERE participate.MarathonID = $marathonID 
          ORDER BY participate.Standings ASC"; // Sắp xếp theo thứ tự đến đích

$result = $conn->query($query);
include('../includes/loggedin.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Results</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php if ($result->num_rows > 0) : ?>
        <h2>Participant Results</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Entry Number</th>
                        <th>Name</th>
                        <th>Time Record</th>
                        <th>Standings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row['EntryNO']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['TimeRecord']; ?></td>
                            <td><?php echo $row['Standings']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>No participant results found for this competition.</p>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
