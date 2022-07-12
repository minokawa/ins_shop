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

function marky_custom_price_string($pricestring)
{

    $mystring = (string) $pricestring;

    $findme1 = 'after 1 month free trial';
    $pos1    = strpos($mystring, $findme1);

    $findme2 = 'for 1 month';
    $pos2    = strpos($mystring, $findme2);

    $findme3 = 'and a';
    $pos3    = strpos($mystring, $findme3);

    $findme4 = 'with 1 month free trial';
    $pos4    = strpos($mystring, $findme1);


    if ($pos1 !== false) {

        $newprice = str_replace($findme1, '', $pricestring);

    } elseif ($pos2 !== false) {

        $newprice = str_replace('for 1 month', '', $pricestring);
        $newprice = str_replace('<span class="amount">&#36;0.00</span> <span class="subscription-details">  and a', '<span class="subscription-details">', $newprice);

    } else {
        $newprice = $pricestring;
    }

    return $newprice;

}
add_filter('woocommerce_subscriptions_product_price_string', 'marky_custom_price_string');
add_filter('woocommerce_subscription_price_string', 'marky_custom_price_string');


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


add_filter('gettext', 'translate_text');
add_filter('ngettext', 'translate_text');
function translate_text($translated)
{
    $translated = str_ireplace('Your order was cancelled.', 'Your order was cancelled. If it was done so via a PayPal error then please return to the shop and try agian.', $translated);
    // $translated = str_ireplace('month',  'RAHHH',  $translated);
    return $translated;
}

// Remove free price
function hide_free_price_notice($price, $product)
{
    return '';
}
add_filter('woocommerce_variable_free_price_html', 'hide_free_price_notice', 10, 2);
add_filter('woocommerce_free_price_html', 'hide_free_price_notice', 10, 2);

// Swap 'sort code' for 'bsb'
add_filter('gettext', 'my_gettext');
add_filter('ngettext', 'my_gettext');
function my_gettext($translated)
{
    $translated = str_ireplace('Sort Code', 'BSB', $translated);
    return $translated;
}

// Swap 'COD' for 'Direct Debit'
add_filter('gettext', 'woo_cod_for_directdebit');
add_filter('ngettext', 'woo_cod_for_directdebit');
function woo_cod_for_directdebit($translated)
{
    $translated = str_ireplace('Cash on Delivery', 'Direct Debit', $translated);
    return $translated;
}

// sign up fee
add_filter('gettext', 'translate_signup');
add_filter('ngettext', 'translate_signup');
function translate_signup($translated)
{
    $translated = str_ireplace('sign-up fee', '', $translated);
    // $translated = str_ireplace('month',  'RAHHH',  $translated);
    return $translated;
}

