<?php

$login_page = true;

//TODO: Redirect to a requested URL instead of base path on login_page
if (isset($_POST["email_address"]) and isset($_POST["password"])) {
    $email_address = $_POST["email_address"];
    $password = $_POST["password"];

    $result = UserSession::authenticate($email_address, $password);
    $login_page = false;
}

if (!$login_page) {
    if ($result) {

        $should_redirect = Session::get("_redirect");
        $redirect_to = get_config("base_path");
        if (isset($should_redirect)) {
            $redirect_to = $should_redirect;
            Session::set("_redirect", false);
        }
        ?>
<script>
	window.location.href = "<?= $redirect_to ?>"
</script>

<?php
    } else {
         ?>
<script>
	window.location.href = "/login?error=1"
</script>

<?php
    }
} else {
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
<main class="form-signin w-100 m-auto">
	<form method="post" action="/login">
		<h1 class="h3 mb-3 fw-normal">Please sign in</h1>
		<?php if (isset($_GET["error"])) { ?>
		<div class="alert alert-danger" role="alert">
			Invalid Credentials
		</div>
		<?php } ?>
		<div class="form-floating">
			<input name="email_address" type="text" class="form-control" id="floatingInput"
				placeholder="name@example.com">
			<label for="floatingInput">Email address or Username</label>
		</div>
		<div class="form-floating">
			<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
			<label for="floatingPassword">Password</label>
		</div>

		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" value="remember-me"> Remember me
			</label>
		</div>
		<button class="w-100 btn btn-lg btn-primary hvr-grow-rotate" type="submit">Sign in</button>
		<a href="/signup" class="w-100 btn btn-link">Not registered? Sign up</a>
	</form>
</main>
<!--
<main class="form-signin w-100 m-auto">
  <form>
    <img class="mb-4" src="../assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="form-check text-start my-3">
      <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
      <label class="form-check-label" for="flexCheckDefault">
        Remember me
      </label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
  </form>
</main>
-->
<?php
}
?>
