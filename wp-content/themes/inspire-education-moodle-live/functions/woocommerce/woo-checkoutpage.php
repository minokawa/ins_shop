<?php
// Remove Checkout fields
add_filter( 'woocommerce_checkout_fields' , 'override_company' );
function override_company( $fields ) {
  unset($fields['billing']['billing_company']);
  return $fields;
}

// Remove Order Comments
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
  unset($fields['order']['order_comments']);
  return $fields;
}

// Add agree to terms checkbox for laptops & software
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
    global $woocommerce;

    foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
      $_product = $values['data'];
      $product_id = $_product->get_id();
      $terms = get_the_terms( $product_id, 'product_cat' );

      //WTF!!!??? ARE TRYING TO DO???
      foreach ($terms as $term) {
        $product_cat_id = $term->term_id;
        break;
      }
    }

    // If the category is laptop or Software do noting...
    if (in_array($product_cat_id, array('462', '463', '466', '502') )) {
      if (!$_POST['ccf_terms_agree_hardware'])
           $woocommerce->add_error( __('<strong>Agree to Terms</strong> Please agree to our terms.') );
    }
}

// Get product cats function (to use in conditional for customised checkout fields)
function get_product_cats() {

  	global $woocommerce;
  	// Id's of the products in the cart
	$prod_ids = array();
	// Categories of the products in the cart
	$cats_cart = array();

	// Find the id('s) of the product(s) in the cart
	foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
	  $_product = $values['data'];
	  // $product_id is the id of the product in the cart
	  $product_id = $_product->get_id();
	  $prod_ids[] = $product_id;

	  $terms = get_the_terms( $product_id, 'product_cat' );
	    if(!empty($terms)){
		  foreach ($terms as $term) {

		    $product_cat_id = $term->term_id;
		    $product_cat_slug = $term->slug;
		    $cats_cart[] = $product_cat_id;

		  }
		}
	}

	if (empty($cats_cart)) {

	  $array1 = array("a" => '1');

	} else {

	  $array1 = $cats_cart;

	}

	$array2 = array("b" => '462', '463', '466', '502');
	$result = array_diff($array1, $array2);

	return $result;

}

// Is a product subscription renewal
function ma_is_subscription_renewal() {
  global $woocommerce;
  $is_renewal = false;
	foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$is_renewal = false;
		if(isset($values["subscription_renewal"])){
			$is_renewal = $values["subscription_renewal"]["renewal_order_id"];
		}
	}
	return $is_renewal;
}

// Replace Billing First name with 'Student Name'
add_filter( 'woocommerce_checkout_fields' , 'custom_override_first_name' );
function custom_override_first_name( $fields ) {
	$result = get_product_cats();
	$is_renewal = ma_is_subscription_renewal();
	// If the category is Alptop or Software do noting...
	// if (in_array($product_cat_id, array('462', '463', '466') )) {
	if (empty($result) || $is_renewal) {
	// do nothing
	// If is any other product and enrolment needs to take place...
	} else {
		$fields['billing']['billing_first_name']['placeholder'] = 'First name of student';
		$fields['billing']['billing_first_name']['label'] = 'Students First Name';
	}

	return $fields;
}

// Override Middle Name
add_filter( 'woocommerce_checkout_fields' , 'add_middle_name' );
function add_middle_name( $fields ) {

  	$result = get_product_cats();
  	$is_renewal = ma_is_subscription_renewal();

	// If the category is Alptop or Software do noting...
	// if (in_array($product_cat_id, array('462', '463', '466') )) {
	if (empty($result) || $is_renewal) {

	$fields['billing']['billing_middle_name'] = array(
	  'label'     => __('Middle Name', 'woocommerce'),
	  'placeholder'   => _x('Middle name', 'placeholder', 'woocommerce'),
	  'required'  => false,
	  'clear'     => true
	);

	// If is any other product and enrolment needs to take place...
	} else {

	 $fields['billing']['billing_middle_name'] = array(
	    'label'     => __('Students Middle Name', 'woocommerce'),
	    'placeholder'   => _x('Students middle name', 'placeholder', 'woocommerce'),
	    'required'  => false,
	    'clear'     => true
	 );

	}

	return $fields;
}

