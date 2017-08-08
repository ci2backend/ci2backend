<!DOCTYPE html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta property="og:title" content="Job Rate System" />

    <meta property="og:type" content="article" />

    <meta property="og:url" content="<?php echo my_base_url(); ?>" />

    <meta property="og:description" content="" />
        
    <title>
        <?php
            if(!empty($this->page_title)){

                echo $this->page_title;

            }
            else{

                echo DEFAULT_PAGE_TITLE;
                
            }
        ?>
    </title>

    <link href="<?php echo base_url("themes/$platform/css");?>/common.css" rel="stylesheet">

    <?php if (isset($ext_css)) {

        foreach ($ext_css as $key => $css) {

    ?>

    <link rel="stylesheet" href="<?php echo $css; ?>">

    <?php

        }

    } ?>
    <?php if (isset($css_ckeditor)) {

        foreach ($css_ckeditor as $key => $css) {

    ?>

    <script src="<?php echo $css; ?>" type="text/javascript"></script>

    <?php

        }

    } ?>

    <?php echo $content_css; ?>

    <script type="text/javascript">
        APP_BASE_URL = '<?php echo my_base_url(); ?>';
    </script>

    <script src="<?php echo base_url('themes/common/js');?>/jsconfig.js"></script>

    <script src="<?php echo base_url("themes/$platform/js");?>/jquery.js"></script>
    
</head>

<body>
    
	<div class="wrap">