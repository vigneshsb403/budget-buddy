<?php
// Connect to the database
include "lib/load.php";
$servername = "db";
$usernamee = "root";
$password = "example";
$database = "vignesh_photogram";
$conn = new mysqli($servername, $usernamee, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get bill data from the request
$data = json_decode(file_get_contents("php://input"), true);
$billTitle = $data["billTitle"];
$billCost = $data["splitAmount"];
$note = $data["note"];
$usernames = $data["usernames"];
$creatername = Session::getUser()->getUsername();

// Prepare SQL query to check if all usernames are available in the auth table
$sql =
    "SELECT username FROM auth WHERE username IN ('" .
    implode("','", $usernames) .
    "')";
$result = $conn->query($sql);
// Check if all usernames are valid
if ($result->num_rows === count($usernames)) {
    // All usernames are valid, proceed to add the bill to the notification table

    // Prepare SQL statement to add the bill to the notification table
    $stmt = $conn->prepare(
        "INSERT INTO notification_table (bill_title, bill_cost, note, username, created_by) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "sdsss",
        $billTitle,
        $billCost,
        $note,
        $username,
        $creatername
    );

    // Insert the bill for each username
    foreach ($usernames as $username) {
        $stmt->execute();
    }

    // Close statement
    $stmt->close();

    // Send success response
    http_response_code(200);
    echo json_encode(["message" => "Bill added successfully!"]);
} else {
    // Invalid usernames found, send error response
    http_response_code(400);
    echo json_encode(["error" => "One or more usernames are invalid."]);
}

// Close connection
$conn->close();
?>