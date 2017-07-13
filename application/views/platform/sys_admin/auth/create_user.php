<?php echo form_open("auth/create_user", 'id="formCreateUser"');?>

    <div class="grid_6">

        <div class="module">

            <h2 class="text-primary"><span><?php echo lang('Personal_information'); ?></span></h2>
                
            <div class="module-body card-body">

                <p class="grid red"><?php echo lang('create_user_subheading');?></p>

                <?php if (!empty($message)): ?>

                    <div class="grid" id="infoMessage"><?php echo $message;?></div>
                    
                <?php endif ?>

                <div class="row grid">

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_fname_label', 'first_name');?>

                        <?php echo form_input($first_name);?>

                    </div>

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_lname_label', 'last_name');?>

                        <?php echo form_input($last_name);?>

                    </div>

                </div>

                <div class="row grid">

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_company_label', 'company');?>

                        <?php echo form_input($company);?>

                    </div>

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_phone_label', 'phone');?>

                        <?php echo form_input($phone);?>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="grid_6">

        <div class="module">

            <h2 class="text-primary"><span><?php echo lang('Authenticate_information'); ?></span></h2>
                
            <div class="module-body card-body">

                <p class="grid red"><?php echo lang('create_user_subheading');?></p>

                <?php if (!empty($message)): ?>

                    <div class="grid" id="infoMessage"><?php echo $message;?></div>
                    
                <?php endif ?>

                <div class="row grid">

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_email_label', 'email');?>

                        <?php echo form_input($email);?>

                    </div>

                    <div class="form-group grid_6">

                        <label for=""><?php echo lang('Default_language'); ?></label>

                        <?php echo form_dropdown($lang_default['name'], $options, $this->config->config['language'], 'class="'.$lang_default['class'].'"');?>

                    </div>

                </div>

                <div class="row grid">

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_password_label', 'password');?>

                        <?php echo form_input($password);?>

                    </div>

                    <div class="form-group grid_6">

                        <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
                        
                        <?php echo form_input($password_confirm);?>
                            
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="form-group grid_12 text-right">

        <?php echo form_submit('submit', lang('create_user_submit_btn'), 'class="submit-green uniform pull-right"');?>

    </div>

<?php echo form_close();?>