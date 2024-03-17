<?php
include "lib/load.php";
loadTemplate("header", ["success", "Budget buddy", "Budget buddy"]);
if (isset($_GET["message"])) {
    if ($_GET["message"] == "success") {?>
    <main class="container">
	<div class="p-5 rounded mt-3">
		<h1>Bill added!</h1>
		<p class="lead">Add a new bill <a
				href="<?= get_config("base_path") ?>bills">here</a>.
		</p>

	</div>
    </main>
    <?
    } else { ?>
    <main class="container">
	<div class="p-5 rounded mt-3">
		<h1>bill not addded</h1>
		<p class="lead">Something went wrong, try again. <a href="<?= get_config("base_path") ?>bills">here</a>.
		</p>
	</div>
    </main>
    <?
    }
}
loadTemplate("footer");
?>
