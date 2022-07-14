<?php
//https://woocommerce.com/document/subscriptions/develop/functions/product-functions/

$variation = wc_get_product(276536);
var_dump(WC_Subscriptions_Product::get_interval($variation));
var_dump(WC_Subscriptions_Product::get_length($variation));
var_dump(WC_Subscriptions_Product::get_period($variation));

var_dump(WC_Subscriptions_Product::get_period($variation));
var_dump(WC_Subscriptions_Product::get_price($variation));
echo WC_Subscriptions_Product::get_price_string($variation) . "\n";
 $today = '';
echo WC_Subscriptions_Product::get_expiration_date( $variation,$today) . "\n";

//update_post_meta(276536, '_subscription_length', 90);


