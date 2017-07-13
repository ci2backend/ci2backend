<script type="text/javascript">
	function required_login (data) {
		if (typeof data.code != "undefined") {
			check_access(data.code);
		};
	}
</script>