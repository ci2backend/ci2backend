<script type="text/javascript" charset="utf-8">
$(document).ready(function () {

	setTimeout(function () {
		$("#table_temporary").hide();
	});

	$('select.onchange_this').change(function (event) {
		window.location.href = APP_BASE_URL + 'index.php/routers/index/' + this.value;
	});

	$(document).on('change', 'select.router-select', function (event) {
		$(this).parents('tr').find('input.router-key').val($(this).val());
	});

	$(document).on('click', 'a.reset', function (event) {
		input = $(this).parents('tr').find('input[type="text"]');
		select = $(this).parents('tr').find('select');
		resetInput(input);
		resetSelect(select);
	});

	$("#add_new_router").click(function (event) {
		var token = guid();
		var row  = $("#temporary_row").clone().removeClass('hidden').attr('id', 'parent_row_' + token);
		console.log(row);
		var current_id = row.find('input.id_store').val();
		row.find('input.id_store').attr('name', 'router['+ current_id +'][id]').val('');
		row.find('input.row_id').attr('name', 'router['+ current_id +'][row_id]').val(token);
		row.find('select.router-select').attr('name', 'router['+ current_id +'][router_source]');
		row.find('input.router-value').attr('name', 'router['+ current_id +'][router_value]').prop('type', 'text');
		row.find('input.router-key').attr('name', 'router['+ current_id +'][router_key]').prop('type', 'text');
		row.prependTo($("#myTable tbody"));
		$.each(row.find('.uniform'), function (index, element) {
	        updateUniform();
	    });
	    installConfirmation(row.find('[data-toggle="confirmation"]'));
		$("#temporary_row").find('input.id_store').val(parseInt(current_id) + 1);
	});

	setTimeout(function () {
		hide = $('tr.hidden-element')
		if (hide.hasClass('zero-opacity')) {
			hide.addClass('hidden').removeClass('zero-opacity');
		};
	}, 500);
});

function resetInput (arrEle) {
	if (arrEle.length > 0) {
		$.each(arrEle, function (index, item) {
			var reset = $(item).data('reset');
			if (reset.length > 0) {
				$(item).val(reset);
			};
		});
	};
}
function resetSelect (arrEle) {
	if (arrEle.length > 0) {
		$.each(arrEle, function (index, item) {
			var reset = $(item).data('reset');
			if (reset.length > 0) {
				$(item).val(reset);
			};
		});
	};
}

function delete_routes (data) {
	$('#parent_row_' + data.id).remove();
	updateTableSorter();
}

function update_router(data) {
    if (typeof data != "undefined") {
        $.each(data, function(index, item) {
            var tr = $('tr#parent_row_' + item.row_id);
            tr.attr('id', 'parent_row_' + item.id);
            tr.find('input.id_store').val(item.id).attr('name', 'router[' + item.id + '][id_store]');
            tr.find('input.row_id').val(item.id).attr('name', 'router[' + item.id + '][row_id]');
            tr.find('input.router-key').attr('name', 'router[' + item.id + '][router_key]');
            tr.find('select.router-select').attr('name', 'router[' + item.id + '][router_source]');
            tr.find('input.router-value').attr('name', 'router[' + item.id + '][router_value]');
        });
    };
}
</script>