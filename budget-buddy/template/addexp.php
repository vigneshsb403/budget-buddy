<body>

<div class="container mt-5">
  <h2>Add Expense</h2>
  <form class="needs-validation" novalidate method="post">
    <div class="form-group row">
      <label for="datepicker" class="col-sm-2 col-form-label">Select Date:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" id="datepicker" name="selectedDate" required>
        <div class="invalid-feedback">
          Valid date is required.
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="floatInput" class="col-sm-2 col-form-label">Enter Expense:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control" id="floatInput" name="expenseAmount" step="0.01" required>
        <div class="invalid-feedback">
          Valid expense amount is required.
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-10 offset-sm-2">
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
      </div>
    </div>
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
  // Initialize Datepicker
  $(document).ready(function(){
    $('#datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
  });
</script>

</body>
</html>

<?php
function addExpenseToTable($date, $amount)
{
    $servername = "db";
    $username = "root";
    $password = "example";
    $database = "budget-buddies";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare(
        "INSERT INTO expenditure_data (date, expenditure_amount) VALUES (?, ?)"
    );

    // Bind parameters
    $stmt->bind_param("sd", $date, $amount);

    // Execute statement
    $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();
}

// Check if form is submitted
if (isset($_POST["submit"])) {
    // Get form data
    $selectedDate = $_POST["selectedDate"];
    $expenseAmount = $_POST["expenseAmount"];

    // Call function to add expense to table
    addExpenseToTable($selectedDate, $expenseAmount);
    echo "<script>alert('expense added scussfully')</script>";
}


?>
