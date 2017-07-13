<div class="grid_12">

    <div class="module">

        <h2 class="text-primary"><span>Main System</span></h2>
            
        <div class="module-body">

            <div class="grid_12">

                <ul class="nav nav-tabs" id="myTab" data-toggle="tabs">

				    <li class="<?php echo @$configure ?>">

				    	<a data-target="#configure" data-toggle="tab"><?php echo lang('Configure'); ?></a>

				    </li>

				    <li class="<?php echo @$database_settings ?>">

				    	<a data-target="#database_settings" data-toggle="tab"><?php echo lang('Database_setting'); ?></a>

				    </li>

				    <li class="<?php echo @$constant_define ?>">

				    	<a data-target="#constant_define" data-toggle="tab"><?php echo lang('Constant_define'); ?></a>

				    </li>

				    <li class="<?php echo @$email_configure ?>">

				    	<a data-target="#email_configure" data-toggle="tab"><?php echo lang('Email_configure'); ?></a>

				    </li>

				    <li class="<?php echo @$site_settings ?>">

				    	<a data-target="#site_settings" data-toggle="tab"><?php echo lang('Site_setting'); ?></a>

				    </li>

				</ul>

				<div class="tab-content">

				    <div class="tab-pane <?php echo @$configure; ?>" id="configure">

				    	<?php echo $this->load->common("setting/configure"); ?>

				    </div>

				    <div class="tab-pane <?php echo @$database_settings; ?>" id="database_settings">

				    	<?php echo $this->load->common("setting/database_settings"); ?>

				    </div>

				    <div class="tab-pane <?php echo @$constant_define; ?>" id="constant_define">

				    	<?php echo $this->load->common("setting/constant_define"); ?>

				    </div>

				    <div class="tab-pane <?php echo @$site_settings; ?>" id="site_settings">

				    	<?php echo $this->load->common("setting/site_settings"); ?>

				    </div>

				    <div class="tab-pane <?php echo @$email_configure; ?>" id="email_configure">

				    	<?php echo $this->load->common("setting/email_configure"); ?>

				    </div>

				</div>

            </div>
            
        </div>
    
    </div>
    
</div>