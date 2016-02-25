<?php
namespace Casa\People\Templates;

function archive_template( $archive_template ){
	global $post;

	if ( is_post_type_archive('person') ){
		$theme_template_name = locate_template("archive-person.php");

		if( file_exists( $theme_template_name ) ){
			$single_template = $theme_template_name; // use theme file
		} else {
			$archive_template = WP_CASA_PEOPLE_DIR . '/templates/archive-person.php';
		}
	}
	return $archive_template;
}

function content_single_template( $single_template ){
	global $post;

	if ($post->post_type == 'person') {
		$theme_template_name = locate_template("content-single-person.php");

		if( file_exists( $theme_template_name ) ){
			$single_template = $theme_template_name; // use theme file
		} else {
			$single_template = WP_CASA_PEOPLE_DIR . '/templates/content-single-person.php';
		}
	}
	return $single_template;
}

if(get_option('wp_casa_people_use_plugin_templates') || true ){
	add_filter( 'archive_template', __NAMESPACE__.'\\archive_template' );
	add_filter('single_template', __NAMESPACE__.'\\content_single_template');
}
