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

// Hiển thị form chỉnh sửa thông tin cá nhân
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!-- Custom styles -->
    <style>
        .gradient-custom {
            background: linear-gradient(to right, #667eea, #764ba2);
        }
    </style>
</head>
<body>
<?php include('../includes/loggedin.php'); ?>

<section class="vh-100" style="background-color: #f4f5f7;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-lg-6 mb-4 mb-lg-0">
        <div class="card mb-3" style="border-radius: .5rem;">
          <div class="row g-0">
            <div class="col-md-4 gradient-custom text-center text-white"
              style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
              <!-- Placeholder for user avatar -->
              <img src="./assets/img/avatar.png"
                alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
              <h5><?php echo $name; ?></h5>
              <p><?php echo $nationality; ?></p>
              <i class="far fa-edit mb-5"></i>
            </div>
            <div class="col-md-8">
              <div class="card-body p-4">
                <h6>Information</h6>
                <hr class="mt-0 mb-4">
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Email</h6>
                    <p class="text-muted"><?php echo $email; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Phone</h6>
                    <p class="text-muted"><?php echo $phone; ?></p>
                  </div>
                </div>
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Gender</h6>
                    <p class="text-muted"><?php echo $sex; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Nationality</h6>
                    <p class="text-muted"><?php echo $nationality; ?></p>
                  </div>
                </div>
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Age</h6>
                    <p class="text-muted"><?php echo $age; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Best Record</h6>
                    <p class="text-muted"><?php echo $marathon_best_record; ?></p>
                  </div>
                </div>
                <div class="row pt-1">
                  <div class="col-6 mb-3">
                    <h6>Passport No</h6>
                    <p class="text-muted"><?php echo $passport_no; ?></p>
                  </div>
                  <div class="col-6 mb-3">
                    <h6>Address</h6>
                    <p class="text-muted"><?php echo $address; ?></p>
                  </div>
                </div>
                <div class="d-flex justify-content-start">
                  <!-- Add social media icons here -->
                  <a href="https://www.facebook.com/"><i class="fab fa-facebook-f fa-lg me-3"></i></a>
                  <a href="instaragram.com"><i class="fab fa-twitter fa-lg me-3"></i></a>
                  <a href="/instaragam.com"><i class="fab fa-instagram fa-lg"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
