<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('Manage_language'); ?></span></h2>

        <div class="module-body">

            <div class="grid_12">

                <form action="javascript:void(0);">

                    <div class="tool grid_8">

                        <div class="grid_4">

                            <label class="lb-input short4">
                            
                                <?php echo $this->lang->line('Language_type') ?> :
                            
                                <select class="input-short onchange_this uniform" id="key_default">
                        
                                    <option value="php" <?php if ($key_default == 'php') {
                        
                                        echo 'selected';
                        
                                    } ?>> <?php echo lang('PHP_file') ?></option>

                                    <option value="js" <?php if ($key_default == 'js') {
                        
                                        echo 'selected';
                        
                                    } ?>> <?php echo lang('Javascript_file') ?></option>
                        
                                </select>

                            </label>

                        </div>

                        <div class="grid_4">

                            <label class="lb-input short4">
                            
                                <?php echo $this->lang->line('Platforms') ?> :
                            
                                <select class="input-short onchange_this uniform" id="key_platform">
                        
                                    <?php if (isset($platforms) && count($platforms)) {
                        
                                        foreach ($platforms as $key => $plat) {

                                    ?>
                        
                                        <option value="<?php echo @$plat['platform_key'] ?>" <?php if ($plat['platform_key'] == $key_platform) {
                        
                                            echo 'selected';
                            
                                        } ?>> <?php echo @$plat['platform_name'] ?></option>
                        
                                    <?php
                        
                                        }
                        
                                    } ?>
                        
                                </select>

                            </label>

                        </div>
                        
                        <div class="grid_4">

                            <label class="lb-input short4">
                            
                                <?php echo $this->lang->line('filter_language') ?> :

                                <select class="input-short onchange_this uniform" id="key_language">
                        
                                    <?php if (isset($languages) && count($languages)) {
                        
                                        foreach ($languages as $key => $lang) {
                        
                                    ?>
                        
                                    <option value="<?php echo @$lang['lang_folder'] ?>" <?php if ($lang['lang_folder'] == $key_language) {
                        
                                        echo 'selected';
                        
                                    } ?>><?php echo @$lang['lang_display'] ?></option>
                        
                                    <?php
                        
                                        }
                        
                                    } ?>
                        
                                </select>

                            </label>

                        </div>
                        
                    </div>

                    <table id="myTable" class="tablesorter table table-striped table-hover">

                        <thead>

                            <tr>

                                <th style="width:5%" class="text-center">

                                    <input type="checkbox" class="action uniform toggle-selected"/>

                                </th>

                                <th style="width:20%" class="text-center">Language File</th>

                                <th style="width:21%" class="text-center"><?php echo lang('Module') ?></th>

                                <th style="width:13%" class="text-center"><?php echo lang('Size') ?></th>

                                <th style="width:15%" class="text-center"><?php echo lang('table_option'); ?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php 
                                if (count(@$file_list) > 0) {

                                    foreach ($file_list as $key => $file) {
                            ?>

                            <tr data-target="<?php echo base64_encode($file['path']); ?>">

                                <td class="align-center">

                                    <input type="checkbox" class="action uniform"/>

                                </td>

                                <td><a href="<?php echo site_url('languages/edit').'/'.base64_encode($file['path']); ?>"><?php echo $file['file']; ?></a></td>

                                <td><?php echo $file['module']; ?></td>

                                <td><?php echo $file['size']; ?></td>

                                <td>

                                    <?php

                                        $dataAction = array(
                                            'update' => array(
                                                'class' => 'update_action',
                                                'href' => site_url('languages/edit').'/'.base64_encode($file['path']),
                                                'target' => '',
                                                'title' => '',
                                                'data-original-title' => '',
                                                'data-target' => '',
                                                'data-toggle' => '',
                                                'style' => 'display: inline-block;',
                                            ),
                                            'compare' => array(
                                                'class' => 'compare',
                                                'href' => site_url('languages/compare').SLASH.base64_encode($file['path']).SLASH.@$compare_with,
                                                'target' => '',
                                                'title' => ''
                                            )
                                        );

                                        if ((isset($file['allow_delete']) && $file['allow_delete']) || $this->ion_auth->is_admin()) {

                                            $dataAction['delete'] = array(
                                                'class' => 'delete_action',
                                                'href' => site_url('languages/delete').'/'.base64_encode($file['path']),
                                                'target' => '',
                                                'title' => '',
                                                'data-original-title' => '',
                                                'data-target' => array(
                                                    'target' => '',
                                                    'control' => 'languages',
                                                    'file' => base64_encode($file['path'])
                                                ),
                                                'data-toggle' => 'confirmation',
                                                'style' => 'display: inline-block;'
                                            );
                                            
                                        }

                                        $data['table_action'] = $dataAction;

                                        echo $this->load->common("table/table_action", true, $data);

                                    ?>

                                </td>

                            </tr>

                            <?php
                                    }
                                }
                            ?>
                            
                        </tbody>

                    </table>

                </form>

            </div>

            <?php echo $this->load->common("table/pagination"); ?>

            <?php echo $this->load->common("table/table-apply"); ?>

            <div style="clear: both"></div>

        </div>

    </div>

</div>