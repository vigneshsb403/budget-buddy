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
          <label for="noteInput" class="col-sm-2 col-form-label">Note:</label>
          <div class="col-sm-4">
            <textarea class="form-control" id="noteInput" name="expenseNote" rows="3"></textarea>
          </div>
        </div>
        <div class="form-group row align-items-end"> <!-- Updated class -->
          <label for="categoryselect" class="col-sm-2 col-form-label">Select Category:</label> <!-- Updated class -->
          <div class="col-sm-4">
            <select class="form-select" id="categoryselect" name="categoryselect">
              <option selected>Open this select menu</option>
              <option value="food">Food</option>
              <option value="entertainment">Entertainment</option>
              <option value="business">Business</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>
        <br>
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
  $(document).ready(function(){
    $('#datepicker').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });
  });
</script>

</body>
<?php
$hacked = 0;
if (isset($_POST["submit"])) {
    $selectedDate = $_POST["selectedDate"];
    $expenseAmount = $_POST["expenseAmount"];
    $category = $_POST["categoryselect"];
    $note = $_POST["expenseNote"];
    addExpenseToTable($selectedDate, $expenseAmount, $category, $note);
    echo "<script>alert('expense added scussfully')</script>";
} else {
    if ($hacked) {
        echo "<script>alert('expense not added')</script>";
        $hacked = $hacked + 1;
    } else {
        $hacked = $hacked + 1;
    }
}


?>
