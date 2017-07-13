<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span><?php echo lang('Create_template'); ?></span></h2>

		<div class="module-body">

			<div class="panel-padding grid_6 grid">

				<legend><?php echo lang('Template_information'); ?></legend>

				<?php echo form_ajax('templates/create', 'id="create_templates"') ?>

					<div class="grid_12 grid">

						<label for=""><?php echo lang('Template_name'); ?></label>

						<input type="text" class="input-long uniform" name="template_name" value="" placeholder="<?php echo placeholder('Template_name'); ?>">

					</div>

					<div class="grid_12 grid">

						<label for=""><?php echo lang('Template_key'); ?></label>

						<input type="text" class="input-long uniform" name="template_key" value="" placeholder="<?php echo placeholder('Template_key'); ?>">

					</div>

					<div class="grid_12 grid">


						<label for=""><?php echo lang('Description'); ?></label>

						<textarea name="description" class="input-long uniform"></textarea>

					</div>

					<div class="grid_12 grid">

						<div class="grid_12">

							<label for="">Is backend template ?</label>

						</div>

					   	<div class="grid_6">

					   		<div class="checkbox">

					   			<label>

					   				<input type="radio" name="is_backend" value="1" checked="checked" class="uniform">
					   				
					   				<?php echo lang('Yes'); ?>

					   			</label>

					   		</div>

					   	</div>

					   	<div class="grid_6">

					   		<div class="checkbox">

					   			<label>

					   				<input type="radio" name="is_backend" value="0" checked="checked" class="uniform">
					   				
					   				<?php echo lang('No'); ?>

					   			</label>

					   		</div>

					   	</div>

				   	</div>

					<div class="grid_12 grid text-right">

					   	<div class="pad-bot-10">

							<input class="submit-green uniform" type="submit" value="<?php echo lang('Create_new'); ?>">

							<a type="button" class="btn uniform" href="<?php echo site_url('templates/index'); ?>"><?php echo lang('Back'); ?></a>

						</div>

					</div>

				<?php echo form_close(); ?>

			</div>

		</div>

	</div>

</div>