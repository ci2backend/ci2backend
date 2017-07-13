<div class="fixed-top preview-tool"></div>

<div class="preview-box">

	<div class="tool-box">

		<form action="javascript:void(0);" method="POST" role="form" id="preview-form">

			<div class="form-group">

				<div class="col-md-12 panel-padding grid full-width">

					<label for="input" class="col-sm-12 control-label">Choose a template:</label>

					<select name="template_set" id="input" class="form-control uniform" required="required">

						<?php

							if (isset($templates)) {

								foreach ($templates as $key => $tmplate) {

									if ($tmplate->template_key == $template_set) {

						?>

										<option selected="selected" value="<?php echo @$tmplate->template_key; ?>"><?php echo @$tmplate->template_name; ?></option>

						<?php

									}
									else {

						?>

										<option value="<?php echo @$tmplate->template_key; ?>"><?php echo @$tmplate->template_name; ?></option>

						<?php
						
									}

								}

							}

						?>
						
					</select>

					</br>

				</div>

				<div class="col-md-12 panel-padding grid full-width">

					<label for="input" class="col-sm-12 control-label">Choose a platform:</label>

					<select name="platform_set" id="input" class="form-control uniform" required="required">

						<?php

							if (isset($platforms)) {

								foreach ($platforms as $key => $pform) {

									if ($pform->platform_key == $platform_set) {

						?>

										<option selected="selected" value="<?php echo @$pform->platform_key; ?>"><?php echo @$pform->platform_name; ?></option>

						<?php

									}
									else {

						?>

										<option value="<?php echo @$pform->platform_key; ?>"><?php echo @$pform->platform_name; ?></option>

						<?php
						
									}

								}

							}
						?>
						
					</select>

					</br>

				</div>

				<div class="col-md-12 extension-tool-box col-md-12 panel-padding grid full-width">

					<?php

						if (isset($extends)) {

							foreach ($extends as $key => $extend) {

								if ($extend == 'preview-tool') {

									continue;

								}

								if ($extend == 'bootstrap' || $extend == 'font-awesome4.5') {

					?>
									<div class="checkbox">

										<label>

											<input class="uniform" checked="checked" name="extend[]" type="checkbox" value="<?php echo @$extend; ?>">
											
											<?php echo @$extend; ?>

										</label>

									</div>
					<?php
								}
								else {

					?>
									<div class="checkbox">

										<label>

											<input class="uniform" name="extend[]" type="checkbox" value="<?php echo @$extend; ?>">
											
											<?php echo @$extend; ?>

										</label>

									</div>
					<?php
								}

							}

						}

					?>
				</div>

			</div>

			<div class="col-md-12 panel-padding grid full-width text-right pull-right" style="padding: 5px; margin-bottom: 10px;">

				<button type="submit" class="btn btn-primary uniform" name="load_extend"><?php echo lang('Reload') ?></button>
			
			</div>

		</form>

	</div>

</div>