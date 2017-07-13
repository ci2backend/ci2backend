<script type="text/javascript">

function constant_create(data) {
	
	$('#modal_contant_define').modal('hide');

	$('#myTable').find('tbody').append(data);

	$('#myTable').trigger('update');

	installUniform(uniform);

	var conforn_element = $('#myTable').find('.item_constant:last .delete_action');

	installConfirmation(conforn_element);

}

function constant_update(data) {
	
	$('#modal_contant_define').modal('hide');

	var tmpElem = $('<div/>').html(data).children();

	var tmpClass = $(tmpElem).attr('class');

	$('#myTable').find('.' + tmpClass.replace(' ', '.')).html($(tmpElem).html());

	if (jQuery().confirmation) {

		conforn_element = $('#myTable').find('.' + tmpClass.replace(' ', '.') + ' .delete_action');

		installConfirmation(conforn_element);

	}

}

function constant_delete(data) {
	
	$('#myTable').find('.item_constant_' + data).remove();

	$('#myTable').trigger('update');

	installUniform(uniform);

}

$(document).ready(function() {
	
	$('#modal_contant_define').on('shown.bs.modal', function(e) {
	
		installUniform(uniform);

	});

	$('#btn_create_constant').on('click', function() {
		
		$('#modal_contant_define').find('form')[0].reset();
		
		$('#modal_contant_define').modal('show');

	});

	$(document).on('click', '.item_constant .update_action', function() {

		$('#modal_contant_define').find('#input_constant').rules('remove', 'remote');

		var id = $(this).data('update');

		var item = $(this).parents('.item_constant');

		var keyConstant = $(item).find('.constant_key').data('constant');

		var valueConstant = $(item).find('.constant_value').data('constant');

		$('#modal_contant_define').find('#input_constant').val(keyConstant);

		$('#modal_contant_define').find('#input_value').val(valueConstant);

		$('#modal_contant_define').find('[name="operation_action"]').val('edit');

		$('#modal_contant_define').find('[name="constant_id"]').val(id);
		
		$('#modal_contant_define').modal('show');

	});

});

</script>