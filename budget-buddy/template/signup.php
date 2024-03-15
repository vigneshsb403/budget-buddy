<?php

$signup = false;
if (
    isset($_POST["username"]) and
    isset($_POST["password"]) and
    !empty($_POST["password"]) and
    isset($_POST["email_address"]) and
    isset($_POST["phone"])
) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email_address"];
    $phone = $_POST["phone"];
    $error = User::signup($username, $password, $email, $phone);
    $signup = true;
}
?>
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
<?php if ($signup) {
    if ($error) { ?>
<main class="container">
	<div class="p-5 rounded mt-3">
		<h1>Signup Success</h1>
		<p class="lead">Now you can login from <a
				href="<?= get_config("base_path") ?>login">here</a>.
		</p>

	</div>
</main>
<?php } else { ?>
<main class="container">
	<div class="p-5 rounded mt-3">
		<h1>Signup Fail</h1>
		<p class="lead">Something went wrong, <?= $error ?>
		</p>
	</div>
</main>
<?php }
} else {
     ?>
<main class="form-signin w-100 m-auto">
	<form method="post" action="signup">
		<h1 class="h3 mb-3 fw-normal">Sign up</h1>
		<div class="form-floating">
			<input name="username" type="text" class="form-control" id="floatingInputUsername"
				placeholder="name@example.com">
			<label for="floatingInputUsername">Username</label>
		</div>
		<div class="form-floating">
			<input name="phone" type="text" class="form-control" id="floatingInputUsername"
				placeholder="name@example.com">
			<label for="floatingInputUsername">Phone</label>
		</div>
		<div class="form-floating">
			<input name="email_address" type="email" class="form-control" id="floatingInput"
				placeholder="name@example.com">
			<label for="floatingInput">Email address</label>
		</div>
		<div class="form-floating">
			<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
			<label for="floatingPassword">Password</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary hvr-grow-rotate" type="submit">Sign up</button>
	</form>
</main>
<?php
}
?>
