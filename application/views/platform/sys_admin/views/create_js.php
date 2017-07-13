<script type="text/javascript">
    
    $(document).ready(function () {
       $(document) .on('change', '#template_content', function () {
           editor.getSession().setValue($(this).val());
       });
    });

    var editor = ace.edit("editor");

    editor.setTheme("ace/theme/twilight");

    editor.getSession().setMode("ace/mode/<?php if (isset($file_type)) {
    	
    	echo $file_type;

    }
    else{
    	
    	echo 'html';

    }; ?>");

    editor.getSession().setTabSize(4);

    editor.getSession().on("change", function () {
        get_ace_data("#content_body");
    });

    editor.setHighlightActiveLine(true);

    editor.resize();

    $(document).ready(function () {
        // Get default value for ace editor
        get_ace_data("#content_body");;
    });

    function get_ace_data (el) {

    	editor_data = editor.getValue();

        $(el).val(editor_data.trim());

    	$(el).html(html_entities(editor_data).trim());

    	return html_entities(editor_data).trim();

    }

</script>