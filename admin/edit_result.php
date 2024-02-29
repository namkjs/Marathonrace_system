<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if competition ID is passed from previous page
if (!isset($_GET['competition_id'])) {
    echo "Missing competition ID.";
    exit();
} else {
    $competition_id = $_GET['competition_id'];
}

// Get competition details from database
$query_competition = "SELECT * FROM marathon WHERE MarathonID=$competition_id";
$result_competition = $conn->query($query_competition);

if (!$result_competition || $result_competition->num_rows == 0) {
    echo "Competition not found.";
    exit();
} else {
    $competition = $result_competition->fetch_assoc();
}

// Get list of competition participants and store in an array
$query_participants = "SELECT participate.*, participant.Name FROM participate 
                        INNER JOIN participant ON participate.UserID = participant.UserID 
                        WHERE participate.MarathonID=$competition_id
                        ORDER BY participate.Standings ASC"; // Sort by Standings

$result_participants = $conn->query($query_participants);

$participants_data = []; // Array to store participant details

if ($result_participants && $result_participants->num_rows > 0) {
    while ($participant = $result_participants->fetch_assoc()) {
        $participants_data[] = $participant;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Results - <?php echo $competition['RaceName']; ?></title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include('../includes/loggedin_admin.php'); ?>

    <div class="container mt-4">
        <h1>Edit Results - <?php echo $competition['RaceName']; ?></h1>
        <?php if (!empty($participants_data)) : ?>
            <form action="update_results.php" method="post">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Participant ID</th>
                            <th>Marathon ID</th>
                            <th>Name</th>
                            <th>Time Record</th>
                            <th>Standings</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($participants_data as $participant) : ?>
                            <tr>
                                <td><?php echo $participant['EntryNO']; ?></td>
                                <td><?php echo $participant['MarathonID']; ?></td>
                                <td><?php echo $participant['Name']; ?></td>
                                <td><input type="text" name="time_record_<?php echo $participant['EntryNO']; ?>" id="time_record_<?php echo $participant['EntryNO']; ?>" value="<?php echo $participant['TimeRecord']; ?>"></td>
                                <td><input type="text" name="standings_<?php echo $participant['EntryNO']; ?>" id="standings_<?php echo $participant['EntryNO']; ?>" value="<?php echo $participant['Standings']; ?>" disabled></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <input type="hidden" name="competition_id" value="<?php echo $competition_id; ?>">
                <input type="submit" class="btn btn-primary" value="Update Results">
            </form>
        <?php else : ?>
            <p>No participants found for this competition.</p>
        <?php endif; ?>

        <a href="home.php" class="btn btn-secondary mt-3">Back to Home</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
