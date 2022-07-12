<?php

add_action('after_setup_theme','bones_ahoy', 15);
function bones_ahoy() {

    add_action('init', 'bones_head_cleanup');
    add_filter('the_generator', 'bones_rss_version');
    add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
    add_action('wp_head', 'bones_remove_recent_comments_style', 1);
    add_filter('gallery_style', 'bones_gallery_style');
    add_action('after_setup_theme','bones_theme_support');
    add_filter('the_content', 'bones_filter_ptags_on_images');
    add_filter( 'akismet_debug_log', '__return_false' );
}


function bones_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
  remove_action('wp_head', 'wp_shortlink_wp_head');
  add_filter('the_generator', '__return_false');
  add_filter('show_admin_bar','__return_false');
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

function bones_rss_version() { return ''; }

function bones_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

function bones_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

function bones_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}

function bones_theme_support() {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 300, 9999 );
	add_theme_support('automatic-feed-links');
}

function wp_nav_menu_no_ul() {
    $options = array(
        'echo' => false,
        'container' => false,
        'menu' => 'Main Nav',
        'fallback_cb'=> false
    );

    $menu = wp_nav_menu($options);
    echo preg_replace(array(
        '#^<ul[^>]*>#',
        '#</ul>$#'
    ), '', $menu);

}

function default_page_menu() {
   wp_list_pages('title_li=');
}

function bones_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

function bones_body_class($classes) {
  global $post;
  $post_id = get_the_id();
  $parents = get_post_ancestors( $post_id );
  $id = ($parents) ? $parents[count($parents)-1]: $post_id;
  $parent = get_post( $id );

  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  if ($parent) {
    if ('courses' == $parent->post_name) {
      $classes[] = $parent->post_name.'_page';
    }
  }

  if (is_shop()) {
    $classes[] = 'shop';
  }

  return $classes;
}

add_filter('body_class','bones_body_class');
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
    'id'            => 'sidebar-1',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h2 class="widgettitle">',
		'after_title' => '</h2>',
	));
}

add_action( 'init', 'register_my_menu' );
function register_my_menu() {
  add_theme_support( 'menus' );
  register_nav_menus(
    array(
      'main-nav' => __( 'Main nav' )
    )
  );
}

add_image_size( 'course-thumbnail',9999, 50 );
add_image_size( 'course-cat-thumbnail',80, 53, true );
add_image_size( 'course-cat-thumbnail-soft',80, 80 );
