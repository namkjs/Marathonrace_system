<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Competition Registration Form</title>
</head>
<body>
    <?php include('../includes/loggedin_admin.php'); ?>

    <div class="container mt-4">

        <h2>Competition Registration Form</h2>

        <form action="register_competition.php" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="competition_id" class="form-label">Competition ID:</label>
                <input type="text" class="form-control" id="competition_id" name="competition_id" required>
                <div class="invalid-feedback">Please enter a valid competition ID.</div>
            </div>

            <div class="mb-3">
                <label for="competition_name" class="form-label">Competition Name:</label>
                <input type="text" class="form-control" id="competition_name" name="competition_name" required>
                <div class="invalid-feedback">Please enter a valid competition name.</div>
            </div>

            <div class="mb-3">
                <label for="time_of_event" class="form-label">Time of Event:</label>
                <input type="datetime-local" class="form-control" id="time_of_event" name="time_of_event" required>
                <div class="invalid-feedback">Please select a valid time of event.</div>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <div class="container mt-4">
            <?php 
            if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error']; ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJDnf/hN/j3FcaReoSB59Bw/tPX2l1RVjfwWq7nZYOp0gKD4+PW78k/jbdXIGy" crossorigin="anonymous"></script>
</body>
</html>
