<?php
/*
 * WooCommerce & store specific functions
 * -------------------------------------------------
 * Table Of Contents
 *
 * 1) Site wide functions & general setup
 * 2) Translations
 * 3) Custom Functions
 * 4) Shop Page
 * 5) Checkout Page
 * 6) Payment Gateways
 * 7) API & JobReady
 * 8) Form Submissions
 * 9) Custom checkout form
 * 10) WooCommerce backend
 * 11) Woocommerce Emails
 */



/* 1) Site wide functions & general setup
------------------------------------------ */
// Decalre Woocommerce support
add_theme_support('woocommerce');

// remove thumbnails for categories on shop page
remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);

//Remove Breadcrumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

//Get Rid of Stupid Tabs
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20, 2);
// add_action( 'woocommerce_single_product_summary', 'woocommerce_product_description_panel', 10 );

//Remove Product Reviews
remove_action('woocommerce_product_tabs', 'woocommerce_product_reviews_tab', 30);
remove_action('woocommerce_product_tab_panels', 'woocommerce_product_reviews_panel', 30);

//Remove Sidebar from WooCommerce
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);


// add_action('woocommerce_before_checkout_form','login_conditional', 1);
// function login_conditional() {
//   if (!WC_Subscriptions_Cart::cart_contains_subscription()) {
//     remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );
//   }
// }


// Remove woo script in favor of script files in theme folder
// See assets/setup.php line 115

// Remove
remove_action('woocommerce_email_order_meta', 'woocommerce_template_single_title', 5);

add_filter('loop_shop_per_page', 'products_per_page_category', 20);
function products_per_page_category($count)
{
    return 124;
}

add_filter('woocommerce_product_tabs', 'woo_remove_product_tabs', 20);

function woo_remove_product_tabs($tabs)
{

    unset($tabs['description']); // Remove the description tab
    unset($tabs['reviews']); // Remove the reviews tab
    unset($tabs['additional_information']); // Remove the additional information tab

    return $tabs;

}




// Hide Extension Products from home page
add_filter('get_terms', 'get_subcategory_terms', 10, 3);
function get_subcategory_terms($terms, $taxonomies, $args)
{

    $new_terms = array();

    // if a product category and on the shop page
    if (in_array('product_cat', $taxonomies) && !is_admin() && is_shop()) {

        foreach ($terms as $key => $term) {

            if (!in_array($term->slug, array(
                'course-extensions'
            ))) {
                $new_terms[] = $term;
            }

        }

        $terms = $new_terms;
    }

    return $terms;
}


// Not sure about this? TEST THIS
add_action('manage_shop_order_posts_custom_column', 'woo_custom_order_weight_column', 2);
function woo_custom_order_weight_column($column)
{
    global $post, $woocommerce, $the_order;

    if (empty($the_order) || $the_order->get_id() != $post->ID)
        $the_order = new WC_Order($post->ID);

    if ($column == 'product_name') {

        foreach ($the_order->get_items() as $item) {
            if ($item['product_id'] > 0) {
                $_product = $the_order->get_product_from_item($item);

                $prod_name = $_product->get_title();
                // var_dump($_product);
            }
        }

        print $prod_name;

    }
}

// Not sure about this? TEST THIS
add_filter('manage_edit-shop_order_columns', 'imarcon_set_custom_column_order_columns');
function imarcon_set_custom_column_order_columns($columns)
{
    // global $woocommerce;
    $nieuwearray = array();
    foreach ($columns as $key => $title) {
        if ($key == 'billing_address') // in front of the Billing column
            $nieuwearray['product_name'] = __('Course', 'woocommerce');
        $nieuwearray[$key] = $title;
    }
    return $nieuwearray;
}

// Add disclaimer to cart
add_action('woocommerce_before_cart', 'cart_statement');
function cart_statement($checkout)
{

    echo '<p class="small">*All prices quoted are in Australians dollars <br>';
    echo '<strong>Inspire Education knows how important your security is online.  As a result our website supports Secure Socket Layers (SSLs) with up to 256-bit encryption.</strong></p>';

}

