<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta property="og:title" content="<?php echo fetch_title(); ?>" />

    <meta property="og:type" content="article" />

    <meta property="og:url" content="<?php echo my_base_url(); ?>" />

    <meta property="og:description" content="" />
        
    <title>
        <?php echo fetch_title(); ?>
    </title>

    <link rel="shortcut icon" href="<?php echo base_url(TEMPLATE_PATH.@$template);?>/favicon.ico" type="image/x-icon">

    <link rel="icon" href="<?php echo base_url(TEMPLATE_PATH.@$template);?>/favicon.ico" type="image/x-icon">

    <?php fetch_common_stylesheet(); ?>

    <?php fetch_css(); ?>
        
    <script type="text/javascript">

        APP_BASE_URL = "<?php echo base_url(); ?>";

    </script>
        
    <script src="<?php echo base_url('themes/common/js');?>/jsconfig.js"></script>
    
</head>

<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><?php echo lang('System_title'); ?></a>
            </div>
    
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo my_base_url('admin.html'); ?>">Admin panel</a></li>
                    <?php if (!$this->ion_auth->logged_in()): ?>
                        <li><a href="<?php echo my_base_url('login.html'); ?>">Login</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo my_base_url('logout.html'); ?>">Logout</a></li>
                    <?php endif ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div>
    </nav>
    <section>