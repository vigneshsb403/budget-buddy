<?php

//include "lib/load.php";
// echo "Hello world";
//if (Session::isAuthenticated()) {
//    header("Location: /");
//    die();
// }
//Session::renderPage();
// header("Location: /")
// echo "<h1>this is login page</h1>";

include "lib/load.php";
loadTemplate("header", ["login", "Budget buddy", "Budget buddy"]);
loadTemplate("login");
loadTemplate("footer");
?>