// Re-direct to checkout after successfull addition to cart
add_filter('woocommerce_add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout()
{
    global $woocommerce;
    $checkout_url = WC()->cart->get_checkout_url();
    return $checkout_url;
}

// Add Checkout Steps to top of checkout form
add_action('woocommerce_before_checkout_form', 'checkout_steps');
function checkout_steps($checkout)
{

    include(TEMPLATEPATH . '/woocommerce/checkout-steps.php');

}




// Allow duplicate SKU's
add_filter('wc_product_has_unique_sku', '__return_false', PHP_INT_MAX);


/* 2) Translations
------------------------------------------ */

// WooCommerce field overides

// Shipping Phone
add_filter('woocommerce_checkout_fields', 'add_phone_shipping');
function add_phone_shipping($fields)
{
    $fields['shipping']['shipping_phone'] = array(
        'label' => __('Phone Number', 'woocommerce'),
        'placeholder' => _x('Contact Phone number', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array(
            'form-row-wide'
        ),
        'clear' => true
    );

    return $fields;
}

add_filter('woocommerce_checkout_fields', 'override_email');
function override_email($fields)
{
    $fields['billing']['billing_email']['label']       = 'Email Address';
    $fields['billing']['billing_email']['placeholder'] = 'eg: name@email.com';

    return $fields;

}

add_filter('woocommerce_checkout_fields', 'override_phone');
function override_phone($fields)
{
    $fields['billing']['billing_phone']['label']       = 'Primary Phone Number - no spaces';
    $fields['billing']['billing_phone']['placeholder'] = 'Your Phone Number';
    $fields['billing']['billing_phone']['clear']       = false;
    return $fields;
}

// Billing Phone Secondary
add_filter('woocommerce_checkout_fields', 'phone_billing_two');
function phone_billing_two($fields)
{
    $fields['billing']['phone_billing_two'] = array(
        'label' => __('Secondary Phone - no spaces', 'woocommerce'),
        'placeholder' => _x('Your Mobile number', 'placeholder', 'woocommerce'),
        'required' => false,
        'clear' => true
    );

    return $fields;
}

// billing_email_confirm
add_filter('woocommerce_checkout_fields', 'add_billing_email_confirm', 10, 1);
function add_billing_email_confirm($fields)
{
    $fields['billing']['billing_email_confirm'] = array(
        'label' => __('Confirm Email', 'woocommerce'),
        'placeholder' => _x('Confirm your email', 'placeholder', 'woocommerce'),
        'required' => true,
        'class' => array(
            'billing_email_confirm'
        ),
        'clear' => false
    );
    return $fields;
}

// Contact Name
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_fname', 10, 1);
function wc_npr_filter_fname($fields)
{
    $fields['shipping_first_name']['required'] = false;
    $fields['shipping_first_name']['label']    = 'First Name';
    return $fields;
}

// Last Name
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_last', 10, 1);
function wc_npr_filter_last($fields)
{
    $fields['shipping_last_name']['required'] = false;
    $fields['shipping_last_name']['label']    = 'Last Name';
    return $fields;
}

// Address 1
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_add1', 10, 1);
function wc_npr_filter_add1($address_fields)
{
    $address_fields['shipping_address_1']['required'] = false;
    return $address_fields;
}

// Last Name
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_add2');
function wc_npr_filter_add2($fields)
{
    unset($fields['shipping']['shipping_address_2']);
    return $fields;
}

// shipping_city
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_city', 10, 1);
function wc_npr_filter_city($address_fields)
{
    $address_fields['shipping_city']['required'] = false;
    return $address_fields;
}

// shipping_postcode
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_post', 10, 1);
function wc_npr_filter_post($address_fields)
{
    // $address_fields['shipping_postcode']['required'] = false;
    $address_fields['shipping_postcode'] = array(
        'label' => __('Postcode', 'woocommerce'),
        'placeholder' => _x('company postcode', 'placeholder', 'woocommerce'),
        'required' => false,
        'class' => array(
            ''
        ),
        'clear' => true
    );
    return $address_fields;
}

// shipping_country
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_country', 10, 1);
function wc_npr_filter_country($address_fields)
{
    $address_fields['shipping_country']['required'] = false;
    return $address_fields;
}

// shipping_state
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_state', 10, 1);
function wc_npr_filter_state($address_fields)
{
    $address_fields['shipping_state']['required'] = false;
    $address_fields['shipping_state']['label']    = 'State';
    return $address_fields;
}

// shipping_email
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_shipping_email', 10, 1);
function wc_npr_filter_shipping_email($address_fields)
{
    $address_fields['shipping_email']['required'] = false;
    return $address_fields;
}

// Company
add_filter('woocommerce_shipping_fields', 'wc_npr_filter_company', 10, 1);
function wc_npr_filter_company($address_fields)
{
    $address_fields['shipping_company']['required'] = false;
    return $address_fields;
}


// Make order names uppercase
$uppercasefields = array(
  'billing_first_name',
  'billing_last_name',
  'billing_pname',
  'billing_sname',
  'billing_address_1',
  'billing_address_2',
  'billing_city',
  'billing_country',
  'billing_state'
);

foreach ($uppercasefields as $fieldkey) {
    add_filter('woocommerce_process_checkout_field_'.$fieldkey,'custom_field_to_uppercase');
}
function custom_field_to_uppercase($value) {
  return ucwords($value);
}



/* 3) Custom Functions
------------------------------------------ */

function grab_ids_in_category_spacial($respoj, $key)
{
    global $post, $woocommerce;

    // Get the Id from the product in the cart
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item):
        $product_id = $cart_item['product_id'];
    endforeach;
    $args = array(
        'post_type' => 'schedule_type',
        'meta_key' => 'course_name',
        'meta_query' => array(
            array(
                'key' => 'course_name', // name of custom field
                'value' => $product_id, // matches exaclty "123", not just 123. This prevents a match for "1234"
                'compare' => 'LIKE'
            )
        )
    );

    $_categories = get_the_terms($product_id, 'product_cat');
    foreach ($_categories as $_category) {
        $cats[] = $_category->term_id;
    }

    if (!empty($respoj)) {
        if (!empty($respoj['moodle_courseid'])) {
            $mcourid = $respoj['moodle_courseid'];
        } else {
            $mcourid = 0;
        }
        //echo 'Spacial events locations';

        echo '<input type="hidden" value="' . $mcourid . '" name="moodlecourseid" id="moodlecourseid">';
        if (!empty($respoj['delivery_method'])) {
            /*  echo '<div id="distance_checkbox" class="checkbox clearfix">';
            echo '<h5>Course Delivery <abbr class="required" title="required">* </abbr></h5>';
            echo '<p class="form-row radio text required" id="distance_learning_field">';
            foreach($respoj['delivery_method'] as $keymethod=>$valuemethod) {
            if(strtolower($valuemethod) == 'full delivery') {
            $idfor = 'ccf_delivery_full';
            } else if(strtolower($valuemethod) == 'blended delivery') {
            $idfor = 'ccf_delivery_blend';
            } else {
            $idfor = 'ccf_delivery_distance';
            }
            echo '<label for="'.$idfor.'" class="">';
            echo '<input type="radio" name="ccf_delivery" id="'.$idfor.'" value="'. $keymethod .'" class="ccf_input_deliv input-checkbox"> '.$valuemethod;
            echo '</label>';
            }
            echo "</div>";*/

            // if($respoj['class_event'] > 0) {
            if (($respoj['location_' . $mcourid] > 0) && (!empty($respoj['event']))) {
                $evestr = $key;

                echo '<p class="form-row text clearfix full-width validate-required" id="ccf_event_select_field_' . $evestr . '">';
                echo '<label class="" for="coursename">';
                echo 'Events for course : ' . $respoj['coursename'];
                echo '</label>';
                echo '</p>';

                if (!empty($respoj['delivery_details'])) {
                    echo '<p class="form-row required text clearfix full-width validate-required" id="distance_learning_field_full_' . $evestr . '">';
                    echo '<label class="" for="distance_learning_field_full_' . $evestr . '">';
                    echo '<span style="font-size:16px;font-weight: bold; ">Location:  </span>  ';
                    echo '<abbr title="required" class="required"></abbr>';
                    echo ' <span  style="font-size:14px;font-weight: bold; "> (Please select  the location you wish to attend for your workshop) </span>';
                    echo '</label>';

                    $count        = 0;
                    $totalevseats = 4;

                    echo '<select name="ccf_delivery_location_' . $evestr . '[]" id="ccf_delivery_location_' . $evestr . '_' . $mcourid . '" class="select text" onchange=eventlocationname(' . $evestr . ',' . $mcourid . ')>';
                    echo '<option selected=selected>Please select your desired location</option>';
                    foreach ($respoj['delivery_details'] as $keydetail => $valuedetail) {
                        //if($valuedetail['eventid'] == $evestr){
                        echo '<option id="ccf_course_' . $keydetail . '" value="' . $keydetail . '">' . $valuedetail['location'] . '</option>';
                        // }
                    }
                    echo "</select>";
                    echo '</p>';


                }
                if (!empty($respoj['event'])) {
                    echo '<p class="form-row text clearfix full-width validate-required" id="full_location_timetable_new_' . $evestr . '">';
                    echo '<label class="" for="full_location_timetable_new_' . $evestr . '">';
                    echo '<span style="font-size:16px;font-weight: bold; ">Workshop Event Name: </span>   ';
                    echo '<abbr title="required" class="required"></abbr>';

                    echo ' <span  style="font-size:14px;font-weight: bold; ">   (Please select the name and start date of the workshop you wish to attend) </span>';
                    echo '</label>';

                    echo '<select name="ccf_event_id[]" id="ccf_delivery_location_timetable_full_' . $evestr . '_' . $mcourid . '" class="select text" onchange=eventupdatetime(this)>';
                    // echo '<option value="">Please select your desired start date</option>';
                    // foreach($respoj['event'] as $keyevent=>$valueevent) {
                    // $firstdate = explode(',',$valueevent['event_fulltimestart']);
                    // $enddate = explode(',',$valueevent['event_fulltimeduration']);
                    // $startdate = $firstdate[0];
                    // $starttime = $firstdate[1];
                    // $enddates = $enddate[0];
                    // $endtime = $enddate[1];
                    // $finaldatelocation = $startdate.' - '.$enddates.', '.$starttime.' - '.$endtime;
                    // echo '<option value="'.date('d/m/Y',$valueevent['event_timestart']).'">' . $finaldatelocation . '</option>';
                    // }


                    echo "</select>";
                    echo "</p>";
                    echo '<p class="form-row text clearfix full-width validate-required">';
                    echo '<label class="" for="Date">';
                    echo '<span  style="font-size:16px;font-weight: bold; ">Date:   </span>';
                    echo '<abbr title="required" class="required"></abbr>';
                    echo '</br>';
                    echo '<span  style="font-size:14px;font-weight: bold; ">(Please check that the date displayed here is the date you wish to attend your workshop event)</span>';
                    echo '</label>';

                    echo "</p>";

                    echo '<p class="form-row text clearfix full-width validate-required"><input type="text" class="input-text  garlic-auto-save valid" name="time_event" id="time_event"  value="" readonly></p>';
                    echo '</br>';
                    echo '<p class="form-row text clearfix full-width"></p>';
                }
                /* end class event repeat */
                //}
            }

        }

    }


    //print_r( $respoj['delivery_method']);
    if ($respoj['delivery_method'][7]) {
        //if(($respoj['delivery_method'][7] == 'Distance') && (empty($respoj['event'])) && (empty($respoj['location_'.$mcourid]))){
        if (($respoj['delivery_method'][7] == 'Distance') && (empty($respoj['event']))) {


            echo '<div class="checkbox clearfix">
        <h5>Would you like to Start ASAP ? Otherwise choose a start date below.
        </h5>
        <p class="form-row radio "> <abbr class="required" title="required">* <span>required</span></abbr>
          <label for="ccf_distance_start_asap" class="">
          <input type="checkbox" name="ccf_distance_start_asap" id="ccf_distance_start_asap" value="Yes" class="one-of-valid input-checkbox garlic-auto-save">
          Yes
          </label>
        </p>
        </div>';


            echo '<p class="form-row text required ccf_distance_start_date" id="ccf_distance_start_date_field">
        <label for="ccf_distance_start_date" class="">
          Distance Course Start Date  - dd/mm/yyyy
        </label>
        <input type="text" autocomplete="off" class="input-text one-of-valid" name="ccf_distance_start_date" id="ccf_distance_start_date" placeholder="eg: dd/mm/yyyy" value="">
        </p>';

        }
    }


}


/* Timetables for blended & full courses
------------------------------------------------------------------------------------ */
function grab_ids_in_category($respoj, $key){
	if (empty($respoj)) { return; }

	global $post, $woocommerce;
	$mcourid = isset($respoj['moodle_courseid']) ? $respoj['moodle_courseid'] : 0;

	// This script nly works on the last ITEM!!!!!!
	foreach( WC()->cart->get_cart() as $cart_item ){ $product_id = $cart_item['data']->get_id(); }
	$_categories = get_the_terms($product_id, 'product_cat');
	foreach ($_categories as $_category) { $cats[] = $_category->term_id; }

	//CHECK IF LASST MINUTE SPECIAL '476'
	$its_a_last_minute_special = in_array('476', $cats);

	if ($its_a_last_minute_special) {
		$max_seat_check = get_post_meta($product_id, 'max_occupied_seats_', true);
		$maxtime1 = ('+' . $max_seat_check * 7) . ' day';
		$lastdate = strtotime($maxtime1, $cdate);
		$min_seat_check = get_post_meta($product_id, 'min_occupied_seats_', true);
		$mintime = ('+' . $min_seat_check * 7) . ' day';
		$mindate = strtotime($mintime, $cdate);
	}

	echo '<input type="hidden" value="' . $mcourid . '" name="moodlecourseid" id="moodlecourseid">';
	$delivery_method = $respoj['delivery_method'];
	$class_event = $respoj['class_event'];


	//DROPDOWNS FOR DELIVERY OPTIONS
	if (!empty($delivery_method) && $class_event > 0 ) {
		$delivery_group_fields  = '';
		for ($evestr = 1; $evestr <= $class_event; $evestr++) {

			$hidden_event_id =  '<input type="hidden" name="ccf_event_id[]" id="ccf_event_id_' . $evestr . '_' . $mcourid . '" class="select text" value ="' . $evestr . '">';
			$event_label = '';

			if (empty($respoj['delivery_details'])) { continue; }

			//GENERATE DELIVERY TYPE SELECT
			foreach ($delivery_method as $keymethod => $valuemethod) {
				$learning_field_id = 'distance_learning_field_blended_' . $evestr;
				$label_text =  'Select Course Delivery Option - ' . $key;
				if (strtolower($valuemethod) == 'full delivery') {
					$learning_field_id = 'distance_learning_field_full_' . $evestr;
					$label_text = 'Full Delivery Course location - ' . $evestr;
				}
				if (strtolower($valuemethod) == 'blended delivery') {
					$learning_field_id = 'distance_learning_field_blended_' . $evestr;
					$label_text =  'Blended Delivery Course location - ' . $evestr;
				}
				$event_label .= '<p class="form-row text clearfix full-width validate-required" id="' . $learning_field_id . '">
												<label class="" for="' . $learning_field_id . '">' . $label_text . '<abbr title="required" class="required"></abbr></label>';
			}

			$date = date('d-m-Y');
			$cdate = strtotime($date);
			$options = '<option selected=selected>Please select your desired location</option>';
			$exist = array();
			foreach ($respoj['event'] as $valuedetailq) {
				$keydetail = $valuedetailq['event_locid'];
				$render_condition = false;

				if ($its_a_last_minute_special) {
					if($valuedetailq['event_timestart'] > $cdate && ($valuedetailq['event_timestart'] < $lastdate || $valuedetailq['event_timestart'] < $mindate) && !in_array($keydetail, $exist) && $valuedetailq['event_eventid'] == $evestr){
						$render_condition = true;
					}
				}

				if($valuedetailq['event_timestart'] > $cdate && !in_array($keydetail, $exist) && $valuedetailq['event_eventid'] == $evestr){
					$render_condition = true;
				}

				if ($render_condition) {
					$options .= '<option id="ccf_course_' . $keydetail . '" value="' . $keydetail . '">' . $valuedetailq['location'] . '</option>';
					$exist[] = $keydetail;
				}
			}
			$delivery_options_select = '<select name="ccf_delivery_location_' . $key . '" id="ccf_delivery_location_' . $evestr . '_' . $mcourid . '" class="select text ccf_delivery_location_select" data-evestr="'. $evestr .'" data-mcourid="'. $mcourid .'">' .$options. '</select></p>';

			//GENERATE TIME TABLE SELECT
			$time_table_select = '';
			if (!empty($respoj['event'])) {
				$time_table_select .= '<p class="form-row text clearfix full-width validate-required" id="full_location_timetable_new_' . $evestr . '">
							<label class="" for="full_location_timetable_new_' . $key . '">
							Select Timetable - ' . $key . '<abbr title="required" class="required"></abbr></label>
							<select name="ccf_delivery_location_timetable_' . $key . '" id="ccf_delivery_location_timetable_full_' . $evestr . '_' . $mcourid . '" class="select text ccf_delivery_location_timetable_select"   data-evestr="'. $evestr .'" data-mcourid="'. $mcourid .'"> </select></p>';
			}

			$delivery_group_fields .= $hidden_event_id . $event_label . $delivery_options_select . $time_table_select;
		}
		echo '<div class="delivery_option_wrapper">';
		echo '<h3 class="event_title"> Select Event Date for : <span class="course_title">' . $respoj['coursename'] . '</span></h3> ';
		echo $delivery_group_fields;
		echo '</div>';
	}

  //DROPDOWN FOR DELIVERY METHOD DISTANCE
	if ($delivery_method[7] == 'Distance' && empty($respoj['event'])) {
	echo '<div class="checkbox clearfix">
					<h5>Would you like to Start ASAP ? Otherwise choose a start date below.</h5>
					<p class="form-row radio "> <abbr class="required" title="required">* <span>required</span></abbr>
						<label for="ccf_distance_start_asap" class="">
							<input type="checkbox" name="ccf_distance_start_asap" id="ccf_distance_start_asap" value="Yes" class="one-of-valid input-checkbox garlic-auto-save">
							Yes
						</label>
					</p>
				</div>
				<p class="form-row text required ccf_distance_start_date" id="ccf_distance_start_date_field">
					<label for="ccf_distance_start_date" class="">
						Distance Course Start Date  - dd/mm/yyyy
					</label>
					<input type="text"  autocomplete="off" class="input-text one-of-valid" name="ccf_distance_start_date" id="ccf_distance_start_date" placeholder="eg: dd/mm/yyyy" value="">
				</p>';
	}
}


// Formal learning options
function formal_learning_options()
{

    echo '<p class="form-row radio completed" id="ccf_formal_field"> <abbr class="required" title="required">* <span>required</span></abbr>';
    echo '<label for="ccf_formalBachelor degree or higher degree" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Bachelor" value="Bachelor Degree or Higher Degree level" class="input-checkbox">
    Bachelor degree or higher degree
  </label>
  <label for="ccf_formalAdvanced Diploma or associate diploma" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Advanced" value="Advanced Diploma or Associate Degree" class="input-checkbox">
    Advanced Diploma or associate diploma
  </label>
  <label for="ccf_formalDiploma (or associate diploma)" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Diploma" value="Diploma" class="input-checkbox">
    Diploma (or associate diploma)
  </label>
  <label for="ccf_formalCertificate IV (or advanced certificate/ technician)" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Certificate_fourth" value="Certificate IV" class="input-checkbox">
    Certificate IV (or advanced certificate/ technician)
  </label>
  <label for="ccf_formalCertificate III (or trade certificate)" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Certificate_three" value="Certificate III" class="input-checkbox">
    Certificate III (or trade certificate)
  </label>
  <label for="ccf_formalCertificate II" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Certificate_two" value="Certificate II" class="input-checkbox">
    Certificate II
    </label>
  <label for="ccf_formalCertificate I" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Certificate_ist" value="Certificate I" class="input-checkbox">
    Certificate I
    </label>
  <label for="ccf_formalMiscellaneous Education" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Miscellaneous" value="Miscellaneous Education" class="input-checkbox">
    Miscellaneous Education
    </label>
  <label for="ccf_formalBridging and Enabling course" class="">
    <input type="checkbox" name="ccf_formal[]" id="ccf_formal_Bridging" value="Bridging and Enabling Course" class="input-checkbox">
    Bridging and Enabling course
    </label>';

    echo '</p>';

}


function get_the_content_by_id($post_id)
{
    $page_data = get_page($post_id);
    if ($page_data) {
        return $page_data->post_content;
    } else
        return false;
}

// Radio button functions
function woocommerce_form_field_radio($key, $args, $value = '')
{
    global $woocommerce;
    $defaults = array(
        'type' => 'radio',
        'label' => '',
        'placeholder' => '',
        'required' => false,
        'class' => array(),
        'label_class' => array(),
        'return' => false,
        'options' => array()
    );
    $args     = wp_parse_args($args, $defaults);
    if ((isset($args['clear']) && $args['clear']))
        $after = '<div class="clear"></div>';
    else
        $after = '';
    $required = ($args['required']) ? ' <abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>' : '';
    switch ($args['type']) {
        case "select":
            $options = '';
            if (!empty($args['options']))
                foreach ($args['options'] as $option_key => $option_text)
                    $options .= '<label for="' . $key . $option_key . '" class="' . implode(' ', $args['label_class']) . '"><input type="radio" name="' . $key . '" id="' . $key . $option_key . '" value="' . $option_key . '" ' . selected($value, $option_key, false) . 'class="input-checkbox">' . $option_text . '</label>' . "\r\n";
            $field = '<p class="form-row radio ' . implode(' ', $args['class']) . '" id="' . $key . '_field">' . $args['label'] . $required . '
    ' . $options . '
    </p>' . $after;
            break;
    } //$args[ 'type' ]
    if ($args['return'])
        return $field;
    else
        echo $field;
}


// Checkbox functions
function woocommerce_form_field_checkbox($key, $args, $value = '')
{
    global $woocommerce;
    $defaults = array(
        'type' => 'checkbox',
        'label' => '',
        'placeholder' => '',
        'required' => false,
        'class' => array(),
        'label_class' => array(),
        'return' => false,
        'options' => array()
    );
    $args     = wp_parse_args($args, $defaults);
    if ((isset($args['clear']) && $args['clear']))
        $after = '<div class="clear"></div>';
    else
        $after = '';
    $required = ($args['required']) ? ' <abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>' : '';
    switch ($args['type']) {
        case "select":
            $options = '';
            if (!empty($args['options']))
                foreach ($args['options'] as $option_key => $option_text)
                    $options .= '<label for="' . $key . $option_key . '" class="' . implode(' ', $args['label_class']) . '"><input type="checkbox" name="' . $key . '" id="' . $key . $option_key . '" value="' . $option_key . '" ' . selected($value, $option_key, false) . 'class="input-checkbox">' . $option_text . '</label>' . "\r\n";
            $field = '<p class="form-row radio ' . implode(' ', $args['class']) . '" id="' . $key . '_field">' . $args['label'] . $required . '
    ' . $options . '
    </p>' . $after;
            break;
    } //$args[ 'type' ]
    if ($args['return'])
        return $field;
    else
        echo $field;
}




/* 4) Shop Page
------------------------------------------ */


/* 5) Checkout Page
------------------------------------------ */

require_once(dirname(__FILE__) . '/woocommerce/woo-checkoutpage.php');


/* 6) Payment Gateways
------------------------------------------ */

require_once(dirname(__FILE__) . '/woocommerce/woo-paymentgateways.php');


/* 7) API & JobReady
------------------------------------------ */

require_once(dirname(__FILE__) . '/woocommerce/woo-jobready.php');


/* 8) Form Submissions
------------------------------------------ */

require_once(dirname(__FILE__) . '/woocommerce/woo-updateordermeta.php');


/* 9) Custom checkout form
------------------------------------------ */

//require_once(dirname(__FILE__) . '/woocommerce/woo-checkoutform.php');


/* 10) WooCommerce backend
------------------------------------------ */

// Display field value on the order edit page
add_action('woocommerce_admin_order_data_after_billing_address', 'ccf_extension_stu_num_admin_order_meta', 10, 1);
function ccf_extension_stu_num_admin_order_meta($order)
{
    if (get_post_meta($order->get_id(), 'Student Number', true)) {
        echo '<h4>Additional Student Details</h4>';
        echo '<p><strong>' . __('Student Number') . ':</strong> ' . get_post_meta($order->get_id(), 'Student Number', true) . '</p>';
    }
}


/* 11) Woocommerce Emails
------------------------------------------ */

// Add coupon alert to Admin email
add_action('woocommerce_email_before_order_table', 'woo_coupon_admin_email_alert', 15, 2);
function woo_coupon_admin_email_alert($order, $is_admin_email)
{


    if ($order->get_used_coupons()) {

        foreach ($order->get_used_coupons() as $coupon) {

            if ($coupon == "compare") {

                echo '<p><strong>Partner Coupon Used:</strong> ' . $coupon . '</p>';

            }


        }

    } // endif get_used_coupons

}

/* 12) Moodle integration
------------------------------------------ */

require_once(dirname(__FILE__) . '/woocommerce/moodle.php');


