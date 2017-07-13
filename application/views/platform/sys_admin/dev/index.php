<div class="grid_12">

    <div class="module">

         <h2 class="text-primary"><span><?php echo $this->lang->line('main_system'); ?></span></h2>
            
         <div class="module-body">
            
            <div class="row">

                <div class="grid_12">

                    <div class="grid_6 no-border panel-padding">

                        <?php

                            if (isset($modules) && count($modules)) {

                                foreach ($modules as $key => $module) {

                                    $data['menu'] = $module;

                                    $this->load->common("menu/dashboard", false, $data);

                                }

                            }

                        ?>

                    </div>

                    <div class="grid_6">

                        <div class="panel-padding grid full-width">

                            <legend><?php echo lang('Logged_in_user_info'); ?></legend>

                            <div class="grid_12">

                                <p><?php echo lang('Full_name'); ?>: <?php echo $user['first_name'] .' '. $user['last_name']; ?></p>
                                
                                <p><?php echo lang('Username'); ?>: <?php echo $user['username']; ?></p>

                                <p><?php echo lang('Email'); ?>: <?php echo $user['email']; ?></p>

                                <p><?php echo lang('Last_access'); ?>: <?php echo date('Y-m-d H:i:s', $user['last_login']); ?></p>
                            
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>