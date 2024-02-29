<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Competitions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yTUwEX806i49zWLc2Ol8shF0Pz/EuGv1/QIXyOst/d7/2Xv7p3zKHc9k2lC" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <hr>
    <?php
      // Include the database connection file (config.php)
      require_once(__DIR__ . '/../config.php'); // Include database connection

      // Fetch competitions from the database
      $query = "SELECT * FROM marathon ORDER BY Date DESC"; // Sắp xếp theo cột 'Date' từ mới đến cũ
      $result = $conn->query($query);

      if ($result->num_rows > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Competition ID</th>";
        echo "<th scope='col'>Competition Name</th>";
        echo "<th scope='col'>Time of Event</th>";
        echo "<th scope='col'>Edit</th>";
        echo "<th scope='col'>Delete</th>"; // New column for Delete
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row['MarathonID'] . "</td>";
          echo "<td>" . $row['RaceName'] . "</td>";
          echo "<td>" . $row['Date'] . "</td>";
          echo "<td><a href='edit_competition.php?id=" . $row['MarathonID'] . "' class='btn btn-primary'>Edit</a></td>";
          echo "<td><a href='delete_competition.php?id=" . $row['MarathonID'] . "' class='btn btn-danger'>Delete</a></td>"; // Delete button
          echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "<a href='registation_form.php' class='btn btn-success'>Register a Competition</a>";
      } else {
        echo "<p class='alert alert-warning'>No competitions found.</p>";
      }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJDnf/hN/j3FcaReoSB59Bw/tPX2l1RVjfwWq7nZYOp0gKD4+PW78k/jbdXIGy" crossorigin="anonymous"></script>
</body>
</html>
