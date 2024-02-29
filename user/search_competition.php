<?php
session_start();
require_once(__DIR__ . '/../config.php'); // Include database connection
include('../includes/loggedin.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_term = $_GET['search'];
    // Truy vấn cơ sở dữ liệu với MarathonID hoặc RaceName
    $query = "SELECT * FROM marathon WHERE MarathonID = '$search_term' OR RaceName LIKE '%$search_term%'";
    $result = $conn->query($query);
}
// ... (your existing code for search goes here)

echo "<div class='container mt-4'>";
if ($result && $result->num_rows > 0) {
    echo "<h2>Search Results</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead>
            <tr>
                <th>Marathon ID</th>
                <th>Race Name</th>
                <!-- Add more columns if needed -->
            </tr>
          </thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['MarathonID'] . "</td>";
        echo "<td>" . $row['RaceName'] . "</td>";
        // Add more columns if needed
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>Không tìm thấy cuộc thi phù hợp.</p>";
}
echo "</div>";
