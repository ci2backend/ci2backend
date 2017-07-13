<script type="text/javascript">
$(document).ready(function () {
	var template_options = new Elfinder();
	template_options.url = APP_BASE_URL + 'index.php/tree/loadTemplateFolder?template=' + '<?php echo @$tmpl["template_key"] ?>';

	var common_template_options = new Elfinder();
	common_template_options.url = APP_BASE_URL + 'index.php/tree/loadTemplateCommonFolder?template=' + '<?php echo @$tmpl["template_key"] ?>';

    var new_template_folder = $('<div />').attr('id', number = 1 + Math.floor(Math.random() * 1000));
    var new_common_template_folder = $('<div />').attr('id', number = 1 + Math.floor(Math.random() * 1000));

    new_template_folder.appendTo($('#elfinder_template').html(''));
    new_common_template_folder.appendTo($('#elfinder_common_template').html(''));

    initFinder(new_template_folder, template_options);
    initFinder(new_common_template_folder, common_template_options);

    $(document).on('change', 'input[name="enable_customize_view"]', function () {
        if ($(this).val() == 1) {
            $('div.customize-view-foller').slideDown();
        }
        else{
            $('div.customize-view-foller').slideUp();
        }
    });
});
</script>