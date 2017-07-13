<script type="text/javascript">
	$(document).ready(function () {
		$("#formCreateUser").validate({
			onsubmit: true,
	        rules: {
	        	first_name: {
	                required: true
	            },
	            last_name: {
	                required: true
	            },
	            company: {
	                required: true
	            },
	            email: {
	                required: true,
	                email: true
	            },
	            password: {
	                required: true,
	            },
	            password_confirm: {
	            	required: true,
	            	equalTo: $('#password'),
	            },
	            phone: {
	                required: true,
	                digits: true
	            },

	        },
	        messages: {
	        	first_name: {
	                required: 'The field is required',
	            },
	            last_name: {
	                required: 'The field is required',
	            },
	            company: {
	                required: 'The field is required',
	            },
	            email: {
	                required: 'The field is required',
	                email: 'Enter invalid email'
	            },
	            password: {
	                required: 'The field is required',
	            },
	            password_confirm: {
	                required: 'The field is required',
	                equalTo: 'Your password does not match',
	            },
	            phone: {
	                required: 'The field is required',
	                digits: 'Enter invalid phone number'
	            },
	        }
	    });
	});
</script>