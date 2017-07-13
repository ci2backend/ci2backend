<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('edit_user_heading');?></span></h2>
        
        <div class="module-body">            

            <?php echo form_open(uri_string());?>

                <div class="grid_12 col-lg-12">

                    <div class="table-responsive">

                        <p class="grid_12 grid red"><?php echo lang('edit_user_subheading');?></p>

                        <?php if (!empty($message)): ?>

                            <div class="grid grid_12" id="infoMessage"><?php echo $message;?></div>
                            
                        <?php endif ?>

                        <div class="grid_12">

                            <div class="form-group grid_6">

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_fname_label', 'first_name');?>

                                    <?php echo form_input(@$first_name);?>

                                </div>

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_lname_label', 'last_name');?>

                                    <?php echo form_input(@$last_name);?>

                                </div>

                            </div>

                            <div class="form-group grid_6">

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_company_label', 'company');?>

                                    <?php echo form_input(@$company);?>

                                </div>

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_phone_label', 'phone');?>

                                    <?php echo form_input(@$phone);?>

                                </div>

                            </div>

                        </div>

                        <div class="grid_12">

                            <div class="form-group grid_6">

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_password_label', 'password');?>

                                    <?php echo form_input(@$password);?>

                                </div>

                                <div class="form-group grid_6">

                                    <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>

                                    <?php echo form_input(@$password_confirm);?>

                                </div>

                            </div>

                            <div class="form-group grid_6">

                                <?php if ($this->ion_auth->is_admin()): ?>

                                    <label>

                                        <?php echo lang('edit_user_groups_heading');?>

                                    </label>

                                        <?php

                                            if (isset($groups) && count($groups)) {
                                             
                                        ?>
                                            <?php foreach ($groups as $group):?>

                                                <label class="checkbox border-thin" title="<?php echo @$group['description'];?>">

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

                                                    <input type="checkbox" name="groups[]" class="input-long extra uniform" value="<?php echo @$group['id'];?>"<?php echo @$checked;?>>

                                                    <?php echo ucfirst(htmlspecialchars(@$group['name'], ENT_QUOTES,'UTF-8'));?>

                                                </label>

                                            <?php endforeach?>

                                        <?php

                                            }

                                        ?>

                                <?php endif ?>

                            </div>

                        </div>

                        <?php echo form_hidden('id', @$user->id);?>

                        <?php echo form_hidden(@$csrf); ?>


                        <div class="form-group text-right grid_12">

                            <?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class="submit-green uniform pull-right"');?>

                        </div>

                    </div>

                </div>

            <?php echo form_close();?>

        </div>

    </div>

</div>
