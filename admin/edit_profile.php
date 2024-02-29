<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}


$username = $_SESSION['username'];
$id = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($id);
$row = $result->fetch_assoc();
$userID = $row['UserID'];
// Lấy thông tin người dùng từ cơ sở dữ liệu
$query = "SELECT * FROM participant WHERE UserID= '$userID'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['Name'];
    $nationality = $row['Nationality'];
    $sex = $row['Sex'];
    $age = $row['Age'];
    $marathon_best_record = $row['BestRecord'];
    $passport_no = $row['PassportNO'];
    $address = $row['Address'];
    $email = $row['Email'];
    $phone = $row['Phone'];
} else {
    // Hiển thị form để người dùng nhập thông tin mới
    $name = '';
    $nationality = '';
    $sex = '';
    $age = '';
    $marathon_best_record = '';
    $passport_no = '';
    $address = '';
    $email = '';
    $phone = '';
    // Khai báo các trường thông tin khác với giá trị rỗng
}

// Hiển thị form chỉnh sửa thông tin cá nhân
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('../includes/loggedin_admin.php'); ?>

    <h1>Edit Profile</h1>

    <form action="update_profile.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>"><br>

        <label for="nationality">Nationality:</label>
        <input type="text" id="nationality" name="nationality" value="<?php echo $nationality; ?>"><br>

        <label for="sex">Sex:</label>
        <select id="sex" name="sex">
            <option value="Male" <?php if ($sex == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($sex == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($sex == 'Other') echo 'selected'; ?>>Other</option>
        </select><br>


        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?php echo $age; ?>"><br>

        <label for="marathon_best_record">Marathon Best Record:</label>
        <input type="text" id="marathon_best_record" name="marathon_best_record" value="<?php echo $marathon_best_record; ?>"><br>

        <label for="passport_no">Passport No:</label>
        <input type="text" id="passport_no" name="passport_no" value="<?php echo $passport_no; ?>"><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo $address; ?>"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>"><br>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>"><br>


        <!-- Thêm các trường thông tin khác từ bảng Participant -->

        <input type="submit" value="Save Changes">
    </form>
</body>
</html>
