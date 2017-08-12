<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', 'a.export', function (event) {
        ele = getTarget(event);
        event.preventDefault();
        var data = $(this).data('target');
        if ($.download) {
            $.download(APP_BASE_URL + 'index.php/' + data.control + '/' + data.action + '/' + data.extension_key, null + data.extension_key, 'GET');
        };
    });
});
function generate_folder (data) {
	if ($('#elfinder_extension').length && typeof data.key != "undefined") {
		var extension_options = new Elfinder();
		extension_options.url = APP_BASE_URL + 'index.php/tree/loadExtensionFolder?extension=' + data.key;
        $('#elfinder_extension').html('');
        var new_folder = $('<div />').attr('id', number = 1 + Math.floor(Math.random() * 1000));
        new_folder.appendTo($('#elfinder_extension'));
        initFinder(new_folder, extension_options);
    }
}
</script>