// Edit Subscription Price String
add_filter('woocommerce_subscriptions_product_price_string', 'my_subs_price_string');
function my_subs_price_string($pricestring)
{
    global $woocommerce, $product;

    if (!is_null( $woocommerce->cart)) {
      if(empty (WC()->cart->get_cart())){
        return false;
      }
        $cart_items = $woocommerce->cart->get_cart();

        foreach ( $cart_items as $cart_item_key => $values) {
            $_product = $values['data'];

            if (strpos($pricestring, 'for 1 month and a') !== false) {

                $text = array(
                    "for 1 month and a"
                );

                $newprice = str_replace($text, '', $pricestring);
                $newprice = str_replace('&#36;0.00', '', $newprice);
                // $newprice = 'turk';


            } elseif (strpos($pricestring, 'with 1 month free trial and a') !== false) {

                // $sign_up_cost = $product->product_custom_fields['_subscription_sign_up_fee'];
                $sign_up_cost = get_post_meta($_product->get_id(), '_subscription_sign_up_fee', true);
                $sign_up_cost .= '.00';
                $pattern[0]     = '/with 1 month free trial and a/';
                $replacement[0] = '';

                $price    = '$' . $sign_up_cost . ' sign-up fee & ' . strstr($pricestring, 'with', true);
                $newprice = $price;
                // $newprice = 'sky';

            } else {

                $newprice = $pricestring;
                // $newprice = 'surf';

            }

        }

    } else {

        if (strpos($pricestring, 'for 1 month') !== false) {

            if (strpos($pricestring, 'for 1 month and a') !== false) {

                $text = array(
                    "for 1 month and a"
                );

            } else {

                $text = array(
                    "for 1 month"
                );

            }

            $newprice = str_replace($text, '', $pricestring);
            // $newprice = 'bean';


        } elseif (strpos($pricestring, 'with 1 month free trial and a') !== false) {

            // $sign_up_cost = $product->product_custom_fields['_subscription_sign_up_fee'];
            $sign_up_cost = get_post_meta($product->id, '_subscription_sign_up_fee', true);
            $sign_up_cost .= '.00';
            $pattern[0]     = '/with 1 month free trial and a/';
            $replacement[0] = '';

            $price    = '$' . $sign_up_cost . ' sign-up fee & ' . strstr($pricestring, 'with', true);
            $newprice = $price;
            // $newprice = 'raver';

        } else {

            $newprice = $pricestring;
            // $newprice = 'bacon';

        }


    }

    if (is_product()) {
        if (strpos($pricestring, 'for 1 month') !== false) {

            if (strpos($pricestring, 'for 1 month and a') !== false) {

                $text = array(
                    "for 1 month and a"
                );

            } else {

                $text = array(
                    "for 1 month"
                );

            }

            $newprice = str_replace($text, '', $pricestring);
            // $newprice = 'bean';


        } elseif (strpos($pricestring, 'with 1 month free trial and a') !== false) {

            // $sign_up_cost = $product->product_custom_fields['_subscription_sign_up_fee'];
            $sign_up_cost = get_post_meta($product->id, '_subscription_sign_up_fee', true);
            $sign_up_cost .= '.00';
            $pattern[0]     = '/with 1 month free trial and a/';
            $replacement[0] = '';

            $price    = '$' . $sign_up_cost . ' sign-up fee & ' . strstr($pricestring, 'with', true);
            $newprice = $price;
            // $newprice = 'raver';

        } else {

            $newprice = $pricestring;
            // $newprice = 'bacon';

        }
    }
    return $newprice;
}

