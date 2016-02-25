<?php
/*
Plugin Name:        CASA People
Plugin URI:         https://github.com/tomalrussell/wp-casa-people
Description:        Add people to the site, with contact details and profile pictures, optionally associated with WordPress 'users'.
Version:            1.0.0
Author:             Tom Russell
Author URI:         https://github.com/tomalrussell

License:            MIT License
License URI:        http://opensource.org/licenses/MIT
*/

namespace Casa\People;

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

function load(){
	define( 'WP_CASA_PEOPLE_DIR', dirname( __FILE__ ) );
	$files = array(
		'load-templates.php',
		'post-type.php',
		'post-meta.php'
	);
	foreach($files as $file){
		require_once 'lib/'.$file;
	}

	if (is_admin()){
		add_action( 'admin_enqueue_scripts', __NAMESPACE__.'\\load_admin_style' );
	}
}

function load_admin_style() {
	wp_register_style( 'casa_people_css', plugin_dir_url( __FILE__ ) . '/admin/casa-people.css', false, '1.0.0' );
	wp_enqueue_style( 'casa_people_css' );
}

load();

function first_run() {
	// register post type
	Post\register();
	// set up URL structure for new 'reference' post type
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, __NAMESPACE__.'\\first_run' );

function last_run() {
	// clean up URL structure
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, __NAMESPACE__.'\\last_run' );