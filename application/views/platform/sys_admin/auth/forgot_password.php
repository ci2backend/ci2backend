<div class="center_div grid_12 grid">

	<div class="grid_6 grid" style="margin-left: 25%">

	    <div class="module">

	        <h2 class="text-primary"><span><?php echo lang('forgot_password_heading');?></span></h2>
	            
	        <div class="module-body">

	         	<div class="grid_12">

	         		<?php echo form_open("auth/forgot_password");?>

		         		<div class="grid_12 grid">

		         			<?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?>

		         		</div>

						<div class="grid_12 grid">
							
							<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
							
							<?php echo form_input($identity);?>

						</div>

						<div class="grid_12 grid text-right">

							<?php echo form_submit('submit', lang('forgot_password_submit_btn'), 'class="submit-green"');?>

						</div>

					<?php echo form_close();?>

	         	</div>

			</div>
			
		</div>

	    <div style="clear:both;"></div>

	</div>

</div>