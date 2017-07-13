<script>

    var editor = ace.edit("editor");

    editor.setTheme("ace/theme/twilight");

    editor.getSession().setMode("ace/mode/<?php if (isset($file_type)) {
    	
    	echo $file_type;

    }
    else{
    	
    	echo 'html';

    }; ?>");

    editor.getSession().setTabSize(4);

    editor.setHighlightActiveLine(true);

    editor.resize();

    $(document).ready(function () {

    	$("#edit_view_form").submit(function (event) {

    		var data = get_ace_data("#content_body");
    		
    	});

        $("#ace_settings_menu").bind('click', function(event) {

            editor.execCommand("showSettingsMenu") ;

        });

    	$("#editor").bind('keydown', function(event) {

		    if (event.ctrlKey || event.metaKey) {

		    	$(this).focus();

		        switch (String.fromCharCode(event.which).toLowerCase()) {

		        case 's':

		            event.preventDefault();

		            setTimeout(function () {

                        var data = null;

                        get_ace_data("#content_body");

                        data = $("#edit_view_form").serialize();

                        console.log(data);

                        var arr = Array();
                        
                        arr['is_save'] = true;

                        arr['url'] = $("#edit_view_form").attr('action');

                        arr['method'] = 'POST';

                        arr['datatype'] = 'html';

                        arr['data'] = data;

                        var result = ajax_loader(arr);

                        window.focus(this);
                        
                    });

		            break;

		        }

		    }

		});

    });

    function get_ace_data (el) {

    	editor_data = editor.getValue();

    	$(el).html(html_entities(editor_data).trim());

    	return html_entities(editor_data).trim();

    }

</script>