<script type="text/javascript">
$(document).ready(function () {
	$(document).on('change', 'input[name="is_default"]', function () {
		var xhr = [];
		xhr['url'] = APP_BASE_URL + 'index.php/platforms/set_default';
		xhr['data'] = 'is_default=1&platform_key=' + $(this).val();
		xhr['silent'] = true;
		var result = ajax_loader(xhr);
	});
});
</script>