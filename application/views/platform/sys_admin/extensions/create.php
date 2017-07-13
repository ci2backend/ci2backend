<div class="grid_12">

	<div class="module">

		<h2 class="text-primary"><span>Create new extension</span></h2>

		<div class="module-body" style="position:relative;">

			<div role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#manual" aria-controls="manual" role="tab" data-toggle="tab">Manual creation</a>
					</li>
					<li role="presentation">
						<a href="#import" aria-controls="import" role="tab" data-toggle="tab">Import file</a>
					</li>
				</ul>
			
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="manual">
						<div class="grid row">
							<form class="form-horizontal" role="form" id="createExtension">
							    <div class="grid_4 grid">
							    	<div class="form-group">
								      	<label for="inputExtensionName" class="col-md-3 control-label">Extension name</label>
								      	<div class="col-md-9">
								          <input type="text" class="form-control" name="extension_name" id="inputExtensionName" placeholder="Enter extension name">
								          	<span class="help-block">
										        Use to searching extension
										    </span>
								      	</div>
								    </div>
								    <div class="form-group">
								      	<label for="inputExtensionKey" class="col-md-3 control-label">Extension key</label>
								      	<div class="col-md-9">
								          	<input type="text" class="form-control" name="extension_key"  id="inputExtensionKey" placeholder="Enter extension key">
								          	<span class="help-block">
										        Use to create folder name
										    </span>
								      	</div>
								    </div>
								    <div class="form-group">
								    	<label for="inputType" class="col-md-3 control-label">System loader</label>
								    	<div class="col-md-9">
									    	<div id="selector" data-toggle="buttons" class="btn-group btn-group-md" role="group" aria-label="Choose archive file type" style="">
		                                        <label class="btn btn-default active">
		                                    		<input type="radio" name="system_load" id="on" value="1" checked="checked">
		                                    		ON
		                                    	</label>
		                                        <label class="btn btn-default ">
		                                    		<input type="radio" name="system_load" id="off" value="0">
		                                    		OFF
		                                    	</label>
		                                     </div>
		                                    <span class="help-block">
										        Loading when render page
										    </span>
	                                     </div>
								    </div>
								    <div class="form-group">
								      <label for="inputType" class="col-md-3 control-label">Description</label>
								      <div class="col-md-9">
								          <textarea name="description" id="input" class="form-control" rows="3"></textarea>
								          <span class="help-block">
									        No more than 300 words
									      </span>
								      </div>
								    </div>
								    <div class="form-group">
									    <div class="col-md-12">
									    	<button type="submit" class="btn btn-primary pull-right">Create</button>
									    </div>
								    </div>
							    </div>
							    <div class="grid_8">
							    	<div id="elfinder_extension">
							    		<p class="text-center">Folder will generate when create extension</p>
									</div>
							    </div>	
							</form>

						</div>

					</div>

					<div role="tabpanel" class="tab-pane" id="import">
						<div class="grid">
							<button class="btn btn-primary position" type="submit" name="submit-all" value="Inport" id="submit-all"><span class="glyphicon glyphicon-cloud-upload"></span> Import</button>
							<!-- <div class="upload-drop-zone dropzone" id="myDropzone"> Or drag and drop files here </div> -->
							<form id="myDropzone" action="<?php echo site_url('extension/import'); ?>" enctype="multipart/form-data" method="POST" class="upload-drop-zone dropzone">
							    <!-- <input type="hidden" id ="access_key" name ="access_key" /> -->
							</form>
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>

</div>