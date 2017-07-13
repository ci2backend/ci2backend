<script type="text/javascript">
$(document).ready( function() {
    $("#createExtension").validate({
        rules: {
        	extension_name: {
                required: true,
                specialCharsDisable: true
            },
            extension_key: {
                required: true,
                folder_name: true
            },
            description: {
                required: true
            },
        },
        messages: {
        	extension_name: {
                required: 'Please enter extension name',
                specialCharsDisable: 'Letters, numbers, and underscores only please',
            },
            extension_key: {
                required: 'Please enter extension key',
                folder_name: "Please enter a valid folder name"
            },
            description: {
                required: 'Please enter description',
            },
        },
        submitHandler: function(form) {
            var data = $(form).serialize();
            $.ajax({
            	url: APP_BASE_URL + 'index.php/extensions/create',
            	method: "POST",
  				data: data,
  				success: function (response) {
  					if (response) {
                        var result = JSON.parse(response);
                        if (result.success) {
                            if ($('#elfinder_extension')) {
                                var options = {
                                    url : APP_BASE_URL + 'index.php/tree/loadTreeFolder?extension=' + result.data['key'],
                                    handlers : {
                                        dblclick : function(event, elfinderInstance) {
                                          event.preventDefault();
                                          elfinderInstance.exec('getfile')
                                            .done(function() { elfinderInstance.exec('quicklook'); })
                                            .fail(function() { elfinderInstance.exec('open'); });
                                        }
                                    },
                                    getFileCallback : function(files, fm) {
                                        return false;
                                    },
                                    commandsOptions : {
                                        quicklook : {
                                            width : $(document).width(),  // Set default width/height voor quicklook
                                            height : $(document).height()
                                        },
                                        edit: {
                                            mimes: [],
                                            editors: [{
                                                mimes: [
                                                    'text/plain',
                                                    'text/html',
                                                    'application/xhtml+xml',
                                                    'text/javascript',
                                                    'application/javascript',
                                                    'text/css',
                                                    'text/xml',
                                                    'application/docbook+xml',
                                                    'application/xml'
                                                ],
                                                load: function(textarea) {
                                                    console.log(textarea);
                                                    var mimeType = this.file.mime;
                                                    return CodeMirror.fromTextArea(textarea, {
                                                        mode: mimeType,
                                                        lineNumbers: true,
                                                        indentUnit: 4
                                                    });
                                                },
                                                width : $(document).width(),  // Set default width/height voor quicklook
                                                height : $(document).height(),
                                                save: function(textarea, editor) {
                                                    $(textarea).val(editor.getValue());
                                                }
                                            }]
                                        }
                                    }
                                };
                                $('#elfinder_extension').html('');
                                var new_folder = $('<div />').attr('id', number = 1 + Math.floor(Math.random() * 1000));
                                new_folder.appendTo($('#elfinder_extension'));
                                initFinder(new_folder, options);
                            }
                            
                        }
                        else {
                            alert(result.message);
                        }
                    };
  				}
            });
            return false;
        }
    });
});
</script>

<script>
if (typeof Dropzone != "undefined") {
    Dropzone.options.myDropzone= {
        url: APP_BASE_URL + 'index.php/extension/import',
        autoProcessQueue: true,
        maxFilesize: 128,
        acceptedFiles: '',
        addRemoveLinks: true,
        init: function() {
            dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
            // for Dropzone to process the queue (instead of default form behavior):
            document.getElementById("submit-all").addEventListener("click", function(e) {
                // Make sure that the form isn't actually being sent.
                e.preventDefault();
                e.stopPropagation();
                dzClosure.processQueue();
            });
            this.on("uploadprogress", function(file, progress) {
                console.log(file);
                console.log("File progress", progress);
            });
            //send all the form data along with the files:
            // this.on("sending", function(data, xhr, formData) {
            //     formData.append("access_key", jQuery("#access_key").val());
            //     console.log(formData);
            // });
            this.on("success", function(file, responseText) {
                console.log(responseText);
            });
            this.on("error", function(file, response) {
                // do stuff here.
                alert(response);

            });
        }
    }
};
</script>