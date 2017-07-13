<script type="text/javascript">
$(document).ready(function () {
	var options = new Elfinder();
	 options.url = APP_BASE_URL + 'index.php/tree/loadExtensionFolder?extension=' + '<?php echo $extension["extension_key"] ?>';
    $(document).on('click', 'ul.nav.nav-tabs a[aria-controls="files"]', function () {
    	var isLoad = $(this).data('loadded');
    	if (!isLoad) {
    		$('#elfinder_extension').html('');
		    var new_folder = $('<div />').attr('id', number = 1 + Math.floor(Math.random() * 1000));
		    new_folder.appendTo($('#elfinder_extension'));
		    initFinder(new_folder, options);
		    $(this).data('loadded', 1);
    	};
    });
});
</script>