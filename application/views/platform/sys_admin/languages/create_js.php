<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$(document).on('change', '#select-lang_key', function () {
			var value = $(this).val();
			jvalue = JSON.parse(value);
			var data = [{
				name: 'lang_display',
				value: jvalue.name
			}, {
				name: 'lang_key',
				value: (jvalue['code']).toLowerCase()
			}, {
				name: 'lang_folder',
				value: (jvalue['alpha-2']).toLowerCase()
			}]
			setFormData(data, $("#createLanguage"));
		});
	});
function remove_selected () {
	$('#select-lang_key option:selected').remove();
	$('#select-lang_key').trigger('change');
	$('#select-lang_key').trigger("chosen:updated");
}
</script>