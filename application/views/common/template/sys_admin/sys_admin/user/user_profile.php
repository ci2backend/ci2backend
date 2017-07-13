<div class="panel-info">

	<div class="panel-body">

		<?php echo form_ajax('dev/save_profile', 'class="ajax validate panel-parent"');?>

            <p>

                <?php echo lang('edit_user_fname_label', 'first_name');?> <br />

                <?php echo form_input(@$first_name);?>

            </p>

            <p>

                <?php echo lang('edit_user_lname_label', 'last_name');?> <br />

                <?php echo form_input(@$last_name);?>

            </p>

            <p>

                <?php echo lang('edit_user_company_label', 'company');?> <br />

                <?php echo form_input(@$company);?>

            </p>

            <p>

                <?php echo lang('edit_user_phone_label', 'phone');?> <br />

                <?php echo form_input(@$phone);?>

            </p>

            <?php if (isset($lang_arr)): ?>
            <p>

                <?php echo lang('language', 'lang_folder');?> <br />

                <?php echo form_dropdown('lang_folder', $lang_arr, $lang_default, 'class="form-control input-medium"');?>

			</p>
            <?php endif ?>

            <p>

                <?php echo lang('edit_user_password_label', 'password');?> <br />

                <?php echo form_input(@$password);?>

            </p>

            <p>

                <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />

                <?php echo form_input(@$password_confirm);?>

            </p>

            <?php if ($this->ion_auth->is_admin()): ?>

                <h3><?php echo lang('edit_user_groups_heading');?></h3>
                    <?php
                        if (isset($groups) && count($groups)) {
                         
                    ?>
                        <?php foreach ($groups as $group):?>

                            <label class="checkbox" style="width: 98%; float: right;">

                            <?php

                                $gID=$group['id'];

                                $checked = null;

                                $item = null;

                                foreach($currentGroups as $grp) {

                                    if ($gID == $grp->id) {

                                        $checked= ' checked="checked"';

                                        break;

                                    }

                                }

                            ?>

                            <input type="checkbox" name="groups[]" value="<?php echo @$group['id'];?>"<?php echo @$checked;?>>

                            <?php echo htmlspecialchars(@$group['name'],ENT_QUOTES,'UTF-8');?>

                            </label>

                        <?php endforeach?>
                    <?php
                        }
                    ?>
            <?php endif ?>

            <?php echo form_hidden('id', @$user->id);?>

            <?php echo form_hidden(@$csrf); ?>

            <p><?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="submit-green pull-right"');?></p>

        <?php echo form_close();?>

	</div>

</div>