<script type="text/javascript">
	$(document).ready(function () {
		modalGetValue('.modalGetValue');
		$("#formCreateMenu").validate({
	        rules: {
	        	title_key: {
	                required: true,
	                'lang_key': true,
	            },
	            action_router: {
	                required: true,
	                // 'routeFormat': true,
	            }
	        },
	        messages: {
	        	title_key: {
	                required: 'The field is required',
	                lang_key: 'Please enter non-special characters',
	            },
	            action_router: {
	                required: 'The field is required',
	                // routeFormat: 'Only alphabetic and "/"',
	            }
	        },
	        submitHandler: function(form) {
	        	var result = formAjaxSubmit(form);
	            if (result) {
	                console.log(result);
	            };
	        }
	    });
	});
	function initChosen (el) {
		if ($(el)) {
			$(el).chosen();
		};
	}
	function updateSelect (element, result) {
		if ($(element).length) {
			if (result.success) {
				var data = result.data;
				$(element).find('option').remove().end();
				var controller = data.controller;
				var actions = data.action;
				var selected = '';
				for (var i = 0; i < actions.length; i++) {
					var opt_val = controller + '/' + actions[i];
					if (i == 0) {
						selected = opt_val;
						$(element).append('<option selected="selected" value="' + opt_val + '">' + actions[i] + '</option>').val(opt_val);
					}
					else{
						$(element).append('<option value="' + opt_val + '">' + actions[i] + '</option>').val(opt_val);
					}
					$(element).val(selected);
					$(element).trigger("chosen:updated");
				};
			};
		};
	}
</script>