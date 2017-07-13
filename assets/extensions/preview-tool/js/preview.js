tool_box = '';
$(document).ready(function () {
	$(document).on('click', '.fixed-top.preview-tool', function () {
		$('.preview-box .tool-box').toggleClass('active');
	});
	$.ajax({
		url: APP_BASE_URL + 'index.php/ajax.html',
		method: "POST",
		data: 'operation_action=get_preview_box&controls=views'
	}).done(function(data) {
		if (is_json(data)) {
			var result = JSON.parse(data);
			if (typeof result.data != "undefined") {
				$('body').append(result.data);
				var action = document.URL;
				if ($.uniform) {
					$('.preview-box .tool-box .uniform').uniform();
				};
				$("#preview-form").attr('action', action);
			}
			else {
				alert('Can\'t load preview box');
			}
		};
	});
});