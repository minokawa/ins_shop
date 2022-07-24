<?php
/**
 * @package WordPress
 * @subpackage Starkers
 */

require_once(get_template_directory().'/assets/theme_setup.php'); // if you remove this, the site will break, LOL!!!
require_once(get_template_directory().'/functions/schedule-custom-post-type.php'); //Load custom post types
require_once(get_template_directory().'/functions/course-custom-post-type.php'); //Load custom post
require_once(get_template_directory().'/functions/woocommerce.php'); // Woocommerce specific
require_once(get_template_directory().'/functions/product_modal_api/bootstrap.php'); //
require_once(get_template_directory().'/functions/custom_fields/product_page_details.php'); //
require_once(get_template_directory().'/functions/custom-price-string.php'); //

function custom_template_redirect() {
	if( is_front_page() ||  is_home()) ://check is shop page.
			wp_redirect( home_url( '/shop/' ) );
	endif;
}
add_action( 'template_redirect', 'custom_template_redirect' );
/* Bottom of course page */
function print_coursepage($parent_id) {
    $indexexclude ='';
    $the_query = new WP_Query( array(
      'numberposts' => -1,
      'post_type'   => 'page',
      'meta_key'    => 'hide-page-index',
      'meta_value'  => '1'
    ) );

    if( $the_query->have_posts() ):
      while( $the_query->have_posts() ) : $the_query->the_post();
            $indexexclude .= get_the_ID().",";
      endwhile;
    endif;

    $toexclude = rtrim($indexexclude, ',');

    $courses = get_pages(array('depth=1&child_of=' . $parent_id)); // Gets all the child pages of the courses page
    if(!empty($courses)) {
           echo '<ul class="clearfix">';
           foreach($courses as $page) {
              if($page->post_parent==$parent_id) {
                       	echo '<li>';
                       	echo '<h5 class="test"><a href="' .get_page_link($page->ID) . '">' . $page->post_title . '</a></h5>';
						echo '<ul>';
						echo wp_list_pages('title_li=&depth=1&exclude='.$toexclude.'&child_of=' .$page->ID);
						echo '</ul>';
                       	echo '</li>';
              }
           }
           echo '</ul>';
   }
 unset($excludedcourseIDs);
}

function print_coursecatpage($parent_id) {
	// Keeping jsut because its referenced by another file
  return;
}

// add the action
add_action( 'woocommerce_thankyou', 'action_woocommerce_thankyou', 10, 1 );
function action_woocommerce_thankyou( $order_get_id ) {
    setcookie("checkout_step", "", time() - 3600);
};

// Changing excerpt length
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function print_coursecats($parent_id) {
	$courses = get_pages(array('child_of=' . $parent_id));
	if(!empty($courses)) {
		echo '<ul id="category-tabs" class="clearfix">';
		echo '<li id="shop_link"><a title="shop" class="button alt" href="/shop" title="">Shop - Enrol Here Now!</a></li>';
		foreach($courses as $page) {
			if($page->post_parent==$parent_id) {
			echo '<li>';
				echo '<a href="' . get_page_link($page->ID) . '">' . $page->post_title . '</a>';
				echo get_the_post_thumbnail($page->ID, 'course-cat-thumbnail');
			echo '</li>';
			}
		}
		echo '</ul>';
	}
}

add_filter('the_excerpt', 'replace_excerpt');
function replace_excerpt($content) {
	return str_replace('[...]', '<a class="readmore" href="'. get_permalink() .'" title="learn more">learn more</a>', $content);
}

// TAXONIMIES
add_action( 'init', 'build_taxonomies', 0 );
function build_taxonomies() {
	register_taxonomy('course', 'page', array(
																					'hierarchical' => true,
																					'label' => 'Course Categories',
																					'query_var' => true,
																					'rewrite' => true
																			));
}

