<div class="center_div grid_12 grid">

	<div class="grid_4 grid" style="margin-left: 35%">

	    <div class="module">

	        <h2 class="text-primary"><span><?php echo $this->lang->line('admin_login'); ?></span></h2>
	            
	        <div class="module-body">

	            <form action="<?php echo site_url('users/login'); ?>" class="grid grid_12" method="post" id="login">

	            	<p>

	                    <label><?php echo $this->lang->line('email'); ?></label>

	                    <input placeholder="<?php echo $this->lang->line('email_place_holder'); ?>" type="email" class="input-long uniform" style="width: 100%;" name="identity">


	                </p>

	                <p class="mrbot0px">

	                    <label for="password"><?php echo $this->lang->line('password'); ?></label>

	                    <input placeholder="<?php echo $this->lang->line('password_place_holder'); ?>" type="password" class="input-long password uniform" style="width: 100%;" name="password">

	                </p>

	                <div style="padding-bottom: 5px; margin-top: 10px;">

	                    <label class="inline-block" style="width: auto;"><input type="checkbox" class="uniform" name="REMENBER_ME" value=""> <?php echo $this->lang->line('remember_me'); ?> </label>

	                    <a class="pull-right" href="<?php echo site_url('auth/forgot_password'); ?>"><?php echo lang('login_forgot_password');?></a>

	                </div>
	                
	                <fieldset style="float: right;">

	                    <input type="submit" value="<?php echo $this->lang->line('login_btn'); ?>" class="submit-green uniform">

	                    <a class="submit-gray uniform" type="button" href="<?php echo site_url(); ?>" role="button"><?php echo $this->lang->line('cancel_btn'); ?></a>

	                </fieldset>

	            </form>
	            
	         </div> <!-- End .module-body -->

	    </div> <!-- End .module -->

	    <div style="clear:both;"></div>

	</div>

</div>