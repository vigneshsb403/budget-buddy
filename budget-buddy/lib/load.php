<?php
// require "vendor/autoload.php";
include_once "includes/REST.class.php";
include_once "includes/API.class.php";
include_once "includes/Session.class.php";
include_once "includes/Mic.class.php";
include_once "includes/User.class.php";
include_once "includes/Database.class.php";
include_once "includes/UserSession.class.php";
include_once "includes/WebAPI.class.php";

function changecurrencyy($cur)
{
    $currencychangename = Session::getUser()->getUsername();
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } // Prepare SQL query
    $stmt = $conn->prepare("UPDATE auth SET currency = ? WHERE username = ?");

    // Bind parameters
    $stmt->bind_param("is", $cur, $currencychangename);

    // Execute statement
    if ($stmt->execute()) {
        // echo "Currency value updated successfully.";
    } else {
        // echo "Error updating currency value: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
function getcurrency($paramname)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("SELECT currency FROM auth WHERE username = ?");

    $stmt->bind_param("s", $paramname);
    $stmt->execute();
    $stmt->bind_result($rescurrency);
    $stmt->fetch(); // Fetch the result
    $stmt->close(); // Close the statement
    return $rescurrency;
}

function loadTemplate($name, $activeMenuItem = [])
{
    if ($activeMenuItem !== null) {
        extract($activeMenuItem);
    }
    include __DIR__ . "/../template/$name.php";
}
$wapi = new WebAPI();
$wapi->initiateSession();
?>
<?php function fetchTableData($period)
{
    $usernamee = Session::getUser()->getUsername();
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    switch ($period) {
        case "week":
            $startDate = date("Y-m-d", strtotime("monday this week"));
            $endDate = date("Y-m-d", strtotime("sunday this week"));
            break;
        case "month":
            $startDate = date("Y-m-01");
            $endDate = date("Y-m-t");
            break;
        case "year":
            $startDate = date("Y-01-01");
            $endDate = date("Y-12-31");
            break;
        case "history":
            $startDate = null;
            $endDate = null;
            break;
        default:
            die("Invalid period specified");
    }
    $sql = "SELECT * FROM expenditure_data";
    if (!is_null($startDate) && !is_null($endDate)) {
        $sql .= " WHERE date BETWEEN '$startDate' AND '$endDate' AND user_name = '$usernamee'";
    }
    $ifdivide = getcurrency($usernamee);
    echo "<script> console.log(" . $ifdivide . ")</script>";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table class='table table-striped table-sm'>";
        echo "<thead>
                <tr>
                  <th scope='col'>#</th>
                  <th scope='col'>Date</th>
                  <th scope='col'>Expenditure Amount</th>
                  <th scope='col'>Category</th>
                  <th scope='col'>Note</th>
                </tr>
              </thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            if ($ifdivide) {
                echo "<td> $" .
                    number_format($row["expenditure_amount"] / 78, 2) .
                    "</td>";
            } else {
                echo "<td> ₹" . $row["expenditure_amount"] . "</td>";
            }
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>" . $row["Note"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
} ?>

