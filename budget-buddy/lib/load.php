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
    $database = "vignesh_photogram";
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
    $database = "vignesh_photogram";
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
    $database = "vignesh_photogram";
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
function fetchExpenditureData($table, $period)
{
    $usernamee = Session::getUser()->getUsername();
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "vignesh_photogram";
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
function get_config($key, $default = null)
{
    global $__site_config;
    $json_config = '{
        "db_server": "db",
        "db_username": "root",
        "db_password": "example",
        "db_name": "vignesh_photogram",
        "base_path": "/",
        "upload_path": "/home/sibidharan/photogram_uploads/"
    }'; // $array = json_decode($json_config, true);
    $array = [
        "db_server" => "db",
        "db_username" => "root",
        "db_password" => "example",
        "db_name" => "vignesh_photogram",
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
    $database = "vignesh_photogram";
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
    $database = "vignesh_photogram";
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
function addExpenseToTable($date, $amount)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "vignesh_photogram";
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
        "INSERT INTO expenditure_data (date, expenditure_amount, user_name) VALUES (?, ?, ?)"
    ); // Bind parameters
    $stmt->bind_param("sds", $date, $billllCost, $usernamee); // Execute statement
    $stmt->execute(); // Close statement and connection
    $stmt->close();
    $conn->close();
}
 ?>