// Override Last name
add_filter( 'woocommerce_checkout_fields' , 'custom_override_last_name' );
function custom_override_last_name( $fields ) {

	$result = get_product_cats();
	$is_renewal = ma_is_subscription_renewal();

	// If the category is Laptop or Software do noting...
	// if (in_array($product_cat_id, array('462', '463', '466') )) {
	if (empty($result) || $is_renewal) {

	// do nothing

	// If is any other product and enrolment needs to take place...
	} else {

		$fields['billing']['billing_last_name']['label'] = 'Students Last Name';
		$fields['billing']['billing_last_name']['placeholder'] = 'Last name of student';

	}

	return $fields;

}

// ABN
add_filter( 'woocommerce_checkout_fields' , 'add_abn_shipping' );
function add_abn_shipping( $fields ) {

	$result = get_product_cats();
	$is_renewal = ma_is_subscription_renewal();

	// If the category is Alptop or Software do noting...
	// if (in_array($product_cat_id, array('462', '463', '466') )) {
	if (empty($result) || $is_renewal) {

	// do nothing

	// If is any other product and enrolment needs to take place...
	} else {

	 $fields['shipping']['shipping_abn'] = array(
	    'label'     => __('ABN', 'woocommerce'),
	    'placeholder'   => _x('Your ABN number', 'placeholder', 'woocommerce'),
	    'required'  => false,
	    'class'     => array('form-row-wide'),
	    'clear'     => true
	 );
	}

	return $fields;
}

// Overide State label
add_filter( 'woocommerce_checkout_fields' , 'override_state' );
function override_state( $fields ) {
     $fields['billing']['billing_state']['label'] = 'State';
     return $fields;
}

// Overide Postcode
add_filter( 'woocommerce_checkout_fields' , 'override_postcode' );
function override_postcode( $fields ) {
     $fields['billing']['billing_postcode']['label'] = 'Postcode';
     return $fields;
}

// Override Second billing address
add_filter( 'woocommerce_checkout_fields' , 'custom_override_address_2' );
function custom_override_address_2( $fields ) {

    unset($fields['billing']['billing_address_2']);
    return $fields;
}

// Shipping Email
add_filter( 'woocommerce_checkout_fields' , 'add_email_shipping' );
function add_email_shipping( $fields ) {
     $fields['shipping']['shipping_email'] = array(
        'label'     => __('Contact Email', 'woocommerce'),
        'placeholder'   => _x('Company contact', 'placeholder', 'woocommerce'),
        'required'  => false,
        'class'     => array('form-row-wide'),
        'clear'     => false
     );

     return $fields;
}


//extra fields of home address
// Overide Building/property name
add_filter( 'woocommerce_checkout_fields' , 'override_pname' );
// Our hooked in function - $fields is passed via the filter!
function override_pname( $fields ) {
	$fields['billing']['billing_pname'] = array(
        'label'     => __('Building/property name', 'woocommerce'),
        'placeholder'   => _x('Building/property name', 'placeholder', 'woocommerce'),
        'input_class'     => array('home-valid-add'),
     );
	return $fields;
}


// Overide Flat/unit number
add_filter( 'woocommerce_checkout_fields' , 'override_platno' );
// Our hooked in function - $fields is passed via the filter!
function override_platno( $fields ) {
	$fields['billing']['billing_platno'] = array(
        'label'     => __('Flat/unit number', 'woocommerce'),
        'placeholder'   => _x('Flat/unit number', 'placeholder', 'woocommerce'),
        'input_class'     => array('home-valid-add'),
     );
	return $fields;
}


// Overide Building/property name
add_filter( 'woocommerce_checkout_fields' , 'override_lotno' );
// Our hooked in function - $fields is passed via the filter!
function override_lotno( $fields ) {
     $fields['billing']['billing_lotno'] = array(
        'label'     => __('Street/Lot Number', 'woocommerce'),
        'placeholder'   => _x('Street/Lot Number', 'placeholder', 'woocommerce'),
        'input_class'     => array('home-valid-add'),
     );
     return $fields;
}

