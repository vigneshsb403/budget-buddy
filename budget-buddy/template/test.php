<?php
// Assuming you have already established a database connection
$hacker = Session::getUser()->getUsername();
$servername = "db";
$username = "root";
$password = "example";
$database = "vignesh_photogram";
$conn = new mysqli($servername, $username, $password, $database);
$sql = "SELECT id, bill_title, bill_cost, note, username, created_at, created_by FROM notification_table WHERE username = '$hacker'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>Bill Title: " . $row["bill_title"] . "</h3>";
        echo "<p>Bill Cost: $" . $row["bill_cost"] . "</p>";
        echo "<p>Note: " . $row["note"] . "</p>";
        echo "<p>Username: " . $row["username"] . "</p>";
        echo "<p>Created At: " . $row["created_at"] . "</p>";
        echo "<p>Created By: " . $row["created_by"] . "</p>";

        // Form to accept or reject the bill
        echo "<form action='process_response.php' method='post'>";
        echo "<input type='hidden' name='notification_id' value='" .
            $row["id"] .
            "'>";
        echo "<label for='accept'>Accept</label>";
        echo "<input type='radio' id='accept' name='action' value='accept'>";
        echo "<label for='reject'>Reject</label>";
        echo "<input type='radio' id='reject' name='action' value='reject'>";
        echo "<button type='submit'>Submit</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
