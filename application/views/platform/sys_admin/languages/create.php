<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo lang('generate_language'); ?></span></h2>
            
        <div class="module-body card-body">

        	<?php echo form_ajax('languages/create', 'id="createLanguage"') ?>

        		<input type="hidden" name="callback_function" value="remove_selected">

        		<div class="grid_12">

        			<div class="panel-padding grid_6 grid full-width">

		        		<legend><?php echo lang('Add_new_country_language'); ?></legend>

		        		<div class="grid_12 grid">

			   				<div class="grid_12 grid">

					      		<label for="inputLang" class=""><?php echo lang('language_name'); ?> :</label>

					      		<select id="select-lang_key" data-placeholder="<?php echo lang('Choose_a_region'); ?>..." style="width:100%;" name="select_lang_key" class="chosen-select input-long extra">
						            
						            <?php foreach ($region_list as $key => $region): ?>

						            	<?php

						            		$alpha_arr = explode(' ', $region['name']);

						            		$region['alpha-2'] = strtolower(@$alpha_arr[0]);

						            	?>

						            	<option value='<?php echo json_encode($region); ?>'><?php echo $region['name'] ?></option>
						            
						            <?php endforeach ?>

								</select>

					      	</div>

					      	<div class="grid_12 grid">

					      		<label for="inputLang" class=""><?php echo lang('language_name'); ?> :</label>

					      		<input type="text" name="lang_display" id="inputLanguage" placeholder="<?php echo lang('language_name_placeholder'); ?>" class="input-long uniform" value="<?php echo @$region_list[0]['name']; ?>">

					      	</div>

					      	<div class="grid_12 grid">

					      		<label for="lang_key" class=""><?php echo lang('language_key'); ?> :</label>

					      		<input type="text" name="lang_key" id="lang_key" placeholder="<?php echo lang('language_key_placeholder'); ?>" class="input-long uniform modalGetValue" data-modal="#modal-lang_key" readonly="readonly" value="<?php echo strtolower(@$region_list[0]['code']); ?>">

					      	</div>

					      	<div class="grid_12 grid">

					      		<label for="inputLanguageFolder" class=""><?php echo lang('language_folder'); ?> :</label>

					      		<input type="text" name="lang_folder" id="inputLanguageFolder" placeholder="<?php echo lang('language_folder_placeholder'); ?>" class="input-long uniform" value="<?php echo strtolower(@$region_list[0]['name']); ?>">

					      	</div>

			   			</div>

		        	</div>

		        	<div class="panel-padding grid_6 grid full-width">

		        		<legend><?php echo lang('setting_in_object_coding'); ?></legend>

		        		<div class="grid_12 grid">

		        			<!-- <div class="checkbox">

		        				<label>

		        					<input type="checkbox" name="code_inform[]" value="php_lang" class="uniform">

		        					<?php echo lang('php_lang'); ?>

		        				</label>

		        			</div>

		        			<div class="checkbox">

		        				<label>

		        					<input type="checkbox" name="code_inform[]" value="js_lang" class="uniform">

		        					<?php echo lang('js_lang'); ?>

		        				</label>

		        			</div> -->

		        		</div>

		        	</div>

        		</div>

        		<div class="grid_12 grid text-right">

    				<fieldset class="pull-right">

						<input class="submit-green uniform" type="submit" value="<?php echo lang('create_language'); ?>">

						<a class="submit-green uniform" style="padding-left: 15px;" href="#" role="button"><?php echo lang('Back'); ?></a>
						
					</fieldset>

    			</div>

        	</form>

        </div>

    </div>

</div>