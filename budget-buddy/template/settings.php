<?php
if (isset($_POST["currencyselect"])) {
    $currency = $_POST["currencyselect"];
    changecurrencyy($currency);
    echo "<script>alert('Currency type changed')</script>";
} ?>
<style>
html,
body {
    height: 100%;
}

.form-signin {
    max-width: 330px;
    padding: 1rem;
}

.form-signin .form-floating:focus-within {
    z-index: 2;
}

.form-signin input[type="email"] {
    margin-bottom: -1px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
}

.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
<form method="post" action="/settings">
<main class="form-signin w-100 m-auto">
    <div class="mb-3">
        <label for="currencyselect" class="form-label">Select Currency</label>
        <select class="form-select" id="currencyselect" name="currencyselect">
            <option selected>Open this select menu</option>
            <option value="1">USD</option>
            <option value="0">INR</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</main>
</form>
