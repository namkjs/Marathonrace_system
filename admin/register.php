<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
</head>

<body>
<?php include('../includes/header.php'); ?>
    <h2>User Registration</h2>
    <form action="registration_process.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>
