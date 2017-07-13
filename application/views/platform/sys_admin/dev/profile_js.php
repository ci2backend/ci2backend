<script type="text/javascript">
$(document).ready(function (event) {
	$(document).on('click', 'a[data-toggle="tab"]', function (event) {
		var target = $(this).data('target');
		var url = APP_BASE_URL + 'index.php/dev/profile/' + target.replace('#', '');
		var html = $('html').html();
	    window.history.pushState({},"", url);
	});
});
</script>