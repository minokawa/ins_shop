<?php
/* Custom Post Type = Schedule

Developed by: Mark Augias
URL: http://markaugias.com/
*/


// let's create the function for the custom type
function schedule_custom_post() {
	// creating (registering) the custom type
	register_post_type( 'schedule_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Schedules', 'markytheme'), /* This is the Title of the Group */
			'singular_name' => __('Schedule', 'markytheme'), /* This is the individual type */
			'all_items' => __('All Schedules', 'markytheme'), /* the all items menu item */
			'add_new' => __('Add New', 'markytheme'), /* The add new menu item */
			'add_new_item' => __('Add New Schedule', 'markytheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'markytheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Schedule', 'markytheme'), /* Edit Display Title */
			'new_item' => __('New Schedule', 'markytheme'), /* New Display Title */
			'view_item' => __('View Schedule', 'markytheme'), /* View Display Title */
			'search_items' => __('Search Schedules', 'markytheme'), /* Search Custom Type Title */
			'not_found' =>  __('Nothing found in the Database.', 'markytheme'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'markytheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is where you must create and manage all your schedules', 'markytheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => get_stylesheet_directory_uri() . '/assets/images/schedule-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'schedule_type', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'schedule', /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				//'author',
				//'trackbacks',
				'custom-fields',
				//'comments',
				'revisions',
				'page-attributes', // (menu order, hierarchical must be true to show Parent option)
				//'post-formats'
				)
	 	) /* end of options */
	); /* end of register post type */



}

	add_action( 'init', 'schedule_custom_post');



?>
