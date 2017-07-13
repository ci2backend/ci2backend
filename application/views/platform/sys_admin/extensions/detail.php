<div class="grid_12">

	<div class="module card style-default-bright">

		<h2 class="text-primary"><span>Extension: <?php echo $extension['extension_name']; ?></span></h2>

		<div class="module-body">

			<div class="grid_12 grid">

				<div role="tabpanel">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">

						<li role="presentation" class="active">

							<a href="#read_me" aria-controls="read_me" role="tab" data-toggle="tab">README.md</a>
						
						</li>

						<li role="presentation">

							<a href="#files" aria-controls="files" data-loadded="0" role="tab" data-toggle="tab">Files(<?php echo $extension["total_files"]; ?>)</a>
						
						</li>

						<li role="presentation">

							<a href="#changelog" aria-controls="changelog" role="tab" data-toggle="tab">Changelog</a>
						
						</li>

						<li role="presentation">

							<a href="#license" aria-controls="license" role="tab" data-toggle="tab">License</a>
						
						</li>

						
						<li role="presentation">

							<a href="#guide" aria-controls="guide" role="tab" data-toggle="tab">Contribution guide</a>
						
						</li>

					</ul>
				
					<!-- Tab panes -->
					<div class="tab-content">

						<div role="tabpanel" class="tab-pane active" id="read_me">

							<div class="grid_12 grid">

								<?php echo @$extension['read_me']; ?>

							</div>

						</div>

						<div role="tabpanel" class="tab-pane" id="files">

							<div class="grid">

								<div id="elfinder_extension" class="">

						    		<p class="text-center"><?php echo lang('Folder_will_generate_when_create_extension') ?></p>

								</div>

							</div>

						</div>

						<div role="tabpanel" class="tab-pane" id="changelog">

							<div class="grid_12 grid">

								<?php echo @$extension['changelog']; ?>

							</div>

						</div>

						<div role="tabpanel" class="tab-pane" id="license">

							<div class="grid_12 grid">

								<?php echo @$extension['license']; ?>

							</div>

						</div>

						<div role="tabpanel" class="tab-pane" id="guide">

							<div class="grid_12 grid">

								<?php echo @$extension['contribution']; ?>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>