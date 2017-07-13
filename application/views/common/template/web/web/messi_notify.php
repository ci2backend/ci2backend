<?php 

	$error_flag_code = $this->session->userdata('error_flag_code');

	$error_mess_code = $this->session->userdata('error_mess_code');

	$title_mess_code = $this->session->userdata('title_mess_code');

	$type_mess_code = $this->session->userdata('type_mess_code');

	$error_timeout = $this->session->userdata('error_timeout');

	$is_modal_mess = $this->session->userdata('is_modal_mess');

?>
<input type="hidden" name="error_flag" value="<?php if (isset($error_flag_code)) 	{
	echo $error_flag_code;
}
else{
	echo 0;
} ?>" id="error_flag">

<input type="hidden" name="error_mess" value="<?php if (isset($error_mess_code)) {
	echo $error_mess_code;
}
else{
	echo '';
} ?>" id="error_mess">

<input type="hidden" name="title_mess" value="<?php if (isset($title_mess_code)) {
	echo $title_mess_code;
}
else{
	echo '';
} ?>" id="title_mess">

<input type="hidden" name="type_mess" value="<?php if (isset($type_mess_code)) {
	echo $type_mess_code;
}
else{
	echo '';
} ?>" id="type_mess">

<input type="hidden" name="error_timeout" value="<?php if (isset($error_timeout)) {
	echo $error_timeout;
}
else{
	echo '';
} ?>" id="error_timeout">

<input type="hidden" name="is_modal_mess" value="<?php if (isset($is_modal_mess)) {
	echo $is_modal_mess;
}
else{
	echo '';
} ?>" id="is_modal_mess">

<?php

	$this->session->unset_userdata('error_mess_code');

	$this->session->unset_userdata('error_flag_code');

	$this->session->unset_userdata('title_mess_code');

	$this->session->unset_userdata('type_mess_code');

	$this->session->unset_userdata('error_timeout');

	$this->session->unset_userdata('is_modal_mess');

?>