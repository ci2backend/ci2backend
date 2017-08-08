<script type="text/javascript">
	$(document).ready(function () {
		$('.onchange_this').change(function () {
			window.location.href = APP_BASE_URL + 'index.php/views/index/' + this.value;
		});
	});
</script>