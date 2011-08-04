<?php

/*

	This file just acts as a middle man between the plugin
	file and the AJAX request

*/


//This is beyond dumb - try and fix later
require('../../../../../wp-load.php' );
wpcl_install();

$save = wpcl_save_love($_POST['post_id']);

if($save){
	$response['loved'] = 1;
}

echo json_encode($response);