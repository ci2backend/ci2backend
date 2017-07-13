<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('change_password_heading');?></span></h2>
            
        <div class="module-body">

            <div id="infoMessage"><?php echo $message;?></div>
            
            <?php echo form_open("auth/change_password");?>

                <div class="grid_12 grid">

                    <div class="grid_12">

                        <div class="form-group grid_6">

                            <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
                            
                            <?php echo form_input($old_password);?>

                        </div>

                    </div>
            
                    <div class="grid_12">

                        <div class="form-group grid_6">
                          
                            <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
                            
                            <?php echo form_input($new_password);?>
                            
                        </div>

                    </div>

                    <div class="grid_12">

                        <div class="form-group grid_6">
                          
                            <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                        
                            <?php echo form_input($new_password_confirm);?>
                            
                        </div>

                    </div>
            
                    <?php echo form_input($user_id);?>
                  
                    <div class="form-group grid_12 text-right">
                    
                        <?php echo form_submit('submit', lang('change_password_submit_btn'), 'class="submit-green"');?>

                    </div>
                  
                </div>

            <?php echo form_close();?>
            
        </div>
        
    </div>
            
</div>