// Overide Building/property name
add_filter( 'woocommerce_checkout_fields' , 'override_sname' );
// Our hooked in function - $fields is passed via the filter!
function override_sname( $fields ) {
     $fields['billing']['billing_sname']['label'] = 'Street Name';
	  $fields['billing']['billing_sname']['placeholder'] = 'Street Name';
	   $fields['billing']['billing_sname']['required'] = true;
     return $fields;
}

// Overide Building/property name
add_filter( 'woocommerce_checkout_fields' , 'override_address' );
// Our hooked in function - $fields is passed via the filter!
function override_address( $fields ) {
     $fields['billing']['billing_address_1']['label'] = 'Address';
	  $fields['billing']['billing_address_1']['placeholder'] = 'Address';
	  $fields['billing']['billing_address_1']['required'] = false;
     return $fields;
}

// Overide Building/property name
add_filter( 'woocommerce_checkout_fields' , 'override_billing_phone' );
// Our hooked in function - $fields is passed via the filter!
function override_billing_phone( $fields ) {
     $fields['billing']['billing_phone']['label'] = 'Phone';
	  $fields['billing']['billing_phone']['placeholder'] = 'Phone';
	  $fields['billing']['billing_phone']['required'] = false;
     return $fields;
}

// Home Phone
add_filter( 'woocommerce_checkout_fields' , 'override_home_phone' );
// Our hooked in function - $fields is passed via the filter!
function override_home_phone( $fields ) {
     $fields['billing']['billing_home_phone'] = array(
        'label'     => __('Home Phone No.', 'woocommerce'),
        'placeholder'   => _x('Home Phone No.', 'placeholder', 'woocommerce'),
        'required'  => false,
		'class' => array('one-of-valids'),
     );

     return $fields;
}

// Work Phone
add_filter( 'woocommerce_checkout_fields' , 'override_work_phone' );
// Our hooked in function - $fields is passed via the filter!
function override_work_phone( $fields ) {
     $fields['billing']['billing_work_phone'] = array(
        'label'     => __('Work Phone No.', 'woocommerce'),
        'placeholder'   => _x('Work Phone No.', 'placeholder', 'woocommerce'),
        'required'  => false,
		'class' => array('one-of-valids'),
        'clear'     => false
     );

     return $fields;
}

// Mobile Phone
add_filter( 'woocommerce_checkout_fields' , 'override_mobile_phone' );
// Our hooked in function - $fields is passed via the filter!
function override_mobile_phone( $fields ) {
     $fields['billing']['billing_mobile_phone'] = array(
        'label'     => __('Mobile Phone', 'woocommerce'),
        'placeholder'   => _x('Mobile Phone', 'placeholder', 'woocommerce'),
        'required'  => false,
		'class' => array('one-of-valids'),
        'clear'     => false
     );

     return $fields;
}

// Work Mobile

add_filter( 'woocommerce_checkout_fields' , 'override_work_mobile' );
// Our hooked in function - $fields is passed via the filter!
function override_work_mobile( $fields ) {
     $fields['billing']['billing_work_mobile'] = array(
        'label'     => __('Work Mobile', 'woocommerce'),
        'placeholder'   => _x('Work Mobile', 'placeholder', 'woocommerce'),
        'required'  => false,
		'class' => array('one-of-valids'),
        'clear'     => false
     );

     return $fields;
}


