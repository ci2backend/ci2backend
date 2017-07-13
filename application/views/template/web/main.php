<?php

if (file_exists(APPPATH."views/template/$template/header".'.php')) {

	$this->load->view("template/$template/header");

}

?>

<?php echo $content?>

<?php

if (file_exists(APPPATH."views/template/$template/footer".'.php')) {

	$this->load->view("template/$template/footer");
	
}

?>