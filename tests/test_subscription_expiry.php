<?php
//https://gist.github.com/thenbrent/26ba2035745667301fbd3b4cc6d13fc1
//https://github.com/wp-premium/woocommerce-subscriptions/blob/master/includes/class-wc-subscriptions-manager.php

// $res = WC_Subscription::woocommerce_scheduled_subscription_payment(276538);
// var_dump($res);
$sub_id = 276538;
do_action( 'scheduled_subscription_payment',$sub_id);
WC_Subscriptions_Manager::prepare_renewal($sub_id );
$res = WC_Subscriptions_Payment_Gateways::gateway_scheduled_subscription_payment($sub_id );
var_dump($res);
// $order = wc_get_order(276542 );
// $order->payment_complete();
