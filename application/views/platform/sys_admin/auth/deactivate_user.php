<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('deactivate_heading');?></span></h2>
        
        <div class="module-body">

			<?php echo form_open("auth/deactivate/".$user->id);?>

				<div class="grid_12 col-lg-12">

					<div class="table-responsive">

						<p>

							<?php echo sprintf(lang('deactivate_subheading'), $user->username);?>

						</p>

						<p>

						  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>

						    <input type="radio" name="confirm" value="yes" checked="checked" class="uniform" />

						    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>

						    <input type="radio" name="confirm" value="no" class="uniform" />

						</p>

						  	<?php echo form_hidden($csrf); ?>

						  	<?php echo form_hidden(array('id'=>$user->id)); ?>

						 <p>

						<?php echo form_submit('submit', lang('deactivate_submit_btn'), 'class="submit-green uniform"');?></p>

					</div>

				</div>

			<?php echo form_close();?>
			
		</div>

	</div>

</div>