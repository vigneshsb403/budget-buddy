<?php
include "lib/load.php";
Session::ensureLogin();
loadTemplate("header", ["profile", "Budget buddy", "Budget buddy"]);
loadTemplate("profile");
loadTemplate("footer");
?>