//If is page or subpage of $my_page, works with both ID or name.
if (!function_exists('is_course')) {
	function is_course($my_page) {
		global $post, $wpdb;
		$grand_parent = '';
		$post = is_singular() ? get_queried_object() : false;
		if ( ! empty($post) && is_a($post, 'WP_Post') ) {
			if ($post->post_parent) {
				$grand_parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE ID = '".$post->post_parent."' AND post_type = 'page'");
			}
		}
		// If you pass in a string, get the page ID of $my_page to use below
		if (is_numeric($my_page)==false) {
			$my_page = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$my_page."' AND post_type = 'page'");
		}
		// If this is $my_page or the child or grandchild of $my_page return true
		if ( $grand_parent == $my_page ) {
				return true;
		}
		// Else return false
		return false;
	}
}

//If is page or subpage of $my_page, works with both ID or name.
if (!function_exists('is_page_sub')) {
	function is_page_sub($sub_page) {
		global $post, $wpdb;
		$grand_parent = $wpdb->get_var("SELECT post_parent FROM $wpdb->posts WHERE ID = '".$post->post_parent."' AND post_type = 'page'");
		if (is_numeric($my_page)==false) {
			$my_page = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$my_page."' AND post_type = 'page'");
		}
		if ( is_page($my_page) || $post->post_parent == $my_page) { return true; }
		return false;
	}
}

/*
*  Create an advanced sub page called 'Footer' that sits under the General options menu
*/
if( function_exists('acf_add_options_sub_page') ){
	acf_add_options_sub_page(array(
		'title' => 'Banner Adverts',
		'parent' => 'options-general.php',
		'capability' => 'manage_options'
	));
}

add_filter('relevanssi_hits_filter', 'remove_hidden');
function remove_hidden($params){
  $ravers = get_pages(array('child_of=41'));
  foreach($params[0] as $result){
    $hit = $result->ID;

    foreach($ravers as $raver){
      if ($hit == $raver->ID){
        $visible_posts[] = $raver->ID;
      }
    }
  }
  return(array($visible_posts));
}

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
    global $post;
  return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read the full post</a>';
}


/** Add Custom Field To Category Form */
add_action( 'category_add_form_fields', 'category_form_custom_field_add', 10 );
function category_form_custom_field_add( $taxonomy ) { ?>
	<div class="form-field">
		<label for="image_url">Image URL</label>
		<input name="image_url" id="image_url" type="text" value="" size="40" aria-required="true" />
		<p class="description">This image will be the banner shown on the category page.</p>
	</div>
<?php
}

add_action( 'category_edit_form_fields', 'category_form_custom_field_edit', 10, 2 );
function category_form_custom_field_edit( $tag, $taxonomy ) {
  $option_name = 'image_url_' . $tag->term_id;
  $image_url = get_option( $option_name );?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="image_url">Image URL</label></th>
		<td>
			<input type="text" name="image_url" id="image_url" value="<?php echo esc_attr( $image_url ) ? esc_attr( $image_url ) : ''; ?>" size="40" aria-required="true" />
			<p class="description">This image will be the banner shown on the category page.</p>
		</td>
	</tr>
<?php
}

/** Save Custom Field Of Category Form */
add_action( 'created_category', 'category_form_custom_field_save', 10, 2 );
add_action( 'edited_category', 'category_form_custom_field_save', 10, 2 );
function category_form_custom_field_save( $term_id, $tt_id ) {
  if ( isset( $_POST['image_url'] ) ) {
    $option_name = 'image_url_' . $term_id;
    update_option( $option_name, $_POST['image_url'] );
  }
}


