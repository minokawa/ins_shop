<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $woocommerce;
$result = get_product_cats();
$is_renewal = ma_is_subscription_renewal();
wc_print_notices();

//The for Steps buttons are hoohked into woocommerce_before_checkout_form
do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}

$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url() );
?>
	<form name="checkout" method="post" data-destroy="false" id="checkout" class="tab-content checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
		<input type="hidden" name="referral" id="referral-id" value="" />
		<input type="hidden" id="course_location_1" name="course_location_1" value="" />
		<input type="hidden" id="course_location_2" name="course_location_2" value="" />
		<input type="hidden" id="course_location_3" name="course_location_3" value="" />
		<input type="hidden" id="course_date_1" name="course_date_1" value="" />
		<input type="hidden" id="course_date_2" name="course_date_2" value="" />
		<input type="hidden" id="course_date_3" name="course_date_3" value="" />
		<?php

        if ( sizeof( $checkout->checkout_fields ) > 0 ) {

          //Step 2 + variants is hooked to  woocommerce_checkout_billing
          do_action( 'woocommerce_checkout_billing' );
          include('checkout_steps/step3_additionalinfo.php');
          include('checkout_steps/step4_terms.php');
          include('checkout_steps/step5_checkout_review.php');
        }
      ?>
	</form>
</div>