//FOR 'SELECT' WOO FIELDS
function get_country_options(){
  $countries = array('' => __('Select', 'woocommerce' ),'Australia' => __('Australia', 'woocommerce' ),'Adélie Land (France)' => __('Adélie Land (France)', 'woocommerce' ),'Afghanistan' => __('Afghanistan', 'woocommerce' ),'Aland Islands' => __('Aland Islands', 'woocommerce' ),'Albania' => __('Albania', 'woocommerce' ),'Algeria' => __('Algeria', 'woocommerce' ),'Americas, Not Further Defined' => __('Americas, Not Further Defined', 'woocommerce' ),'Andorra' => __('Andorra', 'woocommerce' ),'Angola' => __('Angola', 'woocommerce' ),'Anguilla' => __('Anguilla', 'woocommerce' ),'Antarctica, not further defined' => __('Antarctica, not further defined', 'woocommerce' ),'Antigua and Barbuda' => __('Antigua and Barbuda', 'woocommerce' ),'Argentina' => __('Argentina', 'woocommerce' ),'Argentinian Antarctic Territory' => __('Argentinian Antarctic Territory', 'woocommerce' ),'Armenia' => __('Armenia', 'woocommerce' ),'Aruba' => __('Aruba', 'woocommerce' ),'At Sea' => __('At Sea', 'woocommerce' ),'Australia' => __('Australia', 'woocommerce' ),'Australia (includes External Territories), not further defined' => __('Australia (includes External Territories), not further defined', 'woocommerce' ),'Australian Antarctic Territory' => __('Australian Antarctic Territory', 'woocommerce' ),'Australian External Territories, n.e.c.' => __('Australian External Territories, n.e.c.', 'woocommerce' ),'Austria' => __('Austria', 'woocommerce' ),'Azerbaijan' => __('Azerbaijan', 'woocommerce' ),'Bahamas' => __('Bahamas', 'woocommerce' ),'Bahrain' => __('Bahrain', 'woocommerce' ),'Bangladesh' => __('Bangladesh', 'woocommerce' ),'Barbados' => __('Barbados', 'woocommerce' ),'Belarus' => __('Belarus', 'woocommerce' ),'Belgium' => __('Belgium', 'woocommerce' ),'Belize' => __('Belize', 'woocommerce' ),'Benin' => __('Benin', 'woocommerce' ),'Bermuda' => __('Bermuda', 'woocommerce' ),'Bhutan' => __('Bhutan', 'woocommerce' ),'Bolivia' => __('Bolivia', 'woocommerce' ),'Bonaire, Sint Eustatius and Saba' => __('Bonaire, Sint Eustatius and Saba', 'woocommerce' ),'Bosnia and Herzegovina' => __('Bosnia and Herzegovina', 'woocommerce' ),'Botswana' => __('Botswana', 'woocommerce' ),'Brazil' => __('Brazil', 'woocommerce' ),'British Antarctic Territory' => __('British Antarctic Territory', 'woocommerce' ),'Brunei Darussalam' => __('Brunei Darussalam', 'woocommerce' ),'Bulgaria' => __('Bulgaria', 'woocommerce' ),'Burkina Faso' => __('Burkina Faso', 'woocommerce' ),'Burma (Myanmar)' => __('Burma (Myanmar)', 'woocommerce' ),'Burundi' => __('Burundi', 'woocommerce' ),'Cambodia' => __('Cambodia', 'woocommerce' ),'Cameroon' => __('Cameroon', 'woocommerce' ),'Canada' => __('Canada', 'woocommerce' ),'Cape Verde' => __('Cape Verde', 'woocommerce' ),'Caribbean, not further defined' => __('Caribbean, not further defined', 'woocommerce' ),'Cayman Islands' => __('Cayman Islands', 'woocommerce' ),'Central African Republic' => __('Central African Republic', 'woocommerce' ),'Central America, not further defined' => __('Central America, not further defined', 'woocommerce' ),'Central and West Africa, not further defined' => __('Central and West Africa, not further defined', 'woocommerce' ),'Central Asia, not further defined' => __('Central Asia, not further defined', 'woocommerce' ),'Chad' => __('Chad', 'woocommerce' ),'Chile' => __('Chile', 'woocommerce' ),'Chilean Antarctic Territory' => __('Chilean Antarctic Territory', 'woocommerce' ),'China (excludes SARs and Taiwan Province)' => __('China (excludes SARs and Taiwan Province)', 'woocommerce' ),'Chinese Asia (includes Mongolia), not further defined' => __('Chinese Asia (includes Mongolia), not further defined', 'woocommerce' ),'Colombia' => __('Colombia', 'woocommerce' ),'Comoros (excluding Mayotte)' => __('Comoros (excluding Mayotte)', 'woocommerce' ),'Congo' => __('Congo', 'woocommerce' ),'Congo, Democratic Republic of' => __('Congo, Democratic Republic of', 'woocommerce' ),'Cook Islands' => __('Cook Islands', 'woocommerce' ),'Costa Rica' => __('Costa Rica', 'woocommerce' ),'Croatia' => __('Croatia', 'woocommerce' ),'Cuba' => __('Cuba', 'woocommerce' ),'Curacao' => __('Curacao', 'woocommerce' ),'Cyprus' => __('Cyprus', 'woocommerce' ),'Czech Republic' => __('Czech Republic', 'woocommerce' ),'Denmark' => __('Denmark', 'woocommerce' ),'Djibouti' => __('Djibouti', 'woocommerce' ),'Dominica' => __('Dominica', 'woocommerce' ),'Dominican Republic' => __('Dominican Republic', 'woocommerce' ),'East Timor' => __('East Timor', 'woocommerce' ),'Eastern Europe, not further defined' => __('Eastern Europe, not further defined', 'woocommerce' ),'Ecuador' => __('Ecuador', 'woocommerce' ),'Egypt' => __('Egypt', 'woocommerce' ),'El Salvador' => __('El Salvador', 'woocommerce' ),'England' => __('England', 'woocommerce' ),'Equatorial Guinea' => __('Equatorial Guinea', 'woocommerce' ),'Eritrea' => __('Eritrea', 'woocommerce' ),'Estonia' => __('Estonia', 'woocommerce' ),'Ethiopia' => __('Ethiopia', 'woocommerce' ),'Faeroe Islands' => __('Faeroe Islands', 'woocommerce' ),'Falkland Islands' => __('Falkland Islands', 'woocommerce' ),'Fiji' => __('Fiji', 'woocommerce' ),'Finland' => __('Finland', 'woocommerce' ),'Former Yugoslav Republic of Macedonia (FYROM)' => __('Former Yugoslav Republic of Macedonia (FYROM)', 'woocommerce' ),'France' => __('France', 'woocommerce' ),'French Guiana' => __('French Guiana', 'woocommerce' ),'French Polynesia' => __('French Polynesia', 'woocommerce' ),'Gabon' => __('Gabon', 'woocommerce' ),'Gambia' => __('Gambia', 'woocommerce' ),'Gaza Strip and West Bank' => __('Gaza Strip and West Bank', 'woocommerce' ),'Georgia' => __('Georgia', 'woocommerce' ),'Germany' => __('Germany', 'woocommerce' ),'Ghana' => __('Ghana', 'woocommerce' ),'Gibraltar' => __('Gibraltar', 'woocommerce' ),'Greece' => __('Greece', 'woocommerce' ),'Greenland' => __('Greenland', 'woocommerce' ),'Grenada' => __('Grenada', 'woocommerce' ),'Guadeloupe' => __('Guadeloupe', 'woocommerce' ),'Guam' => __('Guam', 'woocommerce' ),'Guatemala' => __('Guatemala', 'woocommerce' ),'Guernsey' => __('Guernsey', 'woocommerce' ),'Guinea' => __('Guinea', 'woocommerce' ),'Guinea-Bissau' => __('Guinea-Bissau', 'woocommerce' ),'Guyana' => __('Guyana', 'woocommerce' ),'Haiti' => __('Haiti', 'woocommerce' ),'Holy See' => __('Holy See', 'woocommerce' ),'Honduras' => __('Honduras', 'woocommerce' ),'Hong Kong (SAR of China)' => __('Hong Kong (SAR of China)', 'woocommerce' ),'Hungary' => __('Hungary', 'woocommerce' ),'Iceland' => __('Iceland', 'woocommerce' ),'Inadequately Described' => __('Inadequately Described', 'woocommerce' ),'India' => __('India', 'woocommerce' ),'Indonesia' => __('Indonesia', 'woocommerce' ),'Iran' => __('Iran', 'woocommerce' ),'Iraq' => __('Iraq', 'woocommerce' ),'Ireland' => __('Ireland', 'woocommerce' ),'Isle of Man' => __('Isle of Man', 'woocommerce' ),'Israel' => __('Israel', 'woocommerce' ),'Italy' => __('Italy', 'woocommerce' ),'Jamaica' => __('Jamaica', 'woocommerce' ),'Japan' => __('Japan', 'woocommerce' ),'Japan and the Koreas, not further defined' => __('Japan and the Koreas, not further defined', 'woocommerce' ),'Jersey' => __('Jersey', 'woocommerce' ),'Jordan' => __('Jordan', 'woocommerce' ),'Kazakhstan' => __('Kazakhstan', 'woocommerce' ),'Kenya' => __('Kenya', 'woocommerce' ),'Kiribati' => __('Kiribati', 'woocommerce' ),'Korea, Republic of (South)' => __('Korea, Republic of (South)', 'woocommerce' ),'Kosovo' => __('Kosovo', 'woocommerce' ),'Kuwait' => __('Kuwait', 'woocommerce' ),'Kyrgyz Republic' => __('Kyrgyz Republic', 'woocommerce' ),'Laos' => __('Laos', 'woocommerce' ),'Latvia' => __('Latvia', 'woocommerce' ),'Lebanon' => __('Lebanon', 'woocommerce' ),'Lesotho' => __('Lesotho', 'woocommerce' ),'Liberia' => __('Liberia', 'woocommerce' ),'Libya' => __('Libya', 'woocommerce' ),'Liechtenstein' => __('Liechtenstein', 'woocommerce' ),'Lithuania' => __('Lithuania', 'woocommerce' ),'Luxembourg' => __('Luxembourg', 'woocommerce' ),'Macau' => __('Macau', 'woocommerce' ),'Madagascar' => __('Madagascar', 'woocommerce' ),'Mainland South-East Asia, not further defined' => __('Mainland South-East Asia, not further defined', 'woocommerce' ),'Malawi' => __('Malawi', 'woocommerce' ),'Malaysia' => __('Malaysia', 'woocommerce' ),'Maldives' => __('Maldives', 'woocommerce' ),'Mali' => __('Mali', 'woocommerce' ),'Malta' => __('Malta', 'woocommerce' ),'Maritime South-East Asia, not further defined' => __('Maritime South-East Asia, not further defined', 'woocommerce' ),'Marshall Islands' => __('Marshall Islands', 'woocommerce' ),'Martinique' => __('Martinique', 'woocommerce' ),'Mauritania' => __('Mauritania', 'woocommerce' ),'Mauritius' => __('Mauritius', 'woocommerce' ),'Mayotte' => __('Mayotte', 'woocommerce' ),'Melanesia, not further defined' => __('Melanesia, not further defined', 'woocommerce' ),'Mexico' => __('Mexico', 'woocommerce' ),'Micronesia, Federated States of' => __('Micronesia, Federated States of', 'woocommerce' ),'Micronesia, not further defined' => __('Micronesia, not further defined', 'woocommerce' ),'Middle East, not further defined' => __('Middle East, not further defined', 'woocommerce' ),'Moldova' => __('Moldova', 'woocommerce' ),'Monaco' => __('Monaco', 'woocommerce' ),'Mongolia' => __('Mongolia', 'woocommerce' ),'Montenegro' => __('Montenegro', 'woocommerce' ),'Montserrat' => __('Montserrat', 'woocommerce' ),'Morocco' => __('Morocco', 'woocommerce' ),'Mozambique' => __('Mozambique', 'woocommerce' ),'Namibia' => __('Namibia', 'woocommerce' ),'Nauru' => __('Nauru', 'woocommerce' ),'Nepal' => __('Nepal', 'woocommerce' ),'Netherlands' => __('Netherlands', 'woocommerce' ),'New Caledonia' => __('New Caledonia', 'woocommerce' ),'New Zealand' => __('New Zealand', 'woocommerce' ),'Nicaragua' => __('Nicaragua', 'woocommerce' ),'Niger' => __('Niger', 'woocommerce' ),'Nigeria' => __('Nigeria', 'woocommerce' ),'Niue' => __('Niue', 'woocommerce' ),'Norfolk Island' => __('Norfolk Island', 'woocommerce' ),'North Africa and the Middle East, Not Further Defined' => __('North Africa and the Middle East, Not Further Defined', 'woocommerce' ),'North Africa, not further defined' => __('North Africa, not further defined', 'woocommerce' ),'North-East Asia, Not Further Defined' => __('North-East Asia, Not Further Defined', 'woocommerce' ),'North-West Europe, Not Further Defined' => __('North-West Europe, Not Further Defined', 'woocommerce' ),'Northern America, not further defined' => __('Northern America, not further defined', 'woocommerce' ),'Northern Europe, not further defined' => __('Northern Europe, not further defined', 'woocommerce' ),'Northern Ireland' => __('Northern Ireland', 'woocommerce' ),'Northern Mariana Islands' => __('Northern Mariana Islands', 'woocommerce' ),'Norway' => __('Norway', 'woocommerce' ),'Not Elsewhere Classified' => __('Not Elsewhere Classified', 'woocommerce' ),'Not Stated' => __('Not Stated', 'woocommerce' ),'Oceania and Antarctica (not further defined)' => __('Oceania and Antarctica (not further defined)', 'woocommerce' ),'Oman' => __('Oman', 'woocommerce' ),'Pakistan' => __('Pakistan', 'woocommerce' ),'Palau' => __('Palau', 'woocommerce' ),'Panama' => __('Panama', 'woocommerce' ),'Papua New Guinea' => __('Papua New Guinea', 'woocommerce' ),'Paraguay' => __('Paraguay', 'woocommerce' ),'Peru' => __('Peru', 'woocommerce' ),'Philippines' => __('Philippines', 'woocommerce' ),'Pitcairn Islands' => __('Pitcairn Islands', 'woocommerce' ),'Poland' => __('Poland', 'woocommerce' ),'Polynesia (excludes Hawaii), nec' => __('Polynesia (excludes Hawaii), nec', 'woocommerce' ),'Polynesia (excludes Hawaii), not further defined' => __('Polynesia (excludes Hawaii), not further defined', 'woocommerce' ),'Portugal' => __('Portugal', 'woocommerce' ),'Puerto Rico' => __('Puerto Rico', 'woocommerce' ),'Qatar' => __('Qatar', 'woocommerce' ),'Queen Maud Land (Norway)' => __('Queen Maud Land (Norway)', 'woocommerce' ),'Réunion' => __('Réunion', 'woocommerce' ),'Romania' => __('Romania', 'woocommerce' ),'Ross Dependency (New Zealand)' => __('Ross Dependency (New Zealand)', 'woocommerce' ),'Russian Federation' => __('Russian Federation', 'woocommerce' ),'Rwanda' => __('Rwanda', 'woocommerce' ),'Samoa,' => __('Samoa,', 'woocommerce' ),'Samoa, American' => __('Samoa, American', 'woocommerce' ),'San Marino' => __('San Marino', 'woocommerce' ),'Sao Tomé and Principe' => __('Sao Tomé and Principe', 'woocommerce' ),'Saudi Arabia' => __('Saudi Arabia', 'woocommerce' ),'Scotland' => __('Scotland', 'woocommerce' ),'Senegal' => __('Senegal', 'woocommerce' ),'Serbia' => __('Serbia', 'woocommerce' ),'Seychelles' => __('Seychelles', 'woocommerce' ),'Sierra Leone' => __('Sierra Leone', 'woocommerce' ),'Singapore' => __('Singapore', 'woocommerce' ),'Sint Maarten (Dutch part)' => __('Sint Maarten (Dutch part)', 'woocommerce' ),'Slovakia' => __('Slovakia', 'woocommerce' ),'Slovenia' => __('Slovenia', 'woocommerce' ),'Solomon Islands' => __('Solomon Islands', 'woocommerce' ),'Somalia' => __('Somalia', 'woocommerce' ),'South Africa' => __('South Africa', 'woocommerce' ),'South America, nec' => __('South America, nec', 'woocommerce' ),'South America, not further defined' => __('South America, not further defined', 'woocommerce' ),'South Eastern Europe, not further defined' => __('South Eastern Europe, not further defined', 'woocommerce' ),'South Sudan' => __('South Sudan', 'woocommerce' ),'South-East Asia, Not Further Defined' => __('South-East Asia, Not Further Defined', 'woocommerce' ),'Southern and Central Asia, Not Further Defined' => __('Southern and Central Asia, Not Further Defined', 'woocommerce' ),'Southern and East Africa, nec' => __('Southern and East Africa, nec', 'woocommerce' ),'Southern and East Africa, not further defined' => __('Southern and East Africa, not further defined', 'woocommerce' ),'Southern and Eastern Europe, Not Further Defined' => __('Southern and Eastern Europe, Not Further Defined', 'woocommerce' ),'Southern Asia, not further defined' => __('Southern Asia, not further defined', 'woocommerce' ),'Southern Europe, not further defined' => __('Southern Europe, not further defined', 'woocommerce' ),'Spain' => __('Spain', 'woocommerce' ),'Spanish North Africa' => __('Spanish North Africa', 'woocommerce' ),'Sri Lanka' => __('Sri Lanka', 'woocommerce' ),'St Barthelemy' => __('St Barthelemy', 'woocommerce' ),'St Helena' => __('St Helena', 'woocommerce' ),'St Kitts and Nevis' => __('St Kitts and Nevis', 'woocommerce' ),'St Lucia' => __('St Lucia', 'woocommerce' ),'St Martin (French part)' => __('St Martin (French part)', 'woocommerce' ),'St Pierre and Miquelon' => __('St Pierre and Miquelon', 'woocommerce' ),'St Vincent and the Grenadines' => __('St Vincent and the Grenadines', 'woocommerce' ),'Sub-Saharan Africa, Not Further Defined' => __('Sub-Saharan Africa, Not Further Defined', 'woocommerce' ),'Sudan' => __('Sudan', 'woocommerce' ),'Suriname' => __('Suriname', 'woocommerce' ),'Swaziland' => __('Swaziland', 'woocommerce' ),'Sweden' => __('Sweden', 'woocommerce' ),'Switzerland' => __('Switzerland', 'woocommerce' ),'Syria' => __('Syria', 'woocommerce' ),'Tadjikistan' => __('Tadjikistan', 'woocommerce' ),'Taiwan (Province of China)' => __('Taiwan (Province of China)', 'woocommerce' ),'Tanzania' => __('Tanzania', 'woocommerce' ),'Thailand' => __('Thailand', 'woocommerce' ),'Togo' => __('Togo', 'woocommerce' ),'Tokelau' => __('Tokelau', 'woocommerce' ),'Tonga' => __('Tonga', 'woocommerce' ),'Trinidad and Tobago' => __('Trinidad and Tobago', 'woocommerce' ),'Tunisia' => __('Tunisia', 'woocommerce' ),'Turkey' => __('Turkey', 'woocommerce' ),'Turkmenistan' => __('Turkmenistan', 'woocommerce' ),'Turks and Caicos Islands' => __('Turks and Caicos Islands', 'woocommerce' ),'Tuvalu' => __('Tuvalu', 'woocommerce' ),'Uganda' => __('Uganda', 'woocommerce' ),'Ukraine' => __('Ukraine', 'woocommerce' ),'United Arab Emirates' => __('United Arab Emirates', 'woocommerce' ),'United Kingdom, not further defined' => __('United Kingdom, not further defined', 'woocommerce' ),'United States of America' => __('United States of America', 'woocommerce' ),'Uruguay' => __('Uruguay', 'woocommerce' ),'Uzbekistan' => __('Uzbekistan', 'woocommerce' ),'Vanuatu' => __('Vanuatu', 'woocommerce' ),'Venezuela' => __('Venezuela', 'woocommerce' ),'Viet Nam' => __('Viet Nam', 'woocommerce' ),'Virgin Islands, British' => __('Virgin Islands, British', 'woocommerce' ),'Virgin Islands, United States' => __('Virgin Islands, United States', 'woocommerce' ),'Wales' => __('Wales', 'woocommerce' ),'Wallis and Futuna' => __('Wallis and Futuna', 'woocommerce' ),'Western Europe, not further defined' => __('Western Europe, not further defined', 'woocommerce' ),'Western Sahara' => __('Western Sahara', 'woocommerce' ),'Yemen' => __('Yemen', 'woocommerce' ),'Zambia' => __('Zambia', 'woocommerce' ),'Zimbabwe' => __('Zimbabwe', 'woocommerce' )
  );
  return  $countries;
}