// Preview email templates in browser
add_action('wp_ajax_previewemail', 'previewEmail');
function previewEmail() {

 if (!is_admin()) { return null; }

	$default_path = WC()->plugin_path() . '/templates/';
	$files = scandir($default_path . 'emails');
	$exclude = array( '.', '..', 'email-header.php', 'email-footer.php','plain' );
	$list = array_diff($files,$exclude);
	?><form method="get" action="<?php echo site_url(); ?>/wp-admin/admin-ajax.php">
	<input type="hidden" name="order" value="593">
	<input type="hidden" name="action" value="previewemail">
	<select name="file">
	<?php
	foreach( $list as $item ){ ?>
		<option value="<?php echo $item; ?>"><?php echo str_replace('.php', '', $item); ?></option>
	<?php } ?>
	</select><input type="submit" value="Go"></form><?php
	global $order;
	$order = new WC_Order($_GET['order']);
	wc_get_template( 'emails/email-header.php', array( 'order' => $order ) );
	wc_get_template( 'emails/'.$_GET['file'], array( 'order' => $order ) );
	wc_get_template( 'emails/email-footer.php', array( 'order' => $order ) );
}

add_action( 'wp_enqueue_scripts', 'load_inspire_assets' );

function load_inspire_assets() {
	$cachebust =  1.41;
	$translation_array = get_sku_json();
	wp_enqueue_style('legacy-stylesheet', get_stylesheet_directory_uri() . '/assets/css/legacy-style.css', array(),  $cachebust , 'all');
	wp_enqueue_style('font-awesome-free', '//use.fontawesome.com/releases/v5.12.0/css/all.css' );
	wp_enqueue_style('main-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(),  $cachebust , );
	wp_enqueue_style('up-stylesheet', get_template_directory_uri() . '/assets/css/up-style.css', array(), $cachebust ,);
	load_woo_js_assets();
	wp_deregister_script('jquery');
	wp_register_script('CryptoJS', 'https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js', null, null, true );
	wp_enqueue_script('js_cookie', 'https://cdnjs.cloudflare.com/ajax/libs/js-cookie/3.0.1/js.cookie.min.js', array(), null, false);
	wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), null, false);
	wp_enqueue_script('vendors', get_template_directory_uri() . '/assets/scripts/vendors.js', array(),  $cachebust , true );
	wp_register_script('inspire_legacy', get_template_directory_uri() . '/assets/scripts/legacy-script.js', array ( 'jquery' ),  2.3, true );
	$home =  get_home_url();


	wp_add_inline_script('inspire_legacy', 'const product_look_up = ' . json_encode($translation_array) , 'before' );


	wp_add_inline_script( 'inspire_legacy', 'const home_url = "' .$home .'"' , 'before' );

	wp_enqueue_script('inspire_script', get_template_directory_uri() . '/assets/scripts/inspire_script.js', array ( 'jquery', 'wc-add-to-cart-variation' ), 2.3, true);
	wp_enqueue_script('CryptoJS');
	wp_enqueue_script('inspire_legacy' );
}

function load_woo_js_assets(){
	if (!is_admin()) {
		if ( function_exists( 'is_woocommerce' ) ) {
			wp_dequeue_script( 'wc_price_slider' );
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_script( 'fancybox' );
			wp_dequeue_script( 'jqueryui' );

			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_shop()) {
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'wc-checkout' );
				wp_dequeue_script( 'wc-add-to-cart-variation' );
				wp_dequeue_script( 'wc-single-product' );
				wp_dequeue_script( 'wc-cart' );
				wp_dequeue_script( 'wc-chosen' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
			}
		}

		wp_dequeue_script('ts_fab_js');
		wp_dequeue_style( 'woocommerce-layout' );
		if ( function_exists( 'is_woocommerce' ) ) {
			wp_dequeue_style( 'woocommerce_fancybox_styles' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );

			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_style( 'woocommerce_frontend_styles' );
				wp_dequeue_style( 'woocommerce_chosen_styles' );
				wp_dequeue_style( 'woocommerce-smallscreen' );

				wp_dequeue_style( 'woocommerce-general' );
			}
		}

		wp_dequeue_style('yarppWidgetCss');
		wp_dequeue_style('sociablecss');
		wp_dequeue_style('ts_fab_css');
		wp_dequeue_style('vtprd-front-end-style');

		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

