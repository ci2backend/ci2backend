<?php

if (file_exists(APPPATH."views/template/$template_name/header".'.php')) {

	$this->load->view("template/$template_name/header");

}

?>

<?php echo $content?>

<?php

if (file_exists(APPPATH."views/template/$template_name/footer".'.php')) {

	$this->load->view("template/$template_name/footer");
	
}

?>