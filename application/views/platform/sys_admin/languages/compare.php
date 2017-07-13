<div class="grid_12">

    <div class="module card style-default-bright">

		<h2 class="text-primary"><span><?php echo lang('comparing_file'); ?> : <?php if (isset($file_view)) {

			echo $file_view;

		}
        ?> </span></h2>
        
        <div class="module-body">

            <div class="grid_12 grid border">

                <div class="grid_6">

                    <div class="form-group" style="display: inline-block;width: 100%;">

                        <label for="input" class="col-sm-4 control-label"><?php echo lang('Language'); ?> :</label>

                        <div class="col-lg-8 col-sm-8 text-right">

                            <select name="" id="language" class="input-long uniform" required="required">

                                <?php if (isset($languages) && count($languages)) {

                                    foreach ($languages as $key => $lang) {

                                        if ($lang['lang_folder'] == $sourceLang) {
                    
                                        ?>
                            
                                        <option value="<?php echo @$lang['lang_folder'] ?>" <?php if ($key == 0) {
                            
                                            echo 'selected';
                            
                                        } ?>><?php echo @$lang['lang_display'] ?></option>
                            
                                        <?php

                                        }
                    
                                    }
                    
                                } ?>
                    
                            </select>

                        </div>

                    </div>

                </div>

                <div class="grid_6">

                    <div class="form-group" style="display: inline-block;width: 100%;">

                        <label for="input" class="col-sm-4 control-label"><?php echo lang('Language'); ?> :</label>

                        <div class="col-lg-8 col-sm-8 text-right">

                            <select name="" id="language" class="input-long onchange_this uniform" required="required">

                                <?php if (isset($languages) && count($languages)) {
                    
                                    foreach ($languages as $key => $lang) {

                                        if ($lang['lang_folder'] == $sourceLang) {
                                            
                                            continue;

                                        }
                    
                                ?>
                    
                                <option value="<?php echo @$lang['lang_folder'] ?>" <?php if ($lang['lang_folder'] == $targetLang) {
                    
                                    echo 'selected';
                    
                                } ?>><?php echo @$lang['lang_display'] ?></option>
                    
                                <?php
                    
                                    }
                    
                                } ?>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="search_compare_left grid_6 text-left">

                </div>

                <div class="search_compare_right grid_6 text-left">

                </div>

            </div>

            <?php echo form_ajax('languages/compare'.'/'.$path.'/'.@$targetLang, 'id="language_compare"'); ?>

                <input type="hidden" name="targetFile" id="targetFile" class="form-control" value="<?php echo @$targetFile; ?>">

                <div class="grid_12 content-scroll">

                    <div class="grid_6">

                        <table class="table table-striped table-hover" id="table_compare_left" class="search">

                            <thead>

                                <tr>

                                    <th><?php echo lang('Key'); ?></th>

                                    <th><?php echo lang('Value'); ?></th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                    if (isset($fileSourceContent) && count($fileSourceContent)) {
                                        
                                        foreach ($fileSourceContent as $key => $text) {
                
                                ?>
                                
                                        <tr data-row-target="<?php echo 'input_'.@$text[0]; ?>">

                                            <td><input class="input_key input-short uniform" type="text" name="<?php echo 'source_'.@$text[0]; ?>" data-target="sourceFile" value="<?php echo @$text[0]; ?>" placeholder=""></td>

                                            <td>

                                                <input class="input_value input-short uniform" type="text" name="data[sourceFile][<?php echo @$text[0]; ?>]" value="<?php echo htmlentities($text[1], ENT_QUOTES); ?>" placeholder="">

                                                <div class="action-row-group">

                                                    <div class="action-row pointer">

                                                        <span class="pull-right add-new-rows" data-target="sourceFile"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>

                                                    <div class="action-row pointer">

                                                        <span class="pull-right delete-rows"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>
                                                
                                                </div>

                                            </td>

                                        </tr>

                                <?php

                                        }

                                    }
                                    else {
                                ?>
                                        <tr>

                                            <td><input type="text" class="input_key input-short uniform" name="new_key" data-target="sourceFile" value="new_key" placeholder=""></td>

                                            <td>

                                                <input type="text" class="input_value input-short uniform" name="data[targetFile][new_key]" value="new_key" placeholder="">

                                                <div class="action-row-group">

                                                    <div class="action-row pointer">

                                                        <span class="pull-right add-new-rows" data-target="sourceFile"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>

                                                    <div class="action-row pointer">

                                                        <span class="pull-right delete-rows"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>
                                                
                                                </div>

                                            </td>

                                        </tr>
                                <?php

                                    }

                                ?>

                            </tbody>

                        </table>

                    </div>

                    <div class="grid_6">

                        <table class="table table-striped table-hover" id="table_compare_right" class="search">

                            <thead>

                                <tr>

                                    <th><?php echo lang('Key'); ?></th>

                                    <th><?php echo lang('Value'); ?></th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                    if (isset($fileTargetContent) && $file_counter) {

                                        for ($key_target=0; $key_target < $file_counter; $key_target++) {

                                            if (!isset($fileTargetContent[$key_target])) {

                                                if (isset($fileSourceContent[$key_target])) {

                                                    $text = $fileSourceContent[$key_target];

                                                    $text[1] = '';

                                                }
                                                else {
                                                    continue;

                                                }

                                            }
                                            else {

                                                $text = $fileTargetContent[$key_target];

                                            }
                                ?>
                                
                                        <tr data-row-target="<?php echo 'input_'.@$text[0]; ?>">

                                            <td><input type="text" class="input_key input-short uniform" name="<?php echo 'target_'.@$text[0]; ?>" data-target="targetFile" value="<?php echo @$text[0]; ?>" placeholder=""></td>

                                            <td>

                                                <input type="text" class="input_value input-short uniform" name="data[targetFile][<?php echo @$text[0]; ?>]" value="<?php echo htmlentities($text[1], ENT_QUOTES); ?>" placeholder="">

                                                <div class="action-row-group">

                                                    <div class="action-row pointer">

                                                        <span class="pull-right add-new-rows" data-target="targetFile"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>

                                                    <div class="action-row pointer">

                                                        <span class="pull-right delete-rows" data-element-target="<?php echo 'input_'.@$text[0]; ?>"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>
                                                
                                                </div>

                                            </td>

                                        </tr>

                                <?php

                                        }

                                    }
                                    else {
                                ?>
                                        <tr>

                                            <td><input type="text" class="input_key input-short uniform" name="new_key" data-target="targetFile" value="new_key" placeholder=""></td>

                                            <td>

                                                <input type="text" class="input_value input-short uniform" name="data[targetFile][new_key]" value="new_key" placeholder="">

                                                <div class="action-row-group">

                                                    <div class="action-row pointer">

                                                        <span class="pull-right add-new-rows" data-target="targetFile"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/plus-4-16.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>

                                                    <div class="action-row pointer">

                                                        <span class="pull-right delete-rows"><img src="<?php echo base_url(TEMPLATE_PATH.@$template); ?>/img/cross-on-white.gif" class="img-responsive" alt="Image"></span>
                                                    
                                                    </div>
                                                
                                                </div>

                                            </td>

                                        </tr>
                                <?php
                                    }

                                ?>

                            </tbody>

                        </table>

                    </div>

                </div>

                <div class="grid_12">
                    
                    <div class="form-group pad-bot-10 pull-right action-fixed-target invisible">

                        <fieldset>

                            <input class="submit-green uniform" type="submit" value="<?php echo lang('Save'); ?>">

                            <input class="submit-gray uniform" type="reset" value="<?php echo lang('Reset'); ?>">
                            
                        </fieldset>

                    </div>

                    <div class="form-group pad-bot-10 pull-right action-fixed-hide visible">

                        <fieldset>

                            <input class="submit-green uniform" type="submit" value="<?php echo lang('Save'); ?>">

                            <input class="submit-gray uniform" type="reset" value="<?php echo lang('Reset'); ?>">
                            
                        </fieldset>

                    </div>

                </div>

            <?php echo form_close(); ?>

        </div>
        
    </div>
    
</div>