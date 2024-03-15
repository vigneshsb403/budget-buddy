<!--	<?php if (Session::$isError) {
    Session::loadTemplate("_error");
} else {
    Session::loadTemplate(Session::currentScript());
} ?>
	<script>
		// Initialize the agent at application startup.
		const fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
			.then(FingerprintJS => FingerprintJS.load())

		// Get the visitor identifier when you need it.
		fpPromise
			.then(fp => fp.get())
			.then(result => {
				// This is the visitor identifier:
				const visitorId = result.visitorId
				// console.log(visitorId)
				// $('#fingerprint').val(visitorId);
				// set a cookie
				setCookie('fingerprint', visitorId, 1);
			})
	</script>
-->


	<!doctype html>
<html lang="en">
<?php Session::loadTemplate("_head"); ?>

<body>

		<?php Session::loadTemplate("_header", [
      "home",
      "Budget buddy",
      "Budget buddy",
  ]); ?>
		<main id="mainel">
			<?php if (Session::$isError) {
       Session::loadTemplate("_error");
   } else {
       // Session::loadTemplate(Session::currentScript());
   } ?>
		</main>
		<?php Session::loadTemplate("_footer"); ?>

		<!-- This is used as a dummy to clone further dialogs -->
		<div id="modalsGarbage">
			<div class="modal fade animate__animated" id="dummy-dialog-modal" tabindex="-1" role="dialog" aria-labelledby=""
				aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
					<div class="modal-content blur" style="box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px">
						<div class="modal-header">
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body">
						</div>
						<div class="modal-footer">
						</div>
					</div>
				</div>
			</div>
		</div>

		<script
			src="<?= get_config("base_path") ?>assets/dist/js/bootstrap.bundle.min.js">
		</script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
			integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous">
		</script>
		<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
		<script src="/js/app.min.js"></script>
		<script src="/js/dialog.js"></script>
		<script src="/js/toast.js"></script>
		<script>
			// Initialize the agent at application startup.
			const fpPromise = import('https://openfpcdn.io/fingerprintjs/v3')
				.then(FingerprintJS => FingerprintJS.load())

			// Get the visitor identifier when you need it.
			fpPromise
				.then(fp => fp.get())
				.then(result => {
					// This is the visitor identifier:
					const visitorId = result.visitorId
					// console.log(visitorId)
					// $('#fingerprint').val(visitorId);
					// set a cookie
					setCookie('fingerprint', visitorId, 1);
				})
		</script>


</body>

</html>
