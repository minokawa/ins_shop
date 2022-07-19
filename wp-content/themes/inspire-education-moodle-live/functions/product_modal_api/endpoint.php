<?php
require_once('look-up-moodle-events.php');



function get_inspire_products(WP_REST_Request $request ) {


  $tmp_dir = wp_upload_dir() ;
  $tmp_dir = $tmp_dir['basedir']. '/inspire_products';
  $json_file =  $tmp_dir  . '/products_data.json';

  if(file_exists( $json_file)){
    $content = file_get_contents($json_file);
    return json_decode($content);
  }


	$inspire_products = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' =>-1, 'orderby' => 'title','order' => 'ASC',));

	$array_products = [];
	$event_checks = array();

	while ( $inspire_products->have_posts() ) {


		$inspire_products->the_post();
    global $product;
		$pid = get_the_ID();
		$terms = get_the_terms( $pid, 'product_cat' );
		$element_class = '';

		if($terms){ $element_class = join(' ', wp_list_pluck($terms, 'slug')); }
		if($element_class=='' || $element_class== 'uncategorised'){ continue; }

		if($element_class=='last-minute-specials'){
			array_push(	$event_checks,$pid);
		}

    $slug = basename(get_permalink($pid));

		$array_products[$slug]['ID']  = $pid;
		$array_products[$slug]['item_class']  = $element_class;

		if ( has_post_thumbnail() ) {
			$image              = get_the_post_thumbnail( $pid, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
			$image_title        = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link         = wp_get_attachment_url( get_post_thumbnail_id() );
			$image  = apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', $image_link, $image_title, $image ), $pid);
		} else {
			$image  = apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $pid);
		}

		$array_products[$slug]['image']  = $image ;
		$array_products[$slug]['post_title']  = get_the_title( $pid );
		$array_products[$slug]['post_permalink']  = get_permalink($pid);
		$excerpt = get_the_excerpt( $pid);
		$array_products[$slug]['woocommerce_short_description']  = apply_filters( 'woocommerce_short_description',  $excerpt );

		ob_start();
		woocommerce_template_single_price();
    //woocommerce_template_single_add_to_cart();
    echo apply_filters(
      'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
      sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
        esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        esc_html( $product->add_to_cart_text() )
      ),
      $product,
      $args
    );

		$wc_prod_summary = ob_get_clean();
		$array_products[$slug]['woocommerce_single_product_summary'] = $wc_prod_summary;
	}

	if ( empty( $array_products ) ) {
		return new WP_Error( 'no_product', 'Invalid Request', array( 'status' => 404 ) );
	}

	$result['event_check'] = $event_checks;
	$result['products'] = $array_products;
  $json_data = json_encode($result);


  $tmp_dir = wp_upload_dir() ;
  $tmp_dir = $tmp_dir['basedir']. '/inspire_products';
  $json_file =  $tmp_dir  . '/products_data.json';

  if ( ! file_exists($tmp_dir) ) {
    wp_mkdir_p( $tmp_dir);
  }

  file_put_contents( $json_file ,  $json_data);
	return $result;
}

function get_moodle_event_details($pids){
	$res = lookup_moodle_events($pids);
	return $res;
}

function setup_products_modal_endpoint () {

	$products_api_settings = array(
  'methods'=> WP_REST_Server::READABLE,
  'callback' => 'get_inspire_products',
	'permission_callback' => '__return_true',
  'args'      => array(
    'wp_nonce_product_modal' => array(
    'required' => true,
    'validate_callback' => function($value) {
      $user = wp_get_current_user();
      if ( $user instanceof WP_User ) {
          return true;
      }
      return wp_verify_nonce($value, 'wp_nonce_product_modal');
    })));

	$moodle_event_api_settings = array(
  'callback' => 'get_moodle_event_details',
	'permission_callback' => '__return_true',
  'methods' => 'POST',
  'args'      => array(
    'wp_nonce_product_modal' => array(
    'required' => true,
    'validate_callback' => function($value) {
        $user = wp_get_current_user();
        if ( $user instanceof WP_User ) {
            return true;
        }
        return wp_verify_nonce($value, 'wp_nonce_product_modal');
    }),
    'product_ids' => array(
      'required' => true,
      'validate_callback' => function($json_string) {
          json_decode($json_string);
          return json_last_error() === JSON_ERROR_NONE;
        })
    ));

	register_rest_route( 'inspire/v1', '/products', $products_api_settings );
	register_rest_route( 'inspire/v1', '/product/event_check', $moodle_event_api_settings);
}

function setup_products_modal_JS(){
	wp_register_script( 'handlebars', 'https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js');
	wp_register_script( 'inspire-product-modal', get_template_directory_uri() . '/assets/scripts/inspire-product-modal.js');
	wp_localize_script( 'inspire-product-modal', 'inspire_product_modal_data', [
												'rest' => [
													'endpoints' => [
																					'products' => esc_url_raw( rest_url( 'inspire/v1/products' ) ),
																					'event_check' => esc_url_raw( rest_url( 'inspire/v1/product/event_check' ) ),
																				 ],
													'timeout'   => 30000,
													'nonce'     => wp_create_nonce( 'wp_nonce_product_modal' )
												],
											]);

	wp_enqueue_script( 'handlebars' );
	wp_enqueue_script( 'inspire-product-modal' );

//the inspire-product-modal.js inserts node in to the pop up modal
//this creates excessive nodes, thats a problem
//unfortuantely we dont know yet what is else wired to the popup DOM
//lets keep it that way for now.
?>
	<script id="product-entry-template" type="text/x-handlebars-template">
		<li data-pid='{{ID}}' class='{{encodeMyString  item_class}}'>
			<div class='summary-wrapper'>
				<div class='images'>{{encodeMyString  image}}</div>
				<div class='summary entry-summary'>
					<h5 itemprop='name' class='product_title entry-title'><a href='{{post_permalink}}'>{{encodeMyString  post_title}}</a></h5>
					<div itemprop='description'>
						{{encodeMyString  woocommerce_short_description}}
						<p class='event-details'></p>
					</div>
					{{encodeMyString  woocommerce_single_product_summary}}
				</div>
			</div>
		</li>
	</script>
<?php
}

add_action('woocommerce_update_product', 'clear_tmp_folder');
add_action('woocommerce_new_product', 'clear_tmp_folder');

function clear_tmp_folder($product_id){

  $tmp_dir = wp_upload_dir() ;
  $tmp_dir = $tmp_dir['basedir']. '/inspire_products';
  $json_file =  $tmp_dir  . '/products_data.json';


  if(file_exists( $json_file)){
    if (!unlink($json_file)) {
      error_log("$json_file cannot be deleted due to an error");
    }else {
      error_log("$json_file has been deleted");
    }
  }
}
