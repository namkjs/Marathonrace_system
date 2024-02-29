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
        echo "Username '$username' has already been registered.";
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
                echo "Registration successful!";
            } else {
                echo "Participant information insertion failed: " . $conn->error;
            }
        } else {
            echo "User registration failed: " . $conn->error;
        }
    }
}
?>
