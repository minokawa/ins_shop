<?php
namespace Inspire\Subscription;
final class Dashboard {
	use \Inspire\Subscription\SingletonTrait;
	private static $config = [];
	private static $template;

	public function setup($config){
		self::$config = $config;
		self::$template =  \Inspire\Subscription\TemplateEngine::instance();
		self::$template->setup( __DIR__ . '/../templates');
		self::$template->add_filter(new \Twig\TwigFilter('html_entity_decode','html_entity_decode'));

		add_action( 'admin_menu', array (self::$instance, 'setup_dashboard_menu'),0);
		add_action('acf/save_post', array (self::$instance,'update_options') ,0,1);
		add_action('acf/input/admin_head', array($this, 'custom_screen_ui'), 20);
		add_filter('acf/load_field/key=field_62a4d9a279db1',  array (self::$instance,'get_plan_options') );

	}
	public function get_plan_options($field) {
			$field['choices'] = array();
			$options['choices']  = [];
			$plans = 	get_field('subscription_plans',self::$config['slug'] );
			foreach( 	$plans as $key=>$plan ){
				$plan_key = wc_sanitize_taxonomy_name(wp_unslash($plan['name']));
				$options['choices'][$plan_key] = $plan['name'];
			}
			if( is_array($options['choices']) ) {
				foreach( $field['sub_fields'] as $key => $val ) {
					$field['sub_fields'][$key]['choices']= 		$options['choices'];
				}
			}
			return $field;
	}

	public function setup_dashboard_menu() {
			$args = ['page_title' => self::$config['name'],'menu_slug' => self::$config['slug'],'capability' => 'manage_options','position' => 2,'parent_slug' => '',	'icon_url' => 'dashicons-clipboard','redirect' => false,'post_id' => self::$config['slug'],'autoload' => true,];
			acf_add_options_page( $args );
	}


	public function custom_screen_ui() {
		$screen = get_current_screen();
		$plugin_screen_id = 'toplevel_page_' . self::$config['slug'];
		if ($screen->id == $plugin_screen_id ) {
			add_meta_box('submitdiv', 'subscription Manager Actions', array($this, 'action_box'), 'acf_options_page', 'side', 'high');
			add_meta_box('debug-box-' . self::$config['slug'], 'Setup Overview', array($this, 'debug_box'), 'acf_options_page', 'normal', 'high');
		}
	}

	public function action_box($post, $args=array()) {
		$other_attributes = array( 'id' => 'subscription-button-deploy' );
		echo '<div style="padding: 20px;display: flex;align-content: space-between;justify-content: space-evenly;    flex-direction: column;">';
			submit_button( 'Deploy Subscriptions', 'primary', 'mapping-save', false,array( 'id' => 'subscription-button-submit', 'style' => 'width:100%; display:block; margin-bottom:20px' ));
			submit_button( 'Save Subscriptions Setup', 'primary', 'subscription-save', false,array( 'id' => 'subscription-button-submit', 'style' => 'width:100%; display:block' ));			

		echo '</div>';
	}

	public function debug_box($post, $args=array()) {
		$mock_data['dump'] = '---';
		echo self::$template->render('dashboard.html.twig', $mock_data);
	}

