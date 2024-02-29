<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit();
}

$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Xóa thông báo lỗi trong session sau khi hiển thị

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
    // Thêm các trường thông tin khác từ bảng Participant
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include('../includes/loggedin.php'); ?>

    <div class="container mt-4">
        <h1>Edit Profile</h1>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="update_profile.php" method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $name; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="nationality" class="form-label">Nationality:</label>
                                <select id="nationality" name="nationality" class="form-select">
                                    <option value="">Select Nationality</option>
                                    <!-- Options will be added by JavaScript -->
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="sex" class="form-label">Sex:</label>
                                <select id="sex" name="sex" class="form-select">
                                    <option value="Male" <?php if ($sex == 'Male') echo 'selected'; ?>>Male</option>
                                    <option value="Female" <?php if ($sex == 'Female') echo 'selected'; ?>>Female</option>
                                    <option value="Other" <?php if ($sex == 'Other') echo 'selected'; ?>>Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Age:</label>
                                <input type="number" id="age" name="age" class="form-control" value="<?php echo $age; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="marathon_best_record" class="form-label">Marathon Best Record: (hh:mm:ss)</label>
                                <input type="text" id="marathon_best_record" name="marathon_best_record" class="form-control" value="<?php echo $marathon_best_record; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="passport_no" class="form-label">Passport No:</label>
                                <input type="text" id="passport_no" name="passport_no" class="form-control" value="<?php echo $passport_no; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address:</label>
                                <input type="text" id="address" name="address" class="form-control" value="<?php echo $address; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone:</label>
                                <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $phone; ?>">
                            </div>

                            <!-- Add other fields from the Participant table here -->

                            <input type="submit" value="Save Changes" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Call API to get country data
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {
                // Sort countries alphabetically
                data.sort((a, b) => {
                    const countryA = a.name.common.toUpperCase();
                    const countryB = b.name.common.toUpperCase();
                    if (countryA < countryB) {
                        return -1;
                    }
                    if (countryA > countryB) {
                        return 1;
                    }
                    return 0;
                });

                const nationalitySelect = document.getElementById('nationality');
                data.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country.name.common;
                    option.textContent = country.name.common;
                    nationalitySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    </script>

</body>
</html>
