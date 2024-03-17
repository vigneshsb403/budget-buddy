<?php
include "lib/load.php";
Session::ensureLogin();
loadTemplate("header", ["bills", "Budget buddy", "Budget buddy"]);
loadTemplate("billsplit");
// loadTemplate("test");
loadTemplate("footer");
?>
