<?php
include "lib/load.php";
Session::ensureLogin();
loadTemplate("header", ["addexp", "Budget buddy", "Budget buddy"]);
loadTemplate("addexp");
loadTemplate("footer");
?>
