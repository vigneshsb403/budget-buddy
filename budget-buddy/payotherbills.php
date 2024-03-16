<?php
include "lib/load.php";
loadTemplate("header", ["login", "Budget buddy", "Budget buddy"]);
if (
    $_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST["bill_id"]) &&
    isset($_POST["bill_cost"]) &&
    isset($_POST["created_at"])
) {
    $bill_title = $_POST["bill_id"];
    $bill_cost = $_POST["bill_cost"];
    $created_at = $_POST["created_at"];
    $usernamepaybills = Session::getUser()->getUsername();
    echo '<div class="container py-4">';
    echo "Bill Title: $bill_title<br>";
    echo "Bill Cost: $bill_cost<br>";
    $unixTimestamp = strtotime($created_at);
    $date = date("Y-m-d", $unixTimestamp);
    echo "Converted Date: $date";
    addExpenseToTable($date, $bill_cost);
    $condition = "username = ? AND id = ?";
    $params = ["ss", $usernamepaybills, $bill_title];
    deleteRecord("notification_table", $condition, $params);

    echo "<br>bill added as expense.</div>";
} else {
    echo "Invalid request.";
}
?>
