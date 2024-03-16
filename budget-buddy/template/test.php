<?php
/*
// Database connection

// Function to fetch notifications
function fetchNotifications()
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "vignesh_photogram";
    $conn = new mysqli($servername, $username, $password, $database);
    $username = Session::getUser()->getUsername();
    $sql = "SELECT * FROM notification_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to update notification action
function updateNotificationAction($id, $action, $bill_id, $reason, $image_path)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "vignesh_photogram";
    $conn = new mysqli($servername, $username, $password, $database);
    $username = Session::getUser()->getUsername();
    $sql =
        "INSERT INTO return_notification (action, bill_id, reason, image_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $action, $bill_id, $reason, $image_path);
    return $stmt->execute();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["accept"])) {
        $id = $_POST["notification_id"];
        $action = "accept";
        if (
            updateNotificationAction(
                $id,
                $action,
                $bill_id,
                $reason,
                $image_path
            )
        ) {
            // Process image upload
            $billId = $_POST["bill_id"];
            $imagePath = "uploads/" . basename($_FILES["image"]["name"]);
            move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);

            // Update notification table with image path and action
            $sql =
                "UPDATE notification_table SET action = ?, image_path = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $action, $imagePath, $id);
            $stmt->execute();
            echo "Notification accepted successfully.";
        } else {
            echo "Error updating notification.";
        }
    } elseif (isset($_POST["reject"])) {
        $id = $_POST["notification_id"];
        $action = "reject";
        if (updateNotificationAction($id, $action)) {
            echo "Notification rejected successfully.";
        } else {
            echo "Error updating notification.";
        }
    }
}
*/
?> <!--
<body>
    <h2>Notifications</h2>
    <ul>
    <?php
/*
    $notifications = fetchNotifications();
    foreach ($notifications as $notification) {
        echo "<li>{$notification["bill_title"]} - {$notification["bill_cost"]} <br>";
        echo "{$notification["note"]} <br>";
        echo "<form method='post' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='notification_id' value='{$notification["id"]}'>";
        echo "<input type='hidden' name='bill_id' value='{$notification["id"]}'>";
        echo "<input type='submit' name='accept' value='Accept'>";
        echo "<input type='submit' name='reject' value='Reject'>";
        echo "<input type='file' name='image'>";
        echo "</form>";
        echo "</li>";
        }*/
?>
    </ul>
    </body> -->
