<?php
/*

	Plugin Name: WPC Love
	Plugin URI: http://wpcoder.com
	Description: Let your users show some love!
	Version: 1.0
	Author: Matt Vickers & WP Coder	
	Author URI: http://wpcoder.com
	License: GPL2

	Copyright 2011  Matt Vickers (email : matt@envexlabs.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/*

	                       .                          
	                     .o8                          
	 .oooo.o  .ooooo.  .o888oo oooo  oooo  oo.ooooo.  
	d88(  "8 d88' `88b   888   `888  `888   888' `88b 
	`"Y88b.  888ooo888   888    888   888   888   888 
	o.  )88b 888    .o   888 .  888   888   888   888 
	8""888P' `Y8bod8P'   "888"  `V88V"V8P'  888bod8P' 
	                                        888       
	                                       o888o      
	                                                  
*/

global $wpcl_db_version;
$wpcl_db_version = "1.0";

$wpcl_tablename = $wpdb->prefix . 'wpc_love';

define('PLUGIN_PATH', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)));

/*

	First time we install the plugin

*/

function wpcl_install(){
	
	global $wpdb, $wpcl_db_version, $wpcl_tablename;
	  
	$sql = "CREATE TABLE IF NOT EXISTS " . $wpcl_tablename . " (
		`id` MEDIUMINT( 9 ) NOT NULL AUTO_INCREMENT ,
		`post_id` MEDIUMINT( 9 ) NULL ,
		`ip` VARCHAR( 25 ) NULL ,
		PRIMARY KEY (  `id` )
		) ENGINE = MYISAM ;";
		
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
	dbDelta($sql);
	
	add_option("wpcl_db_version", $wpcl_db_version);
	
}
register_activation_hook(__FILE__, 'wpcl_install');

/*

	Run on init

*/

function wpcl_init(){

	wp_register_script( 'jpc_main', PLUGIN_PATH . '/inc/js/wpcl_main.js');

}
add_action('init', 'wpcl_init');

/*

	Load our custom javascript files

*/

function wpcl_add_scripts(){

	if (!is_admin()){
		wp_enqueue_script('jquery');
		wp_enqueue_script('jpc_main', PLUGIN_PATH . '/wpcl_main.js', array('jquery'), '1.0.0', 1);
	}

}
add_action('wp_print_scripts', 'wpcl_add_scripts');


/*

	                .o8                     o8o              
	               "888                     `"'              
	 .oooo.    .oooo888  ooo. .oo.  .oo.   oooo  ooo. .oo.   
	`P  )88b  d88' `888  `888P"Y88bP"Y88b  `888  `888P"Y88b  
	 .oP"888  888   888   888   888   888   888   888   888  
	d8(  888  888   888   888   888   888   888   888   888  
	`Y888""8o `Y8bod88P" o888o o888o o888o o888o o888o o888o 
                                                         

*/

// create custom plugin settings menu
add_action('admin_menu', 'wpcl_create_menu');

function wpcl_create_menu() {

	//create new sub menu
	//add_submenu_page( 'options-general.php', 'WPC Love', 'WPC Love', 'administrator', __FILE__, 'jpc_settings_page');

	add_menu_page('WPC Love', 'WPC Love', 'administrator', __FILE__, 'wpcl_settings_page', PLUGIN_PATH . '/img/heart.png');


	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	//register_setting( 'jpc_settings_groups', 'jpc_twitter_thumbnail_size' );
}

function wpcl_settings_page() { 

	include 'inc/templates/admin_panel.php';

}

/*

	oooo  oooo   .oooo.o  .oooo.    .oooooooo  .ooooo.  
	`888  `888  d88(  "8 `P  )88b  888' `88b  d88' `88b 
	 888   888  `"Y88b.   .oP"888  888   888  888ooo888 
	 888   888  o.  )88b d8(  888  `88bod8P'  888    .o 
	 `V88V"V8P' 8""888P' `Y888""8o `8oooooo.  `Y8bod8P' 
	                               d"     YD            
	                               "Y88888P'            

*/

/*

	Save the love to the DB

*/

function wpcl_save_love($post_id){

	global $wpdb, $wpcl_db_version, $wpcl_tablename;

	$post_id = mysql_real_escape_string($post_id);

	$save = $wpdb->insert( $wpcl_tablename, array( 'post_id' => $post_id, 'ip' => $_SERVER['REMOTE_ADDR'] ));
	
	if($save){
		
		return true;
		
	}
	
}

/*

	Check if the post is already been loved

*/

function is_loved($post_id){

	global $wpdb, $wpcl_tablename;

	$ip = $_SERVER['REMOTE_ADDR'];

	$loved = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpcl_tablename}` WHERE `post_id` = $post_id AND `ip` = '$ip'"));
	
	if($loved){
	
		return true;
		
	}

}

function get_most_loved($limit = 10){

	global $wpdb, $wpcl_tablename;

	$top = $wpdb->get_results("SELECT COUNT(*) as love_count, post_id FROM `{$wpcl_tablename}` GROUP BY `post_id` ORDER BY love_count DESC LIMIT 0, $limit");
	
	return $top;

}

function get_love_count($post_id){
	
	global $wpdb, $wpcl_tablename;
	
	$total = $wpdb->get_var("
		SELECT COUNT(*) as love_count
		FROM `{$wpcl_tablename}`
		WHERE `post_id` = '$post_id'
		LIMIT 1
	");
		
	return $total;
	
}

/*

	Display the actual hotness

*/

function wpcl_love($return = FALSE){

	global $post;
	
	$is_loved = is_loved($post->ID);
	
	$link = get_bloginfo('home');

	//$loved_class = $is_loved ? ' loved' : null;
	$loved_class = $is_loved ? 'loved' : null;
	
	$loved_text = $is_loved ? 'Loved!' : '<span id="loved_text_' . $post->ID . '">Love This Post</span>';
	$loved_text =  '<span id="love_count_' . $post->ID . '">' . get_love_count($post->ID) . '</span> loves this. ' . $loved_text;
	
	$content = sprintf('<a href="%s" id="wpcl_post_%d" class="wpcl_love_this %s">%s</a>', $link, $post->ID, $loved_class, $loved_text);
	
	//$content = '<a href="' . get_bloginfo('home') . '" id="wpcl_post_' . $post->ID . '" class="wpcl_love_this' . $loved_class . '">' . $loved_text . '</a>';
	
	if($return){
		return $content;
	}else{
		echo $content;
	}

}

add_filter( 'the_content', 'wpcl_love_the_content', 20 ); 

function wpcl_love_the_content($content){

	$content .= wpcl_love(TRUE);
	return $content;
	
}

