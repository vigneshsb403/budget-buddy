<?php
include "lib/load.php";
Session::ensureLogin();
loadTemplate("header", ["tracker", "Budget buddy", "Budget buddy"]);
loadTemplate("dashboard");
loadTemplate("footer");
?>
