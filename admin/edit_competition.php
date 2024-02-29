<?php
require_once(__DIR__ . '/../config.php');
include('../includes/loggedin_admin.php');

if (isset($_GET['id'])) {
    $competition_id = $_GET['id'];
    $query = "SELECT * FROM marathon WHERE MarathonID = $competition_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $competition = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Competition</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Optional: Add your custom stylesheets or additional Bootstrap CSS here -->
</head>

<body>
    <div class="container mt-4">
        <h2>Edit Competition</h2>
        <form action="update_competition.php" method="post" class="row g-3 needs-validation" novalidate>
            <input type="hidden" name="competition_id" value="<?= $competition['MarathonID'] ?>">

            <div class="col-md-6 mb-3">
                <label for="competition_name" class="form-label">Competition Name:</label>
                <input type="text" class="form-control" id="competition_name" name="competition_name" value="<?= $competition['RaceName'] ?>" required>
                <div class="invalid-feedback">Please enter a valid competition name.</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="time_of_event" class="form-label">Time of Event:</label>
                <input type="text" class="form-control" id="time_of_event" name="time_of_event" value="<?= $competition['Date'] ?>" required>
                <div class="invalid-feedback">Please enter a valid time of event.</div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-primary ms-2" onclick="window.location.href='show_participant.php?competition_id=<?= $competition_id ?>'">Show Participants</button>
            <button type="button" class="btn btn-primary ms-2" onclick="window.location.href='edit_result.php?competition_id=<?= $competition_id ?>'">Edit Results</button>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Optional: Add your custom scripts or additional Bootstrap JS here -->
</body>

</html>

<?php
    } else {
        echo "Competition not found.";
    }
} else {
    echo "Invalid competition ID.";
}
?>
