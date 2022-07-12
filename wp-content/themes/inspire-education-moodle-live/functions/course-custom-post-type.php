<?php
/* Custom Post Type = Schedule

Developed by: Mark Augias
URL: http://markaugias.com/
*/


// let's create the function for the custom type
function course_custom_post() { 
	// creating (registering) the custom type 
	register_post_type( 'course_type', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
	 	// let's now add all the options for this post type
		array('labels' => array(
			'name' => __('Courses', 'markytheme'), /* This is the Title of the Group */
			'singular_name' => __('Course', 'markytheme'), /* This is the individual type */
			'all_items' => __('All Courses', 'markytheme'), /* the all items menu item */
			'add_new' => __('Add New', 'markytheme'), /* The add new menu item */
			'add_new_item' => __('Add New Course', 'markytheme'), /* Add New Display Title */
			'edit' => __( 'Edit', 'markytheme' ), /* Edit Dialog */
			'edit_item' => __('Edit Course', 'markytheme'), /* Edit Display Title */
			'new_item' => __('New Course', 'markytheme'), /* New Display Title */
			'view_item' => __('View Course', 'markytheme'), /* View Display Title */
			'search_items' => __('Search Courses', 'markytheme'), /* Search Custom Type Title */ 
			'not_found' =>  __('Nothing found in the Database.', 'markytheme'), /* This displays if there are no entries yet */ 
			'not_found_in_trash' => __('Nothing found in Trash', 'markytheme'), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'This is where you must create and manage all your Courses', 'markytheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 4, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => get_stylesheet_directory_uri() . '/assets/images/course-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'course-type', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => 'course', /* you can rename the slug here */
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
	
	/* this adds your post categories to your custom post type */
	// register_taxonomy_for_object_type('category', 'course_type');
	/* this adds your post tags to your custom post type */
	// register_taxonomy_for_object_type('post_tag', 'course_type');
	
} 

	// adding the function to the Wordpress init
	add_action( 'init', 'course_custom_post');
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	 
    
	// now let's add custom locations (these act like categories)
    register_taxonomy( 'course_location', 
    	array('course_type'), /* if you change the name of register_post_type( 'course_type', then you have to change this */
    	array('hierarchical' => true,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Course Locations', 'markytheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Course Location', 'markytheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Locations', 'markytheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Locations', 'markytheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Location', 'markytheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Location:', 'markytheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Location', 'markytheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Location', 'markytheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Location', 'markytheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Location Name', 'markytheme' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    	)
    );


    // now let's add custom course categories
    register_taxonomy( 'course_categories', 
    	array('course_type'), /* if you change the name of register_post_type( 'course_type', then you have to change this */
    	array('hierarchical' => true,    /* if this is false, it acts like tags */                
    		'labels' => array(
    			'name' => __( 'Course Categories', 'markytheme' ), /* name of the custom taxonomy */
    			'singular_name' => __( 'Course Category', 'markytheme' ), /* single taxonomy name */
    			'search_items' =>  __( 'Search Course Categories', 'markytheme' ), /* search title for taxomony */
    			'all_items' => __( 'All Course Categories', 'markytheme' ), /* all title for taxonomies */
    			'parent_item' => __( 'Parent Course Category', 'markytheme' ), /* parent title for taxonomy */
    			'parent_item_colon' => __( 'Parent Course Category:', 'markytheme' ), /* parent taxonomy title */
    			'edit_item' => __( 'Edit Course Category', 'markytheme' ), /* edit custom taxonomy title */
    			'update_item' => __( 'Update Course Category', 'markytheme' ), /* update title for taxonomy */
    			'add_new_item' => __( 'Add New Course Category', 'markytheme' ), /* add new title for taxonomy */
    			'new_item_name' => __( 'New Location Course Category', 'markytheme' ) /* name title for taxonomy */
    		),
    		'show_admin_column' => true,
    		'show_ui' => true,
    		'query_var' => true,
    	)
    ); 
    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */
	

?>
