<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span><?php echo $this->lang->line('profile'); ?></span></h2>
            
        <div class="module-body">

	        <div class="grid_12">

		        <ul class="nav nav-tabs" id="profile-tabs">

					<li class="nav-item <?php echo @$user_profile; ?>">

						<a data-target="#user_profile" data-toggle="tab" class="nav-link active"><?php echo lang('user_profile'); ?></a>
					
					</li>
					
					<li class="nav-item <?php echo @$user_settings; ?>">
						
						<a data-target="#user_settings" data-toggle="tab" class="nav-link"><?php echo lang('user_settings'); ?></a>
					
					</li>

				</ul>

				<div class="tab-content">

				    <div class="tab-pane <?php echo @$user_profile; ?>" id="user_profile">

				    	<?php echo $this->load->common("user/user_profile"); ?>

				    </div>

				    <div class="tab-pane <?php echo @$user_settings; ?>" id="user_settings">

				    	<?php echo $this->load->common("user/user_settings"); ?>

				    </div>

				</div>

	        </div>

        </div>
    
    </div>
	
</div>