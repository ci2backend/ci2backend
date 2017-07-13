<script type="text/javascript">
$(window).on('load', function () {
	$.ajax({url: APP_BASE_URL + 'users/check_expired_session'});
});
$(document).ready(function () {

	$("form#login").validate({
		rules: {
			EMAIL: {
				required: true,
				email: true
			},
			PASSWORD: {
				required: true,
				minlength: 6
			},
		},
		messages: {
			EMAIL: "Please enter your email",
			PASSWORD: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long"
			},
		}
	});

});

</script>