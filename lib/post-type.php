<?php
namespace Casa\People\Post;

function register(){
	$labels = array(
		'name' => 'People',
		'singular_name' => 'Person',
		'add_new_item' => 'Add New Person',
		'edit_item' => 'Edit Person',
		'new_item' => 'New Person',
		'view_item' => 'View Person',
		'not_found' => 'No people found',
		'not_found_in_trash' => 'No people found in Trash',
		'all_items' => 'All People',
		'featured_image' => 'Profile picture',
		'set_featured_image' => 'Set profile picture',
		'remove_featured_image' => 'Remove profile picture',
		'use_featured_image' => 'Use as profile picture'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_position' => 7,
		'menu_icon' => 'dashicons-id',
		'has_archive' => true,
		'rewrite' => array(
			'slug' => 'people'
		),
		'supports' => array(
			'title',
			'editor',
			'thumbnail'
		)
	);
	register_post_type('person', $args);
}
add_action('init', __NAMESPACE__.'\\register');