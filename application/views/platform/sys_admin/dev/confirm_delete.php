<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Confirm_delete'); ?></span></h2>

		<div class="module-body">

			<div class="grid_12 grid">

				<?php echo form_open(); ?>

					<span class="notification n-attention"><?php echo lang('Data_deleted_deleted_will_be_recoverable_please_careful_to_this_action'); ?> !</span>

					<div class="grid_12">

						<input type="hidden" name="delete_confirm_code" value="<?php echo $delete_confirm_code; ?>">

						<input type="hidden" name="delete_confirm_target" value="<?php echo $delete_confirm_target; ?>">

				   		<div class="form-group pad-bot-10">

					   		<fieldset class="text-right">

								<input class="submit-green ajax_action uniform" type="submit" value="<?php echo lang('Confirm'); ?>" data-set='{"url":"index.php/dev/generate_controller", "form_id":"create_controller"}'>

								<a class="submit-green uniform" type="button" href="<?php echo @$uri_referrer; ?>" role="button"><?php echo lang('Back') ?></a>
								
							</fieldset>

						</div>

				   	</div>

				<?php echo form_close(); ?>

			</div>

		</div>

	</div>

</div>