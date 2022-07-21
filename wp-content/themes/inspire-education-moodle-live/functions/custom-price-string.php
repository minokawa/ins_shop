<?php


add_filter( 'woocommerce_subscriptions_product_price_string', 'inspire_subscription_price_string', 10, 3 );

function inspire_subscription_price_string( $subscription_string, $product, $include ) {

	if($product->is_type( 'subscription' )){
		return $subscription_string;
	}

	$sign_up_fee = get_post_meta( $product->get_id(), '_subscription_sign_up_fee', true );
	$subscription_period = get_post_meta( $product->get_id(), '_subscription_period', true );
	$period_interval = get_post_meta( $product->get_id(), '_subscription_period_interval', true );
	$subscription_price = $product->get_price(); //get_post_meta( $product->get_id(), '_subscription_price', true );
	$subscription_length = get_post_meta( $product->get_id(), '_subscription_length', true );

	//Variable Subscription Product
	if($product->is_type( 'variable-subscription' )){
		return '';
		//"<span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>15.38</bdi></span> <span class="subscription-details"> / week for 26 weeks with 1 week free trial and a <span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">&#36;</span>890.00</bdi></span> sign-up fee</span>"
	}

	//The 'Variant' of the 'Variable Subscription'
	if($product->is_type( 'subscription_variation' )){

		$sp = "<span class='woocommerce-Price-amount amount'>
						<bdi>
							<span class='woocommerce-Price-currencySymbol'>&#36;</span>$sign_up_fee
						</bdi>
						Upfront payment and
						<span class='woocommerce-Price-amount amount'>
							<bdi><span class='woocommerce-Price-currencySymbol'>&#36;</span>$subscription_price</bdi>
						</span>
						<span class='subscription-details'>
							every $period_interval $subscription_period for $subscription_length $subscription_period/s
						</span>
					</span>";
		return $sp;
	}

	return $subscription_string;
}

add_filter('woocommerce_product_single_add_to_cart_text', 'inspire_product_button_text', 99, 2 );

function inspire_product_button_text( $button_text, $product ) {
   //Add to cart button for product links
	if($product->is_type( 'external' )){
		return 'View Product/s';
	}


	return 'Enrol Now';
}

add_filter('gettext', 'woo_translate_payment_terms', 999, 3);

function woo_translate_payment_terms($translated, $untranslated, $domain){
	if($domain == "woocommerce" ){

		if (strpos($translated, 'Cash on delivery') !== false) {
			$translated = str_ireplace('Cash on delivery', 'Direct debit', $translated);
		}

		if (strpos($translated, 'Cash on Delivery') !== false) {
			$translated = str_ireplace('Cash on Delivery', 'Direct Debit', $translated);
		}

		if (strpos($translated, 'Sort Code') !== false) {
			$translated = str_ireplace('Sort Code', 'BSB', $translated);
		}

		if (strpos($translated, 'Sort code') !== false) {
			$translated = str_ireplace('Sort code', 'BSB', $translated);
		}

	}

	return $translated;
}


