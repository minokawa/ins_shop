<?php

// Paypal Standard for timed payments
// PayPal PayFlow for one off payments
function filter_gateways($gateways){

	$paypalflow 	= 'paypal_pro_payflow'; // one off payments
	$paypal 		= 'paypal'; // recurring payments
	$electronic 	= 'bacs';
	$cheque 		= 'cheque';
	$directdebit	= 'cod';
	$category_ID 	= '20';


	// // one off payment subscription
	// string(92) "Free! $1,490.00 "

	// // recurring payment, no sign up
	// string(103) "$650.00 / month for 3 months"

	// // recurring payment with sign-up fee
	// string(119) "$600.00 sign-up fee & $225.00 / month for 6 months "


	global $woocommerce;
	foreach ($woocommerce->cart->cart_contents as $key => $values ) {
		$_product = $values['data'];
		// $product_id is the id of the product in the cart
		$product_id = $_product->get_id();
	    $sign_up_cost = get_post_meta( $_product->get_id(), '_subscription_sign_up_fee', true );
	    $sub_length = get_post_meta( $_product->get_id(), '_subscription_length', true );

	    $pricestring = $_product->get_price_html();


        if (strpos($pricestring, 'month for') !== false || strpos($pricestring, 'up fee') !== false) {

	        	unset($gateways[$electronic]);
	        	unset($gateways[$cheque]);

		}

	}

	return $gateways;

}

add_filter('woocommerce_available_payment_gateways','filter_gateways');

// Change Icon for PayPal gateway
function replacePayPalIcon($iconUrl) {
	return get_stylesheet_directory_uri() . '/assets/images/accepted-cards.png';
}

add_filter('woocommerce_paypal_icon', 'replacePayPalIcon');


?>
