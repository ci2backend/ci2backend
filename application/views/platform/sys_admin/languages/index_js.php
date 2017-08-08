<script type="text/javascript">

	$(document).ready(function () {

		$('select.onchange_this').change(function () {

			var key_default_selector = '#key_default';

			language_switch(key_default_selector);

		});

	});

	function language_switch (key_default_selector) {

		var key_default = 'js';

		var key_language = 'english';

		var key_platform = 'web';

		key_default = $(key_default_selector).val();

		key_language = $('select#key_language').val();

		key_platform = $('select#key_platform').val();

		window.location.href = APP_BASE_URL + 'index.php/languages/index' + '/' + key_default + '/' + key_platform + '/' + key_language;

	}
</script>