<?php
include "lib/load.php";
loadTemplate("header", ["login", "Budget buddy", "Budget buddy"]);
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["bill_title"]) &&
    isset($_POST["bill_cost"]) &&
    isset($_POST["created_at"])
) {
    // Get the data from the POST request
    $bill_title = $_POST["bill_title"];
    $bill_cost = $_POST["bill_cost"];
    $created_at = $_POST["created_at"];

    // Additional processing here, such as payment processing

    // Example: Get the current user's username
    $usernamepaybills = Session::getUser()->getUsername();
    echo '<div class="container py-4">';
    echo "Bill Title: $bill_title<br>";
    echo "Bill Cost: $bill_cost<br>";
    $unixTimestamp = strtotime($created_at);
    $date = date("Y-m-d", $unixTimestamp);
    echo "Converted Date: $date";
    addExpenseToTable($date, $bill_cost);
    echo "<br>bill added as expense.</div>";
} else {
    echo "Invalid request.";
}
?>
