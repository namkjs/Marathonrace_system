<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hanoi International Marathon</title>
    <link rel="stylesheet" href="assets/css/home.css">

</head>

<body>

    <?php
    session_start();

    if (isset($_SESSION['username'])) {
        include('../includes/loggedin.php');
    } else {
        include('../includes/header.php');
    }
    ?>

    <!-- Phần chính của trang -->
    <div class="main-content">
        <div class="background">
            <div class="overlay">
                <div class="content">
                    <h1>Hanoi International Marathon</h1>
                </div>
            </div>
        </div>
    </div>

</body>

</html>