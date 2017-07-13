<script type="text/javascript">

    validData = new Object();

	<?php

        $arrValid = array();

        $arrValid['rules']['new_key'] = array(
                                            'lang_key' => true,
                                            'required' => true
                                        );

        $arrValid['messages']['new_key'] = array(
                                            'lang_key' => 'Please enter a valid language key',
                                            'required' => 'Please enter a language key'
                                        );

		if (isset($fileSourceContent) && count($fileSourceContent)) {
                                    
            foreach ($fileSourceContent as $key => $text) {

                $arrValid['rules']['source_'.$text[0]] = array(
                                                    'lang_key' => true,
                                                    'required' => true
                                                );

                $arrValid['messages']['source_'.$text[0]] = array(
                                                    'lang_key' => 'Please enter a valid language key',
                                                    'required' => 'Please enter a language key'
                                                );
            }

		}

        if (isset($fileTargetContent) && count($fileTargetContent)) {
                                    
            foreach ($fileTargetContent as $key => $text) {

                $arrValid['rules']['target_'.$text[0]] = array(
                                                    'lang_key' => true,
                                                    'required' => true
                                                );

                $arrValid['messages']['target_'.$text[0]] = array(
                                                    'lang_key' => 'Please enter a valid language key',
                                                    'required' => 'Please enter a language key'
                                                );
            }
            
        }

	?>

    valid = '<?php echo json_encode($arrValid); ?>';

    valid = JSON.parse(valid);

	$(document).ready(function () {

        installTableSearch('#table_compare_left', '', {
            container: 'div.search_compare_left'
        });

        installTableSearch('#table_compare_right', '', {
            container: 'div.search_compare_right'
        });

		$('.onchange_this').change(function () {
			window.location.href = APP_BASE_URL + 'languages/compare/<?php echo $path ?>' + '/' + this.value;
		});

		valid.submitHandler = function(form) {
            var result = formAjaxSubmit(form);
            if (result) {
                update_lang_row();
            };
        }

        validData.rules = valid.rules;

        validData.messages = valid.messages;

        $('form#language_compare').validate(valid);

        $(document).on('paste', 'input.input_key', function () {
            var element = this;
            setTimeout(function () {
                var text = $(element).val();
                if (typeof url_slug == "function") {
                    $(element).val(url_slug(text, {
                        delimiter: '_',
                        lowercase: false
                    }));
                };
            }, 100);
        });

        $(document).on('keyup', 'input.input_key', function () {
        	if (!$(this).hasClass('error')) {
                var target = this;
                var target_value = $(target).parents('tr').find('.input_value');
                var tag_target = $(target).data('target')
                $(target).attr('name', tag_target.replace('File', '_') + $(target).val());
                target_value.attr('name', 'data[' + tag_target + '][' + $(target).val() + ']');
                var parent = $(target).parents('table');
                var index = $(target).parents('tr').index();
                var source = null;
                if (parent.attr('id') == 'table_compare_left') {
                    source = $("#table_compare_right").find('tbody tr:eq(' + index + ') input.input_key');
                }
                else {
                    source = $("#table_compare_left").find('tbody tr:eq(' + index + ') input.input_key');
                }
                var source_value = $(source).parents('tr').find('.input_value');
                var tag_source = $(source).data('target')
                $(source).val($(target).val());
                $(source).attr('name', tag_source.replace('File', '_') + $(source).val());
                source_value.attr('name', 'data[' + tag_source + '][' + $(source).val() + ']');
        	};
        });

        $(document).on('click', 'span.delete-rows', function () {
            var result = true;
            var parent = $(this).parents('table');
            if (parent.attr('id') == 'table_compare_right') {
                result = confirm("Want to delete?");
            };
            if (result) {
                var target = $(this).data('element-target');
                var tr = $(this).parents('tr[data-row-target="' + target + '"]');
                $(tr).remove();
                $("#table_compare_left").find('tbody tr[data-row-target="' + target + '"]').remove();
                var messi = new Messi_data();
                messi.message = lang['The_row_has_been_remove_but_not_saved_Please_save_to_update_your_data'];
                messi.class = 'success';
                messi.title = lang['Success'];
                show_messi(messi);
            }
        });

        $(document).on('click', 'span.add-new-rows', function () {
            var tr = $(this).parents('tr');
            var id = makeId();
            var input_key_name = 'target_' + id;
            var name = 'data[' + $(this).data('target') + '][' + id + ']';
            var strTr = '<tr class="new-row" data-row-target="' + input_key_name + '"> \
                            <td><input type="text" class="input_key input-short" name="' + input_key_name + '" data-target="' + $(this).data('target') + '" value="' + id + '" placeholder=""></td> \
                            <td> \
                                <input type="text" class="input_value input-short" name="' + name + '" value="" placeholder=""> \
                                <div class="action-row-group"> \
                                    <div class="action-row pointer"> \
                                        <span class="pull-right add-new-rows" data-target="' + $(this).data('target') + '"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span> \
                                    </div> \
                                    <div class="action-row pointer"> \
                                        <span class="pull-right delete-rows" data-element-target="' + input_key_name + '"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span> \
                                    </div> \
                                </div> \
                            </td> \
                        </tr>';
            var after = $(tr).after(strTr);
            var parent = $(this).parents('table');
            var row_target = $(tr).data('row-target');
            var clone_data_target = $(this).data('target');
            if (clone_data_target == 'targetFile') {
                clone_data_target = 'sourceFile';
            };
            var clone_input_key_name = 'source_' + id;
            var clone_name = 'data[' + clone_data_target + '][' + id + ']';
            var strTrClone = '<tr class="new-row" data-row-target="' + clone_input_key_name + '"> \
                            <td><input type="text" class="input_key input-short" name="' + clone_input_key_name + '" data-target="' + clone_data_target + '" value="' + id + '" placeholder=""></td> \
                            <td> \
                                <input type="text" class="input_value input-short" name="' + clone_name + '" value="" placeholder=""> \
                                <div class="action-row-group"> \
                                    <div class="action-row pointer"> \
                                        <span class="pull-right add-new-rows" data-target="' + clone_data_target + '"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span> \
                                    </div> \
                                    <div class="action-row pointer"> \
                                        <span class="pull-right delete-rows" data-element-target="' + clone_input_key_name + '"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span> \
                                    </div> \
                                </div> \
                            </td> \
                        </tr>';
            var row_source = $(tr).data('row-target').replace('target_', 'source_');
            $("#table_compare_left").find('tr[data-row-target="' + row_source + '"]').after(strTrClone);
        });

        $(document).on('keydown', 'input.input_value', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode == 9) {
                e.preventDefault();
                var tr = $(this).parents('tr');
                var index = $(tr).index();
                var parent = $(this).parents('table');
                var input_key = null;
                if (parent.attr('id') == 'table_compare_left') {
                    input_key = $("#table_compare_right").find('tbody tr:eq(' + index + ') td input.input_key');
                } else {
                    index = index + 1;
                    input_key = $("#table_compare_left").find('tbody tr:eq(' + index + ') td input.input_key');
                }
                if (input_key) {
                    var strLength = input_key.val().length * 2;
                    input_key.focus();
                    input_key[0].setSelectionRange(strLength, strLength);
                    input_key.select();
                };
            }
        });
        searchTimeOutId = 0;
        $(document).on('keyup', '#input_search_table', function() {
            pattern = RegExp($(this).val(), 'i');
            clearTimeout(searchTimeOutId);
            searchTimeOutId = setTimeout(function () {
                $('#table_compare_left').find('tbody tr').fadeOut().each(function() {
                    var currentRow = $(this);
                    currentRow.find('td').each(function() {
                        if (pattern.test($(this).html())) {
                            currentRow.fadeIn();
                            return false;
                        }
                    });
                });
                $('#table_compare_right').find('tbody tr').fadeOut().each(function() {
                    var currentRow = $(this);
                    currentRow.find('td').each(function() {
                        if (pattern.test($(this).html())) {
                            currentRow.fadeIn();
                            return false;
                        }
                    });
                });
            }, 500);
        });
	});
function makeId() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    for( var i=0; i < 15; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

function update_lang_row () {
    $('table tbody tr').removeClass('new-row');
}
</script>