<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include('includes/header.php'); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title text-center">User Registration</h2>
                        <?php
                        require_once(__DIR__ . '/config.php'); // Include database connection

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $username = $_POST['username'];
                            $password = $_POST['password']; // Remember to hash passwords securely

                            // Check if the username already exists in the database
                            $checkUserQuery = "SELECT Username FROM User WHERE Username = '$username'";
                            $checkResult = $conn->query($checkUserQuery);

                            if ($checkResult->num_rows > 0) {
                                // Username already exists
                                echo "<p class='alert alert-danger'>Username '$username' has already been registered.</p>";
                            } else {
                                $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

                                // Insert user details into the User table
                                $insertUserQuery = "INSERT INTO User (Username, Password, is_admin) VALUES ('$username', '$hashed_password', FALSE)";
                                $result = $conn->query($insertUserQuery);

                                if ($result) {
                                    // Get the UserID of the newly created user
                                    $newUserID = $conn->insert_id;

                                    // Insert default participant information into the Participant table with UserID
                                    $insertParticipantQuery = "INSERT INTO Participant (UserID) VALUES ('$newUserID')";
                                    $participantResult = $conn->query($insertParticipantQuery);

                                    if ($participantResult) {
                                        echo "<p class='alert alert-success'>Registration successful!</p>";
                                    } else {
                                        echo "<p class='alert alert-danger'>Participant information insertion failed: " . $conn->error . "</p>";
                                    }
                                } else {
                                    echo "<p class='alert alert-danger'>User registration failed: " . $conn->error . "</p>";
                                }
                            }
                        }
                        ?>
                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <input type="submit" value="Register" class="btn btn-primary btn-block">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
