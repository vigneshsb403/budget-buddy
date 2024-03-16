<?php
include "lib/load.php";
Session::ensureLogin();
loadTemplate("header", ["settings", "Budget buddy", "Budget buddy"]);
loadTemplate("settings");
loadTemplate("footer");
?>
