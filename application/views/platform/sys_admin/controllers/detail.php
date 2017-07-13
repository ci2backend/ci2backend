<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Controller'); ?></span></h2>

		<div class="module-body">

			<?php echo form_ajax('controllers/detail/'.$file_path.SLASH.$control_data['id']); ?>

				<div class="grid_12 grid panel-pading">

					<legend><?php echo lang('Controller_detail'); ?></legend>

					<input type="hidden" name="id" value="<?php echo $control_data['id']; ?>">
			
					<div class="grid_12 grid">

						<label for=""><?php echo lang('Controller'); ?></label>

						<input type="text" readonly="readonly" class="input-long" id="" value="<?php echo $control_data['controller_name']; ?>" placeholder="<?php echo placeholder('Controller'); ?>">

					</div>

					<div class="grid_12 grid">

						<label for=""><?php echo lang('Module'); ?></label>

						<input type="text" readonly="readonly" class="input-long" id="" placeholder="<?php echo placeholder('Module'); ?>">

					</div>

					<div class="grid_12 grid">

						<label for=""><?php echo lang('Template_name'); ?></label>

						<select name="template_key" id="template" class="input-long" required="required">

							<?php if (isset($templates) && count($templates)): ?>
								
								<?php foreach ($templates as $key => $tmpl): ?>

									<option <?php if ($tmpl['template_key'] == $control_data['template_key']): ?>

										<?php echo 'selected="selected"'; ?>

									<?php endif ?> value="<?php echo $tmpl['template_key']; ?>"><?php echo $tmpl['template_name'] ?></option>

								<?php endforeach ?>

							<?php endif ?>

						</select>

					</div>

					<div style="clear:both"></div>

					<div class="grid_12 text-right">
				
						<input type="submit" class="submit-green uniform" value="<?php echo lang('Save_change'); ?>">

					</div>

				</div>

			<?php echo form_close(); ?>

		</div>

	</div>

</div>