function get_sku_json(){
	$sku_array = '{
		"INS01656" : "Diploma of Accounting",
		"INS01926" : "Cert IV WHS",
		"INS01558" : "Assessor Skill Set",
		"INS01752" : "Cert III Accounts Admin",
		"INS01128" : "Cert III Early Childhood Education",
		"INS01147" : "Cert III Ed Support",
		"INS01980" : "Cert III Individual Support (Ageing)",
		"INS02098" : "Cert III Individual Support (Disability)",
		"INS00798" : "Cert III Individual Support (Home & Community)",
		"INS01603" : "Cert IV Accounting and Bookkeeping",
		"INS01202" : "Cert IV Ageing Support",
		"INS01473" : "Cert IV Business",
		"INS00601" : "Cert IV Business Admin",
		"INS01484" : "Cert IV Disability",
		"INS00352" : "Cert IV HR",
		"INS02172" : "Cert IV Marketing and Communication",
		"INS01773" : "Cert IV Leadership and Management",
		"INS00702" : "Cert IV Project Management Practice",
		"INS01235" : "Cert IV TAE",
		"INS01863" : "Cert IV TESOL",
		"INS01569" : "Design and Develop Assessment Tools",
		"INS01178" : "Diploma Community Services",
		"INS01079" : "Diploma Early Childhood Education",
		"INS01774" : "Diploma Leadership and Management",
		"INS00711" : "Diploma Project Management",
		"INS01405" : "Diploma Training Design",
		"INS00584" : "Diploma WHS",
		"INS00590,INS00584": "Diploma WHS",
		"INS02004" : "Infection Control Training",
		"INS02005" : "Infection Control Training",
		"INS02006" : "Infection Control Training",
		"INS02211" : "HLTINF001 Unit",
		"INS01303" : "TAE40110 to TAE40116 Upgrade",
		"INS01579" : "TAE40110 to TAE40116 Upgrade",
		"INS01442" : "TAE40110 to TAE40116 Upgrade",
		"INS01532" : "TAE40110 to TAE40116 Upgrade",
		"INS01535,INS00720" : "TAE40110 to TAE40116 Upgrade",
		"INS01518" : "TAE40110 to TAE40116 Upgrade",
		"INS01536" : "TAE40110 to TAE40116 Upgrade",
		"INS01537,INS00721" : "TAE40110 to TAE40116 Upgrade",
		"INS00720" : "TAELLN411 Unit",
		"INS00721" : "TAELLN411 Unit",
		"INS00417" : "TAELLN411 Unit",
		"INS01966,INS01636" : "Cert IV TAE",
		"INS01966,INS01636,INS01637" : "Cert IV TAE",
		"INS01966,INS01636,INS01637,INS01638" : "Cert IV TAE",
		"INS01966,INS01636,INS01637,INS01638,INS01967" : "Cert IV TAE",
		"INS01966,INS01968" : "Cert IV TAE",
		"INS01966,INS01968,INS01969" : "Cert IV TAE",
		"INS01966,INS01968,INS01969,INS01970" : "Cert IV TAE",
		"INS01966,INS01968,INS01969,INS01970,INS01971" : "Cert IV TAE",
		"INS01450" : "Cert IV TAE",
		"INS01918" : "Cert IV TAE",
		"INS01707" : "Cert IV Accounting and Bookkeeping",
		"INS01693,INS01681" : "Cert IV Accounting and Bookkeeping",
		"INS01890" : "Cert IV Accounting and Bookkeeping",
		"INS01603,INS01890" : "Cert IV Accounting and Bookkeeping",
		"INS00783,INS00798" : "Cert III Individual Support (Home & Community)",
		"INS01952" : "Cert III Individual Support (Ageing)",
		"INS01953" : "Cert III Individual Support (Ageing)",
		"INS01954" : "Cert III Individual Support (Ageing)",
		"INS01955" : "Cert III Individual Support (Ageing)",
		"INS01944" : "Cert III Ed Support",
		"INS01945" : "Cert III Ed Support",
		"INS01946" : "Cert III Ed Support",
		"INS01947" : "Cert III Ed Support",
		"INS01948" : "Cert III Early Childhood Education",
		"INS01949" : "Cert III Early Childhood Education",
		"INS01950" : "Cert III Early Childhood Education",
		"INS01951" : "Cert III Early Childhood Education",
		"INS02000" : "Certificate IV in Disability"
	}';

	return json_decode($sku_array, true);
}

