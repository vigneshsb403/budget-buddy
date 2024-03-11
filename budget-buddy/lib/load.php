<?php
function loadTemplate($name, $activeMenuItem = [])
{
    if ($activeMenuItem !== null) {
        extract($activeMenuItem);
    }
    include __DIR__ . "/../template/$name.php";
} ?>
<?php function fetchOptionsFromDatabaseee($table_name)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $dbname = "iniya_systems";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } // SQL query to retrieve data from the table
    $sql = "SELECT Name, Price FROM $table_name";
    $result = $conn->query($sql);
    $options = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $options .=
                "<option value='" .
                $row["Name"] .
                "'>" .
                $row["Name"] .
                " - ₹" .
                $row["Price"] .
                "</option>";
        }
    } else {
        $options = "0 results";
    }
    $conn->close();
    return $options;
} ?>