add_filter('woocommerce_subscription_price_string', 'my_subs_price_string_cart');
function my_subs_price_string_cart($pricestring)
{
    global $woocommerce, $product;

    if (is_checkout()) {
        foreach ($woocommerce->cart->get_cart() as $cart_item_key => $values) {
            $_product = $values['data'];

            if (strpos($pricestring, 'for 1 month') !== false) {

                $text = array(
                    "for 1 month"
                );

                $newprice = str_replace($text, '', $pricestring);
                // $newprice = 'word';


            } elseif (strpos($pricestring, 'with 1 month free trial and a') !== false) {

                // $sign_up_cost = $product->product_custom_fields['_subscription_sign_up_fee'];
                $sign_up_cost = get_post_meta($_product->get_id(), '_subscription_sign_up_fee', true);
                $sign_up_cost .= '.00';
                $pattern[0]     = '/with 1 month free trial and a/';
                $replacement[0] = '';

                $price    = '$' . $sign_up_cost . ' sign-up fee & ' . strstr($pricestring, 'with', true);
                $newprice = $price;
                // $newprice = 'hahah';

            } else {

                $newprice = $pricestring;
                // $newprice = 'what the';

            }

        }

    } else {

        $newprice = $pricestring;

    }
    return $newprice;
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
function grab_ids_in_category($respoj, $key)
{

    global $post, $woocommerce;
    //print_r($respoj);

    // Get the Id from the product in the cart
    foreach ($woocommerce->cart->get_cart() as $cart_item_key => $cart_item):
        $product_id = $cart_item['product_id'];
    endforeach;


    // Grab the schedule that matches the $product_id
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
    /* jaz added */
    //print_R($respoj);


    // die;

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

            if($respoj['class_event'] > 0) {
            // if (($respoj['location_' . $mcourid] > 0) && (!empty($respoj['event']))) {
                /* for($evestr=1;$evestr<=$respoj['location_'.$mcourid];$evestr++) {  // Display no of events choose in course */
                echo '<p>';
                echo '<label class="" for="coursename">';
                echo 'Events for course: ' . $respoj['coursename'];
                echo '</label>';
                echo '</p>';
                for ($evestr = 1; $evestr <= $respoj['class_event']; $evestr++) {
                    /* $look = 'false';
                    foreach ($respoj['event'] as $check) {

                        if ($check['event_eventid'] == $evestr) {
                            $look = 'true';
                            continue;
                        }
                    }
                    if ($look == 'false') {
                        // echo $evestr;
                        continue;
                    } */
                    echo '<p class="form-row text clearfix full-width validate-required" id="ccf_event_select_field_' . $evestr . '">';
                    echo '<label class="" for="ccf_event_select">';
                    // echo 'Select Event - ' . $evestr;
                    echo 'Select Event - ' . $key;
                    //echo '<abbr title="required" class="required"></abbr>';
                    echo '</label>';
                    /*echo '<select name="ccf_event_id[]" id="ccf_event_id_'.$evestr.'" class="select text" onchange=eventclass("'.$evestr.'")>';
                    echo '<option value="">Please select Event</option>';
                    for($evestrs=1;$evestrs<=$respoj['class_event'];$evestrs++) {
                    echo '<option value="'. $evestrs .'">Event '. $evestrs .'</option>';
                    }
                    echo '</select>'; */
                    echo '<input type="hidden" name="ccf_event_id[]" id="ccf_event_id_' . $evestr . '_' . $mcourid . '" class="select text" value ="' . $evestr . '">';

                    echo '</p>';

                    if (!empty($respoj['delivery_details'])) {

                        foreach ($respoj['delivery_method'] as $keymethod => $valuemethod) {

                            if (strtolower($valuemethod) == 'full delivery') {

                                echo '<p class="form-row text clearfix full-width validate-required" id="distance_learning_field_full_' . $evestr . '">';
                                echo '<label class="" for="distance_learning_field_full_' . $evestr . '">';
                                echo 'Full Delivery Course location - ' . $evestr;
                                echo '<abbr title="required" class="required"></abbr>';
                                echo '</label>';

                            } else if (strtolower($valuemethod) == 'blended delivery') {

                                echo '<p class="form-row text clearfix full-width validate-required" id="distance_learning_field_blended_' . $evestr . '">';
                                echo '<label class="" for="distance_learning_field_full_' . $evestr . '">';
                                echo 'Blended Delivery Course location - ' . $evestr;
                                echo '<abbr title="required" class="required"></abbr>';
                                echo '</label>';

                            } else {

                                echo '<p class="form-row text clearfix full-width validate-required" id="distance_learning_field_blended_' . $evestr . '">';
                                echo '<label class="" for="distance_learning_field_full_' . $evestr . '">';
                                echo 'Select Course Delivery Option - ' . $key;
                                echo '<abbr title="required" class="required"></abbr>';
                                echo '</label>';

                            }
                        } // end foreach

                        $count        = 0;
                        $totalevseats = 4;
                        //echo '<pre>';
                        //print_r($respoj['event']);

                        if (in_array('476', $cats)) {

                            $date = date('d-m-Y');
                            ;
                            $cdate          = strtotime($date);
                            $max_seat_check = get_post_meta($product_id, 'max_occupied_seats_', true);

                            $maxtime1 = ('+' . $max_seat_check * 7) . ' day';
                            $lastdate = strtotime($maxtime1, $cdate);

                            $min_seat_check = get_post_meta($product_id, 'min_occupied_seats_', true);

                            $mintime = ('+' . $min_seat_check * 7) . ' day';
                            $mindate = strtotime($mintime, $cdate);

                            echo '<select name="ccf_delivery_location_' . $key . '" id="ccf_delivery_location_' . $key . '_' . $mcourid . '" class="select text" onchange=eventlocation(' . $evestr . ',' . $mcourid . ')>';
                            echo '<option selected=selected>Please select your desired location</option>';
                            $exist = array();
                            foreach ($respoj['event'] as $valuedetailq) {
                                // print_r($valuedetailq);
                                // echo $cdate.'-';
                                //echo $lastdate.'--';
                                // echo $valuedetailq['event_timestart'].'---';
                                $keydetail = $valuedetailq['event_locid'];

                                if ($valuedetailq['event_timestart'] > $cdate && ($valuedetailq['event_timestart'] < $lastdate || $valuedetailq['event_timestart'] < $mindate) && !in_array($keydetail, $exist) && $valuedetailq['event_eventid'] == $evestr) {

                                    echo '<option id="ccf_course_' . $keydetail . '" value="' . $keydetail . '">' . $valuedetailq['location'] . '</option>';
                                    $exist[] = $keydetail;

                                }
                            } // end foreach
                            unset($exist);
                            echo "</select>";
                            echo '</p>';


                        } else {
                            $date = date('d-m-Y');
                            ;
                            $cdate = strtotime($date);
                            echo '<select name="ccf_delivery_location_' . $key . '" id="ccf_delivery_location_' . $evestr . '_' . $mcourid . '" class="select text" onchange=eventlocation(' . $evestr . ',' . $mcourid . ')>';
                            echo '<option selected=selected>Please select your desired location</option>';

                            /*  foreach($respoj['delivery_details'] as $keydetail => $valuedetail) {
                            if($valuedetail['eventid'] == $evestr){
                            echo '<option id="ccf_course_'. $keydetail .'" value="'. $keydetail .'">' . $valuedetail['location'] . '</option>';
                            }
                            } */
                            foreach ($respoj['event'] as $valuedetailq) {

                                $keydetail = $valuedetailq['event_locid'];

                                if ($valuedetailq['event_timestart'] > $cdate && !in_array($keydetail, $exist) && $valuedetailq['event_eventid'] == $evestr) {

                                    echo '<option id="ccf_course_' . $keydetail . '" value="' . $keydetail . '">' . $valuedetailq['location'] . '</option>';
                                    $exist[] = $keydetail;

                                }
                            } // end foreach
                            unset($exist);
                            echo "</select>";
                            echo '</p>';

                        } // end if/else cat 476

                    } // end if delivery_details

                    if (!empty($respoj['event'])) {

                        echo '<p class="form-row text clearfix full-width validate-required" id="full_location_timetable_new_' . $evestr . '">';
                        echo '<label class="" for="full_location_timetable_new_' . $key . '">';
                        echo 'Select Timetable - ' . $key;
                        echo '<abbr title="required" class="required"></abbr>';
                        echo '</label>';
                        echo '<select name="ccf_delivery_location_timetable_' . $key . '" id="ccf_delivery_location_timetable_full_' . $evestr . '_' . $mcourid . '" class="select text" onchange=eventupdate("' . $evestr . '_' . $mcourid . '")>';
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

                    }

                }
                /* end class event repeat */

            } // end if location course id

        } // end of delivery method

    } // end if respoj is not empty


    //print_r( $respoj['delivery_method']);
    echo "<div style='display:none;'>";
    print_r($respoj);
    echo "</div>";
    if ($respoj['delivery_method'][7]) {
        //if(($respoj['delivery_method'][7] == 'Distance') && (empty($respoj['event'])) && (empty($respoj['location_'.$mcourid]))){
        if (($respoj['delivery_method'][7] == 'Distance') && (empty($respoj['event']))) {

            echo '<div class="checkbox clearfix">
        <h5>Would you like to Start ASAP ? Otherwise choose a start date below.</h5>
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
        <input type="text"  autocomplete="off" class="input-text one-of-valid" name="ccf_distance_start_date" id="ccf_distance_start_date" placeholder="eg: dd/mm/yyyy" value="">
      </p>';

        }
    } // end if respoj delivery method

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

// Style sale and main price
add_filter('woocommerce_variable_sale_price_html', 'wc_wc20_variation_price_format', 10, 2);
add_filter('woocommerce_variable_price_html', 'wc_wc20_variation_price_format', 10, 2);
function wc_wc20_variation_price_format($price, $product)
{
    // Main Price
    $prices = array(
        $product->get_variation_price('min', true),
        $product->get_variation_price('max', true)
    );
    $price  = $prices[0] !== $prices[1] ? sprintf(__('From: %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);
    // Sale Price
    $prices = array(
        $product->get_variation_regular_price('min', true),
        $product->get_variation_regular_price('max', true)
    );
    sort($prices);
    $saleprice = $prices[0] !== $prices[1] ? sprintf(__('From: %1$s', 'woocommerce'), wc_price($prices[0])) : wc_price($prices[0]);

    if ($price !== $saleprice) {
        $price = '<del  style="color: rgb(255, 0, 0);">' . $saleprice . '</del> <ins style="color: rgb(255, 0, 0);">' . $price . '</ins>';
    }
    return $price;
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


