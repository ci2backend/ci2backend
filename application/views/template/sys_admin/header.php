<!DOCTYPE html>
<html>

    <head>

        <meta http-equiv="content-type" content="text/html; charset=utf-8" />

        <title>

            <?php fetch_title(); ?>

        </title>

        <link rel="shortcut icon" href="<?php echo base_url('themes/common/images');?>/favicon.ico" type="image/x-icon">

        <link rel="icon" href="<?php echo base_url('themes/common/images');?>/favicon.ico" type="image/x-icon">

        <?php fetch_common_stylesheet(); ?>

        <?php fetch_css(); ?>
        
        <script type="text/javascript">

            APP_BASE_URL = "<?php echo base_url(); ?>";

        </script>
        
        <script src="<?php echo base_url('themes/common/js');?>/jsconfig.js"></script>
        
    </head>
    <body>

        <div id="overlay" class="overlay" style="display: none;"></div>

    	<div class="wrap">
    
            <!-- Header -->
            <div id="header">
                
                <!-- Header. Main part -->
                <div id="header-main">

                    <!-- Header. Status part -->
                    <div id="header-status">
        
                        <div class="container_12 full-dimensions">
        
                            <div class="grid_8">
        
                                <img src="<?php echo base_url('themes/common/images'); ?>/ci2backend-logo.png" alt="Backend System Logo" width="35" height="35" style="float: left;">
        
                                <span class="site-title"><?php echo $this->lang->line('Sologan'); ?></span>
        
                            </div>
        
                            <div class="grid_4">
        
                                <?php if ($this->ion_auth->logged_in()) {

                                ?>
        
                                    <a href="<?php echo site_url('logout.html'); ?>" class="link icon-logout">
        
                                        <?php echo $this->lang->line('logout'); ?>
        
                                    </a>

                                    <a href="<?php echo base_url('profile.html'); ?>" class="link icon-user">
        
                                        <?php echo $user['first_name'].' '.$user['last_name']; ?>
        
                                    </a>
        
                                <?php

                                }
                                else{
                                ?>
        
                                    <a href="<?php echo site_url('login.html'); ?>" class="logout">
        
                                        <?php echo $this->lang->line('login'); ?>
        
                                    </a>
        
                                <?php
                                }
                                ?>
                                
                                <a href="<?php echo base_url(); ?>" class="link icon-left-site">
        
                                    <?php echo $this->lang->line('visit_site'); ?>
    
                                </a>

                            </div>
        
                        </div>
        
                        <div style="clear:both;"></div>
        
                    </div> <!-- End #header-status -->
                    <div class="container_12 full-dimensions">
    
                        <div class="grid_12">
    
                            <?php if ($this->ion_auth->logged_in()) {
                                ?>
    
                                    <?php echo fetch_menu_templates(); ?>

                            <?php
                            } ?>
    
                        </div><!-- End. .grid_12-->
    
                        <div style="clear: both;"></div>
    
                    </div><!-- End. .container_12 -->
    
                </div>
                <!-- End #header-main -->
    
                <div style="clear: both;"></div>
    
                <?php if ($this->ion_auth->logged_in()) {
    
                ?>
    
                    <?php echo fetch_sub_menu_templates(); ?>
    
                <?php

                } ?>
    
            </div> <!-- End #header -->
        <div class="container_12 full-dimensions .ajy-script">
            <?php

                if ($this->ion_auth->logged_in()) {

            ?>
                    <div class="grid_12">
                        
                        <?php echo $this->breadcrumbs->show(); ?>
                        
                    </div>

            <?php
            
                }
                
            ?>