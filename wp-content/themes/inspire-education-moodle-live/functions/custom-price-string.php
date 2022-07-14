<?php


add_filter( 'woocommerce_subscriptions_product_price_string', 'wcs_custom_price_strings', 10, 3 );

function wcs_custom_price_strings( $subscription_string, $product, $include ) {
	// $product_id = $product->get_id();
	// if ( ! isset( $include['custom'] ) ) {
	// 	$include['custom'] = true;
	// }

	// $custom_price_string = get_post_meta( $product_id, '_custom_price_string', true );
	// if ( false !== $custom_price_string && '' !== $custom_price_string && false !== $include['custom'] ) {
	// 	$subscription_string = $custom_price_string;
	// }
	//$subscription_string = 'heyo!!!!';
		if($product->post_type() == ''){

		}
	// <p><em><span style="color: #ff0000;"><b>Upfront Payment of&nbsp; Only</b> <strong><del>$1,499</del> $1,495</strong> + 3 Monthly Payments of <del>$332</del> $166.67 <strong>(Total <del>$2,495</del> $1,995)</strong></span></em></p>
	return $subscription_string;
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


