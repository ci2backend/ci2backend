<script type="text/javascript">
$(document).ready(function () {
	$(document).on('click', '.submit-form', function () {
		var form = $(this).data('form-target');
		$(form).trigger('submit');
	});
});
function update_view (data) {
	$('.modal').modal('hide');
	$('.modal-backdrop').remove();
	if (typeof data != "undefined" && Object.keys(data).length) {
		for (var i = 0; i < Object.keys(data).length; i++) {
			var item = data[i];
			var file = '<a target="_blank" href="' + APP_BASE_URL + 'index.php/views/edit/' + item.encode + '" title="' + item.file + '" class="detail-view text-center">' + item.basename + '</a>';
			var element = $('#view_' + item.platform_key);
			if (i == 0) {
				element.html('');
			};
			element.append($(file).hide().fadeIn(2000));
		};
		element.append('<span class="label label-default inline-block text-center">View file</span>');
	};
}
</script>