	public function update_options($post_id) {

		if($_POST['_acf_post_id'] == self::$config['slug'] && isset($_POST['mapping-save'])){


			$ATTR_LABEL = 'Inspire Subscription Plan';
			$ATTR_SLUG = sanitize_title($ATTR_LABEL);
			$subscription_lookup['products'] = [];
			$subscription_lookup['plans'] = [];

			//REMAP THE THE PRODUCTS AND PLANS
			$subscription_manager_products = 	get_field('subscription_products',self::$config['slug'] );
			$subscription_manager_plans = get_field('subscription_plans',self::$config['slug'] );

			foreach($subscription_manager_products as $key => $row){
				$subscription_lookup['products'][$row['product_name']] = $row['subscription_plan'];
			}

			foreach($subscription_manager_plans as $key => $row){
				$key = wc_sanitize_taxonomy_name(wp_unslash($row['name']));
				$subscription_lookup['plans'][$key] = $row;
			}
			//TODO: SAVE THIS LOOK TABLE TO JSON


			//CHECK IF THIS PRODUCTS ARE TYPE VARIABLE SUBSCRIPTION
			//DELETE THE ESXISTING PLANS IF NOBODY IS SUBSCRIBED
			foreach($subscription_lookup['products'] as $key => $row){
				$product = wc_get_product($key);
				$type = $product->get_type();
				$existing_variants = $product->get_children();
				if($type !=="variable-subscription"){
					wp_remove_object_terms( $key, $type , 'product_type' );
					wp_set_object_terms( $key, 'variable-subscription', 'product_type', true );
				}
				self::clear_out_variants($existing_variants);
			}


			//ASSIGN ATTRIBUTE AND TEMS
      foreach($subscription_lookup['products'] as $key => $row){

				$product = wc_get_product($key);
				$product_name = $product->get_name();
				$sku = $product->get_sku();
				if(!$sku){ 	$sku = 'INS_TMP_' . $key.'_'; }

				//a. ASSIGN THE ATTRIBUTE
			//	$default_term = $row[0];
				$attr_properties[$ATTR_SLUG] = array(
					'name' => $ATTR_LABEL,
					'value' => 	implode("|",$row),
					'is_visible' => '1',
					'is_variation' => '1',
					'is_taxonomy' => '0'
				);
				update_post_meta($key, '_product_attributes', $attr_properties );


				//b. ASSIGN THE TERMS/VARIATIONS
				foreach($row as $variant_index => $term_slug){

					$variant_details = $subscription_lookup['plans'][$term_slug];



					$variation = array(
						'sku'=> 	$sku . '-' . $term_slug,
						'stock_quantity' => $variant_details['stock'],
						'recurring_payment_price' => $variant_details['recurring_payment'],
						'sign_up_fee' => $variant_details['upfront_payment'],
						'sale_price' => '',
						'sale_date_start' => '',
						'sale_date_end' => '',
						'subscription_time_unit'=> strtolower($variant_details['time_unit']),
						'subscription_time_interval'=>$variant_details['interval'],
						'subscription_time_length'=> $variant_details['expire_after'],
						'post_title'   => $product_name . ' (variation)',
						'post_content' => '',
						'post_status'  => 'publish',
						'post_parent'  => $key,
						'post_type'    => 'product_variation'
					);

					self::create_product_variation($key, $variation, $ATTR_SLUG, $term_slug);
				}
			}






		}
	}
	private function clear_out_variants($product_variants){
		$deleted = 0;
		foreach ( $product_variants as $product_variant_id ) {
			$existing_variation     = wc_get_product( $product_variant_id );
			$subscriptions = wcs_get_subscriptions_for_product( $product_variant_id );

			if ( empty( $subscriptions ) ) {
				if ( is_callable( array( $existing_variation, 'delete' ) ) ) {
					$existing_variation->delete( true );
				} else {
					wp_delete_post( $product_variant_id );
				}

				$deleted++;
			}
		}
		echo intval( $deleted );
	}

	private function create_product_variation( $product_id, $variation, $ATTR_SLUG, $term_slug ){

		$variation_id = wp_insert_post( $variation );
		$man_stck = 1;
		$is_upfront = '';

		$sku = $variation['sku'];
		$stock_quantity = $variation['stock_quantity'];
		$recurring_payment_price = $variation['recurring_payment_price'];
		$sign_up_fee = $variation['sign_up_fee'];
		$sale_price = $variation['sale_price'];
		$sale_date_start = $variation['sale_date_start'];
		$sale_date_end = $variation['sale_date_end'];
		$subscription_time_unit = $variation['subscription_time_unit'];
		$subscription_time_interval = $variation['subscription_time_interval'];
		$subscription_time_length = $variation['subscription_time_length'];

		if($stock_quantity == -1) {	$manage_stock = 0;	}
		if($sign_up_fee > 0) { $is_upfront = 1;	}

		update_post_meta( $variation_id, '_manage_stock', $manage_stock );
		update_post_meta( $variation_id, 'attribute_' . $ATTR_SLUG,  $term_slug );
		update_post_meta( $variation_id, '_virtual', 1 );

		$price = 		($subscription_time_interval * $recurring_payment_price ) + 	$sign_up_fee;
		update_post_meta( $variation_id, '_price', $price );  //Total, recurring total and upofront??

		update_post_meta( $variation_id, '_sku', $sku);
		update_post_meta( $variation_id, '_stock_quantity', $stock_quantity  );
		update_post_meta( $variation_id, '_regular_price', 	$recurring_payment_price ); //Recurring price
		update_post_meta( $variation_id, '_subscription_sign_up_fee', $sign_up_fee); //Upfront price
		update_post_meta( $variation_id, '_sale_price', $sale_price );//Sale price
		update_post_meta( $variation_id, '_date_on_sale_from',  $sale_date_start );
		update_post_meta( $variation_id, '_date_on_sale_to',  $sale_date_end);
		update_post_meta( $variation_id, '_subscription_period',	$subscription_time_unit); //day, week, month or year.
		update_post_meta( $variation_id, '_subscription_period_interval', 	$subscription_time_interval ); //billing schedule interval, e.g. 2
		update_post_meta( $variation_id, '_subscription_length', $subscription_length );	//time to wait between sign-up & autoexpiration
		update_post_meta( $variation_id, '_subscription_trial_period',  	$subscription_time_unit); //unit of time before first cylcle paement e.g. week, month or year.
		update_post_meta( $variation_id, '_subscription_trial_length', $is_upfront ); //this is always 1($subscription_time_unit) when upfront

		\WC_Product_Variable::sync( $product_id );
	}
}