// Add cart content as Cookies
add_action('woocommerce_add_to_cart', 'inspire_custom_add_to_cart');
function inspire_custom_add_to_cart() {
  global $woocommerce;
  $items = $woocommerce->cart->get_cart();
  foreach($items as $item => $values) {
    $_product =  wc_get_product( $values['data']->get_id());
    setcookie("product", $_product->get_sku(), time()+3600, "/","", 0);
  }
  setcookie("apiKey", get_option('marketo_api_key'), time()+3600, "/","", 0);
}

add_action('admin_init', 'my_general_section');
function my_general_section() {
	add_settings_section(
			'marketo_settings_section',     // Section ID
			'Marketo Munchin API Settings', // Section Title
			'api_key_options_callback',     // Callback
			'general'
	);
	add_settings_field(
			'marketo_api_key',
			'API Key',                  // Label
			'marketo_api_key_callback', // !important - This is where the args go!
			'general',                  // Page it will be displayed (General Settings)
			'marketo_settings_section', // Name of our section
			array(                      // The $args
					'marketo_api_key'
			)
	);
	register_setting('general','marketo_api_key', 'esc_attr');
}

function api_key_options_callback() {
	echo '<p>Marketo Munchkin API General Settings</p>';
}

function marketo_api_key_callback($args) {
	$option = get_option($args[0]);
	echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

add_filter('woocommerce_checkout_get_value','__return_empty_string',10);

/*
This adds specifity/weight to update-style.css
'inspire-up'
*/
function add_update_class($classes) {
  $classes[] = 'inspire-up';
  return $classes;
}

add_filter('body_class', 'add_update_class');


function inspire_disable_payment_method( $posted_data) {

	global $woocommerce;
	$post = array();
	$vars = explode('&', $posted_data);
	foreach ($vars as $k => $value){
			$v = explode('=', urldecode($value));
			$post[$v[0]] = $v[1];
	}

	$company_invoice_flag = $post['shiptobilling'];
	$payment_method = $post['payment_method'];

	if ($company_invoice_flag == "on") {
		remove_filter('woocommerce_cart_item_subtotal', 'disable_invoice' );
		add_filter('woocommerce_available_payment_gateways', 'disable_non_invoice', 99, 1);
	}else{
		remove_filter('woocommerce_cart_item_subtotal', 'disable_non_invoice' );
		add_filter('woocommerce_available_payment_gateways', 'disable_invoice', 99, 1);
	}
}


function disable_non_invoice( $available_gateways ) {
	$check_out_details = WC()->checkout->checkout_fields;

		unset($available_gateways['cod']);
		unset($available_gateways['paypal']);
		unset($available_gateways['bacs']);
		unset($available_gateways['paypal_pro_payflow']);

	 return $available_gateways;
}


function disable_invoice( $available_gateways ) {
	$check_out_details = WC()->checkout->checkout_fields;
		unset($available_gateways['invoice']);
	  return $available_gateways;
}

add_action('woocommerce_checkout_update_order_review', 'inspire_disable_payment_method');


function get_woo_country_options(){
  global $woocommerce;
	$countries_obj   = new WC_Countries();
	$countries   = $countries_obj->__get('countries');
  return  $countries;
}

if( function_exists('acf_add_options_sub_page') ){
	acf_add_options_sub_page(array(
		'title' => 'Add To Cart Links',
		'parent' => 'options-general.php',
		'capability' => 'manage_options'
	));
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'inspire/v1', '/campaign-checkout/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'inspire_campaign_checkout',
		'permission_callback' => '__return_true',
		'args' => array(
      'id' => array(
        'validate_callback' => function($param, $request, $key) {
          return is_numeric( $param );
        }
      ),
    ),
  ));
});

