<?php
// Check if the request method is POST and if the 'bill_id' parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bill_id"])) {
    // Get the bill_id from the POST request
    $bill_id = $_POST["bill_id"];

    // Proceed with further processing
    // For example, you can perform database operations, payment processing, etc.
    // Here, we're just printing a message for demonstration purposes
    echo "Bill with ID $bill_id is being paid.";
    // Add your payment processing logic here
} else {
    // If 'bill_id' parameter is not set or if the request method is not POST, do nothing or handle the error accordingly
    // You can redirect the user to an error page, display an error message, etc.
    echo "Invalid request.";
}
?>