<?php
function fetchExpenditureDataa($table, $period)
{
    $usernamee = Session::getUser()->getUsername();
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $startDate = "";
    $endDate = "";
    switch ($period) {
        case "week":
            $startDate = date("Y-m-d", strtotime("monday this week"));
            $endDate = date("Y-m-d", strtotime("sunday this week"));
            $sql = "SELECT date, SUM(expenditure_amount) AS total_amount
                    FROM $table
                    WHERE date BETWEEN '$startDate' AND '$endDate'
                    AND user_name = '$usernamee'
                    GROUP BY date";
            break;
        case "month":
            $startDate = date("Y-m-01");
            $endDate = date("Y-m-t");
            $sql = "SELECT date, SUM(expenditure_amount) AS total_amount
                    FROM $table
                    WHERE date BETWEEN '$startDate' AND '$endDate'
                    AND user_name = '$usernamee'
                    GROUP BY date";
            break;
        case "year":
            $startDate = date("Y-01-01");
            $endDate = date("Y-12-31");
            $sql = "SELECT date, SUM(expenditure_amount) AS total_amount
                    FROM $table
                    WHERE date BETWEEN '$startDate' AND '$endDate'
                    AND user_name = '$usernamee' -- Apply username constraint
                    GROUP BY date";
            break;
        case "history":
            $sql = "SELECT date, SUM(expenditure_amount) AS total_amount
                FROM $table
                WHERE user_name = '$usernamee'
                GROUP BY date";
            break;
        default:
            $sql = "SELECT date, SUM(expenditure_amount) AS total_amount
                FROM $table
                WHERE user_name = '$usernamee'
                GROUP BY date";
    }
    $result = $conn->query($sql);
    $labels = [];
    $data = [];
    $ifdivide = getcurrency($usernamee);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $labels[] = $row["date"];
            $data[] = $ifdivide
                ? number_format($row["total_amount"] / 78, 2)
                : $row["total_amount"];
        }
    } else {
        echo "No data available for the specified period";
    }
    $conn->close();
    $chartData = [
        "labels" => $labels,
        "datasets" => [
            [
                "data" => $data,
                "lineTension" => 0,
                "backgroundColor" => "transparent",
                "borderColor" => "#007bff",
                "borderWidth" => 4,
                "pointBackgroundColor" => "#007bff",
            ],
        ],
    ];
    return json_encode($chartData);
}
function fetchExpenditureData($table, $period)
{
    $usernamee = Session::getUser()->getUsername();
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $startDate = "";
    $endDate = "";
    switch ($period) {
        case "week":
            $startDate = date("Y-m-d", strtotime("monday this week"));
            $endDate = date("Y-m-d", strtotime("sunday this week"));
            break;
        case "month":
            $startDate = date("Y-m-01");
            $endDate = date("Y-m-t");
            break;
        case "year":
            $startDate = date("Y-01-01");
            $endDate = date("Y-12-31");
            break;
        case "history": // No need to set start and end date for history
            break;
        default: // Default behavior
    } // Build SQL query based on period
    $sql = "SELECT date, SUM(expenditure_amount) AS total_amount, category
            FROM $table
            WHERE user_name = '$usernamee'";
    if ($period !== "history") {
        $sql .= " AND date BETWEEN '$startDate' AND '$endDate'";
    }
    $sql .= " GROUP BY date, category";
    $result = $conn->query($sql);
    $labels = [];
    $datasets = [];
    $ifdivide = getcurrency($usernamee); // Define colors for different categories
    $colors = [
        "food" => "#ff6384",
        "entertainment" => "#36a2eb",
        "business" => "#ffce56",
        "other" => "#ff7f0e",
    ];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $category = $row["category"];
            $label = $row["date"];
            $amount = $ifdivide
                ? number_format($row["total_amount"] / 78, 2)
                : $row["total_amount"]; // Add label if not already added
            if (!in_array($label, $labels)) {
                $labels[] = $label;
            } // Add dataset for the category
            if (!isset($datasets[$category])) {
                $datasets[$category] = [
                    "label" => $category,
                    "data" => [],
                    "backgroundColor" => $colors[$category],
                    "borderColor" => $colors[$category],
                    "borderWidth" => 4,
                    "pointBackgroundColor" => $colors[$category],
                    "lineTension" => 0,
                ];
            } // Add amount for the specific category dataset
            $datasets[$category]["data"][] = $amount;
        }
    } // Assemble chart data
    $chartData = [
        "labels" => $labels,
        "datasets" => array_values($datasets), // Resetting array keys to start from 0
    ];
    $conn->close();
    return json_encode($chartData);
}
function get_config($key, $default = null)
{
    global $__site_config;
    $json_config = '{
        "db_server": "db",
        "db_username": "root",
        "db_password": "example",
        "db_name": "budget_buddies",
        "base_path": "/",
        "upload_path": "/home/sibidharan/photogram_uploads/"
    }'; // $array = json_decode($json_config, true);
    $array = [
        "db_server" => "db",
        "db_username" => "root",
        "db_password" => "example",
        "db_name" => "budget_buddies",
        "base_path" => "/",
        "upload_path" => "/home/sibidharan/photogram_uploads/",
    ];
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}
function fetchUserContactInfo($usernameprofile)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } // Prepare SQL query
    $sql = "SELECT email, phone FROM auth WHERE username = ?";
    $stmt = $conn->prepare($sql);
    // Bind parameters and execute
    $stmt->bind_param("s", $usernameprofile);
    $stmt->execute(); // Bind result variables
    $stmt->bind_result($email, $phone); // Fetch result
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    return ["email" => $email, "phone" => $phone];
}
function getNotifications($usernamenotification)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM notification_table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usernamenotification);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    } // Close statement and connection
    $stmt->close();
    $conn->close();
    return $notifications;
}
function addExpenseToTable($date, $amount, $category, $note)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies";
    $usernamee = Session::getUser()->getUsername();
    $ifdivide = getcurrency($usernamee);
    $conn = new mysqli($servername, $username, $password, $database);
    $billllCost = $amount;
    if ($ifdivide == 1) {
        $billllCost = $amount * 78;
    } // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Prepare SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO expenditure_data (date, expenditure_amount, user_name, category, note) VALUES (?, ?, ?, ?, ?)"
    ); // Bind parameters
    $stmt->bind_param(
        "sdsss",
        $date,
        $billllCost,
        $usernamee,
        $category,
        $note
    ); // Execute statement
    $stmt->execute(); // Close statement and connection
    $stmt->close();
    $conn->close();
}
function deleteRecord($table, $condition, $params)
{
    // Database connection parameters
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget_buddies"; // Create connection
    $conn = new mysqli($servername, $username, $password, $database); // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } // Prepare the SQL statement with placeholders
    $sql = "DELETE FROM $table WHERE $condition";
    $stmt = $conn->prepare($sql);
    // Bind parameters if provided
    if (!empty($params)) {
        $stmt->bind_param(...$params);
    }
    // Execute the delete query
    if ($stmt->execute() === true) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    } // Close statement and connection
    $stmt->close();
    $conn->close();
}
function reCaptcha($recaptcha)
{
    $secret = "6LfImJspAAAAAEqch133KqHoQ3JGO43UMLEfNegP";
    $ip = $_SERVER["REMOTE_ADDR"];
    $postvars = [
        "secret" => $secret,
        "response" => $recaptcha,
        "remoteip" => $ip,
    ];
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);
    return json_decode($data, true);
}
 ?>