function inspire_campaign_checkout(WP_REST_Request  $request ){
		$product_id= $request->get_param( 'id' );
		defined( 'WC_ABSPATH' ) || exit;
    // Load cart functions which are loaded only on the front-end.
    include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
    include_once WC_ABSPATH . 'includes/class-wc-cart.php';
		$enabled_products = [];
    if ( is_null( WC()->cart ) ) {

				$repeater = 'courses_to_checkout';

				$meta = get_field( 'courses_to_checkout', 'options');
				$enabled_products = wp_list_pluck($meta, 'product', 'product');
        wc_load_cart();
    }

		if(in_array($product_id, $enabled_products )){
			WC()->cart->add_to_cart($product_id);
		}

		$url  = WC()->cart->get_checkout_url();
		if ( wp_redirect( $url ) ) {
				exit;
		}
}


add_action('acf/save_post', 'update_campaign_checkout_message');

function update_campaign_checkout_message($post_id) {

	if ( $post_id != "options") {
		return;
	}

	$repeater = 'courses_to_checkout';

	$meta = get_field($repeater, $post_id);
	$count = count(get_field( $repeater, $post_id));
	$value = [];
	for ($i=0; $i<$count; $i++) {
		$rest =  get_rest_url( null, 'inspire/v1/campaign-checkout/' );
		$value[$i] = array(
				'field_62961770ff13f' => $meta[$i]['meta'],
				'field_629617f67f5f4' => $rest . $meta[$i]['product']
		);
  }

	$res = update_field($repeater, $value, $post_id);
}


if( function_exists('acf_add_local_field_group') ){
	acf_add_local_field_group(array(
		'key' => 'group_62960eda298d4',
		'title' => 'Product Focus Settings',
		'fields' => array(
			array(
				'key' => 'field_62960efe7700b',
				'label' => 'Courses to auto checkout',
				'name' => 'courses_to_checkout',
				'type' => 'repeater',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => '',
				'sub_fields' => array(
					array(
						'key' => 'field_62961770ff13f',
						'label' => 'Product',
						'name' => 'product',
						'type' => 'post_object',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
							0 => 'product',
						),
						'taxonomy' => '',
						'allow_null' => 0,
						'multiple' => 0,
						'return_format' => 'id',
						'ui' => 1,
					),
					array(
						'key' => 'field_629617f67f5f4',
						'label' => 'URL',
						'name' => 'generated_url',
						'type' => 'text',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '-',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					)
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-add-to-cart-links',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'acf_after_title',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
}

function get_cross_sell_products($atts = [], $content = null, $tag = '') {
	global $product;
	$crosssells = $product->get_cross_sell_ids();
	$atts = array_change_key_case( (array) $atts, CASE_LOWER );

	$cross_sell_atts = shortcode_atts(
			array(
				'title' => 'Recommended courses:',
			), $atts, $tag
	);

	$thumb = '<div class="splide cross-sell-wrapper">		<h4>'.$cross_sell_atts['title'].'</h4> <div class="splide__track"><div class="splide__list">';

	foreach($crosssells as $crosssell_id){
		$cross_sell_product = wc_get_product( $crosssell_id);
		$permalink = get_post_permalink($crosssell_id);
		if($cross_sell_product->is_type( 'external' )){
			$permalink = $cross_sell_product->get_product_url();
		}
		$img =  get_the_post_thumbnail($crosssell_id, 'full', array( 'class' => '' ) );
		$title =  get_the_title($crosssell_id);
		$thumb .= "<a class='splide__slide'  title='$title ' href='$permalink'>$img</a>";
	}
	return $thumb . '</div> </div> </div> ';
}

function inspire_shortcodes_init() {
	add_shortcode('inspire_cross_sell', 'get_cross_sell_products');
}

add_action( 'init', 'inspire_shortcodes_init' );
