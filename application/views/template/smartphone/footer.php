<?php  

	MY_Controller::load_common_view("common/$platform/messi_notify");

?>

	<?php if (isset($ext_js)) {

        foreach ($ext_js as $key => $js) {

    ?>

    <script src="<?php echo $js; ?>" type="text/javascript"></script>

    <?php

        }

    } ?>

    <?php if (isset($js_lang)) {

        foreach ($js_lang as $key => $js) {

    ?>

    <script src="<?php echo $js; ?>" type="text/javascript"></script>

    <?php

        }

    } ?>

<!-- Page Script -->
<?php echo $content_js; ?>
<!-- End page script -->
<?php if (isset($js_ckeditor)) {

    foreach ($js_ckeditor as $key => $js) {

?>

<script src="<?php echo $js; ?>" type="text/javascript"></script>

<?php

    }

} ?>

<script src="<?php echo base_url('themes/common/js/script.js');?>"></script>

</div>

</body>
</html>