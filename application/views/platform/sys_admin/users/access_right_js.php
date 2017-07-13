<script type="text/javascript">
$(document).ready(function () {

	$(document).on('click', '#truncate_all_access_right', function (event) {
		var target = getTarget(event);
		var option_box = {
	        buttons: {
	            cancel: {
	                label: lang['Cancel']
	            }
	        },
	        buttons: {
	            cancel: {
	                'className': 'btn btn-danger',
	                label: '<i class="fa fa-times"></i> ' + lang['Cancel'],
	            },
	            confirm: {
	                label: '<i class="fa fa-check"></i> ' + lang['confirm']
	            }
	        },
	        title: '<span class="label label-info">' + lang['confirm'] + '</span>',
	        message: lang['Are_you_sure_you_want_to'],
	        callback: function(result) {
	            if (result) {
	            	var href = $(target).attr('href');
	            	console.log(href);
	            	// window.location.href = href;
	            	// return true;
	            };
	            // return true;
	        }
	    }
	    installBootbox(option_box, 'confirm');
		return false;
	});
	$(document).on('change', 'input[name="require_login"]', function () {
		var xhr = [];
		var require_login = 0;
		if ($(this).is(':checked')) {
			require_login = 1;
		};
		xhr['url'] = APP_BASE_URL + 'users/set_require_login';
		xhr['data'] = 'require_login='+ require_login +'&access_right_id=' + $(this).val();
		xhr['silent'] = true;
		var result = ajax_loader(xhr);
	});
	$(document).on('change', 'input[name="enable_access_right[]"]', function () {
		var td_contain = $(this).parents('td');
		var checker = td_contain.find('input[name="enable_access_right[]"]:checked');
		var checker_val = [];
		$(checker).each(function(){
		    checker_val.push($(this).val());
		});
		var access_right_id = $(this).data('access-right-id');
		var xhr = [];
		var data = {
			groups: checker_val,
			access_right_id: access_right_id
		};
		xhr['url'] = APP_BASE_URL + 'users/enable_access_right';
		xhr['data'] = $.param(data);
		xhr['silent'] = true;
		var result = ajax_loader(xhr);
	});
});
</script>