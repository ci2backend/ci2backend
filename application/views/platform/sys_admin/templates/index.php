<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('manage_template'); ?></span></h2>

		<div class="module-body">

			<form action="javascript:void(0);">

                <div class="grid_12 grid">

                    <div class="table-responsive">

                        <div class="grid_8">

                            <div class="grid_3">

                                <a class="button pull-left" type="button" href="<?php echo site_url('templates/create');?>">

                                    <span>

                                        <?php echo lang('Add_new'); ?>

                                        <img src="<?php echo $this->load->assets('img/plus-small.gif'); ?>" width="12" height="9" alt="">

                                    </span>

                                </a>

                            </div>

                            <div class="grid_5">

                                <select name="is_backend" id="switch_template" class="onchange_this reload">

                                    <option <?php if ($is_backend == 0): ?>

                                        <?php echo 'selected="selected"'; ?>

                                    <?php endif ?>value="<?php echo site_url('templates/index') ?>">Frontend template</option>

                                    <option <?php if ($is_backend == 1): ?>
                                        
                                        <?php echo 'selected="selected"'; ?>
                                        
                                    <?php endif ?>value="<?php echo site_url('templates/index/1') ?>">Backend template</option>

                                </select>

                            </div>

                        </div>

                        <table id="myTable" class="table table-striped table-hover">

                            <thead>

                                <tr>

                                    <th style="width:5%" class="text-center">

                                        <input type="checkbox" class="action uniform toggle-selected" />

                                    </th>

                                    <th style="width:20%" class="text-center"><?php echo lang('template_name'); ?></th>

                                    <th style="width:21%" class="text-center"><?php echo lang('template_key'); ?></th>

                                    <th style="width:15%" class="text-center">
                                        
                                        <?php echo lang('table_option'); ?>

                                    </th>

                                </tr>

                            </thead>

                            <tbody class="tablesorter">

                                <?php

                                    if (count(@$templates) > 0) {

                                        foreach ($templates as $key => $templ) {

                                ?>

                                <tr data-target="<?php echo $templ['template_key'] ?>">

                                    <td class="align-center">

                                        <input type="checkbox" class="action uniform" />

                                    </td>

                                    <td><a href="<?php echo site_url("templates/detail") ?>/<?php echo @$templ['template_key']; ?>"><?php echo @$templ['template_name']; ?></a></td>

                                    <td><?php echo @$templ['template_key']; ?></td>

                                    <td>

                                        <?php

                                            $dataAction = array(
                                                'update' => array(
                                                    'class' => 'update_action',
                                                    'href' => site_url('templates/detail').'/'.$templ['id'],
                                                    'target' => '',
                                                    'title' => '',
                                                    'data-original-title' => '',
                                                    'data-target' => '',
                                                    'data-toggle' => '',
                                                    'style' => 'display: inline-block;',
                                                )
                                            );

                                            if ((isset($templ['allow_delete']) && $templ['allow_delete']) || $this->ion_auth->is_admin()) {

                                                $dataAction['delete'] = array(
                                                    'class' => 'delete_action',
                                                    'href' => site_url('templates/delete').'/'.base64_encode($templ['id']),
                                                    'target' => '',
                                                    'title' => '',
                                                    'data-original-title' => '',
                                                    'data-target' => array(
                                                        'target' => '',
                                                        'control' => 'templates',
                                                        'file' => base64_encode($templ['id'])
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

                    </div>

                </div>

            </form>

            <?php echo $this->load->common("table/pagination"); ?>

            <?php echo $this->load->common("table/table-apply"); ?>

		</div>

	</div>

</div>