<?php
// Assuming you have established a database connection
include "lib/load.php";
$hacker = Session::getUser()->getUsername();
$servername = "db";
$username = "root";
$password = "example";
$database = "vignesh_photogram";
$conn = new mysqli($servername, $username, $password, $database);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if notification_id and action are set in POST data
    if (isset($_POST["notification_id"]) && isset($_POST["action"])) {
        $notification_id = $_POST["notification_id"];
        $action = $_POST["action"];

        // Get the notification details from notification_table
        $sql = "SELECT * FROM notification_table WHERE id = $notification_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $bill_id = $row["id"];
            $reason = ""; // Initialize reason to empty

            // If action is reject, set the reason from user input
            if ($action == "reject" && isset($_POST["reason"])) {
                $reason = $_POST["reason"];
            }

            // Insert the response into response_notification table
            $sql_response = "INSERT INTO response_notification (bill_id, action, reason) VALUES ('$bill_id', '$action', '$reason')";
            if ($conn->query($sql_response) === true) {
                echo "Response recorded successfully.";
            } else {
                echo "Error: " . $sql_response . "<br>" . $conn->error;
            }
        } else {
            echo "Notification not found.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "Method not allowed.";
}

// Close the database connection
$conn->close();
?>
