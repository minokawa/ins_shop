<?php

function ma_customised_price_string($price_string, $cart_item = null, $cart_item_key= null) {

	global $product, $post, $woocommerce,$item_id;
	$variation = '';
	$ctr = 0;

//	if(is_null( $woocommerce->cart)){
		return $price_string;
	//}

	if (is_shop() || is_product()) {
		// $prod_id = $product->get_id;
	} else {


		$cart_items = $woocommerce->cart->get_cart();
		foreach( WC()->cart->get_cart() as $cart_item ){
			$product = wc_get_product($cart_item['product_id']);
		}
	}

		if (strpos($price_string, 'with 1 month free trial and a') !== false) {
			$sign_up_cost = 	$product->get_meta( '_subscription_sign_up_fee' ); //$product->product_custom_fields['_subscription_sign_up_fee'];

			$pattern  = '/with 1 month free trial and a/';
			$replacement  = '';
			$price = '$<span itemprop="price">'.$sign_up_cost .'</span> sign-up fee & '.strstr($price_string, 'with', true);
		} elseif (strpos($price_string, 'Free!') !== false) {

				$price = '';
				$sign_up_sale_cost = get_post_meta( $product->get_id, 'woo-orig-price', true );
				$pattern  = '/and a/';
				$replacement  = '';
				$removefree = preg_replace($pattern , $replacement , $price_string);
				$pattern2  = '/Free!/';
				$replacement2  = '';
				if ($sign_up_sale_cost) {
					$price .= '<del style="color: rgb(255, 0, 0);">$'.$sign_up_sale_cost.'</del>';
				}
				$price .= preg_replace(
						$pattern2,
						$replacement2,
						$removefree);
				$price .= '<span class="price">one off payment!</span>';
		} elseif (strpos($price_string, 'One Upfront Payment') !== false) {

				$sign_up_cost   = $product->get_meta( '_subscription_sign_up_fee' );
				$balance        = $product->get_meta( '_min_variation_regular_price' );
				$length         = $product->get_meta( '_subscription_length' );
				$sale_recurr    = 		$product->get_meta( '_min_variation_sale_price' );

				if ($sale_recurr !== '0') {
					$total_sale   = $sign_up_cost + $sale_recurr;
					$totes        = $sign_up_cost + $balance;
					$total        = '<del>$' . $totes . '</del> <span style="color: rgb(255, 0, 0);">$' . $total_sale . '</span>';
					$subscription =  '<del>$'. $balance . '</del> <span style="color: rgb(255, 0, 0);">$' . $sale_recurr . '</span>';
				} else {
					$totes = $sign_up_cost + $balance;
					$total = '$' . $totes;
					$subscription =  '$'. $balance;
				}

				if (strpos($price_string, '/ month for') !== false) {
						$price = '<span class="price" itemprop="price">' . $price_string . '</span>';
				} elseif($length == '1') {
						$price = '<span class="price"><span itemprop="price">$'.$sign_up_cost.'</span> upfront payment & '. $subscription .' after '.$length.' month. (Total: '.$total.')</span>';
				} else {
						$price = '<span class="price"><span itemprop="price">$'.$sign_up_cost.'</span> upfront payment & '. $subscription .' after '.$length.' months. (Total: '.$total.')</span>';
				}

		} elseif (strpos($price_string, 'months and a') !== false) {

			$sign_up_cost   = $product->get_meta( '_subscription_sign_up_fee' );
			$balance        = $product->get_meta( '_min_variation_regular_price' );
			$length         = $product->get_meta( '_subscription_length' );
			$sale_recurr    = 		$product->get_meta( '_min_variation_sale_price' );

				if ($sale_recurr !== '0') {

					$total_sale   = $sign_up_cost + $sale_recurr;
					$totes        = $sign_up_cost + $balance;
					$total        = '<del>$' . $totes . '</del> <span style="color: rgb(255, 0, 0);">$' . $total_sale . '</span>';

					$subscription =  '<del>$'. $balance . '</del> <span style="color: rgb(255, 0, 0);">$' . $sale_recurr  . '</span>';

				} else {
					$totes = $sign_up_cost  + $balance ;
					$total = '$' . $totes;

					$subscription =  '$'. $balance ;

				}

				// $trial = strstr($price_string, 'with', true);

				if (strpos($price_string, '/ month for') !== false) {
						$price = $price_string;
				} else {
						$price = '<span class="price"><span itemprop="price">$'.$sign_up_cost .'</span> upfront payment & '. $subscription .' after '.$length .' months. (Total: '.$total.')</span>';
				}

		} else {

				$price_string = str_replace('&#36;0.00   and a', '', strip_tags($price_string));

				$price = $price_string;

				if(is_single('55382')) {


						if($item["attributes"]["attribute_co-contribution-fee"] !=='') {

								$price .= ' - <span class="price">'.$item["attributes"]["attribute_co-contribution-fee"].'</span>';
						}

				}

		}

	$ctr++;
	return $price;
}

//add_filter( 'woocommerce_cart_item_price', 'marky_cart_item_price', 10, 3 );
function marky_cart_item_price( $price, $cart_item, $cart_item_key ) {
	$priceString = ma_customised_price_string($price);
	return $priceString;
}

//add_filter( 'woocommerce_cart_item_subtotal', 'marky_cart_item_subtotal', 10, 3 );
function marky_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
	$priceString = ma_customised_price_string($subtotal);
	return $priceString;
}




// Edit Subscription Price String
//add_filter('woocommerce_subscriptions_product_price_string', 'my_subs_price_string');
function my_subs_price_string($pricestring){
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


