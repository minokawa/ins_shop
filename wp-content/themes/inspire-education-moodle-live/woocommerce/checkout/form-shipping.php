<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $woocommerce;

// Id's of the products in the cart
$prod_ids = array();
// Categories of the products in the cart
$cats_cart = array();

$is_renewal = ma_is_subscription_renewal();

// Find the id('s) of the product(s) in the cart
foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
  $_product = $values['data'];
  // $product_id is the id of the product in the cart
  $product_id = $_product->get_id();
  $prod_ids[] = $product_id;

  $terms = get_the_terms( $product_id, 'product_cat' );

  foreach ($terms as $term) {

    $product_cat_id = $term->term_id;

    $cats_cart[] = $product_cat_id;

  }
}

$comma_separated = implode(",", $cats_cart);
$array1 = $cats_cart;
$array2 = array("b" => '462', '463', '466', '502');
$result = array_diff($array1, $array2);

?>

<?php  if ( WC()->cart->needs_shipping_address() === true ) : ?>

	<?php
		if ( empty( $_POST ) ) {

			$ship_to_different_address = get_option( 'woocommerce_ship_to_destination' ) === 'shipping' ? 1 : 0;
			$ship_to_different_address = apply_filters( 'woocommerce_ship_to_different_address_checked', $ship_to_different_address );

		} else {

			$ship_to_different_address = $checkout->get_value( 'ship_to_different_address' );

		}
	?>
	<div class="checkbox">
		<?php

		// If the category is Alptop or Software do noting...
		// if (in_array($product_cat_id, array('462', '463', '466') )) {
		if (empty($result) ||$is_renewal) {

			?>

			<h5 class="no-margin">Do you need to ship to a different address?</h5>
			<p class="form-row full" id="shiptobilling">
				<input id="shiptobilling-checkbox" class="input-checkbox" <?php checked($shiptobilling, 1); ?> type="checkbox" name="shiptobilling" value="1" />
				<label for="shiptobilling-checkbox" class="checkbox"><?php _e( 'If yes, please uncheck to enter shipping information.', 'woocommerce' ); ?></label>
			</p>

		<?php // If is any other product and enrolment needs to take place...
		} else {

		?>
			<h5 class="no-margin">Do you require a company invoice?</h5>
			<p class="form-row full" id="shiptobilling">
				<input id="shiptobilling-checkbox" class="input-checkbox" <?php checked($shiptobilling, 1); ?> type="checkbox" name="shiptobilling" value="1" />
				<label for="shiptobilling-checkbox" class="checkbox"><?php _e( 'If yes, please uncheck this box to enter company details.', 'woocommerce' ); ?></label>
			</p>

		<?php } ?>

	</div>

	<div class="shipping_address shipping-address-group">

		<?php

		// If the category is Alptop or Software do noting...
		if (in_array($product_cat_id, array('462', '463', '466', '502') )) { ?>

			<h3 class="no-margin">Shipping Details</h3>
			<h5 class="no-margin form-title"><?php _e( 'Please the address to ship the product to below.', 'woocommerce' ); ?></h5>

		<?php // If is any other product and enrolment needs to take place...
		} else {

		?>
			<h3 class="no-margin">Company Details</h3>
			<h5 class="no-margin form-title"><?php _e( 'Please enter company information below.', 'woocommerce' ); ?> <span><strong>Only do so if you require a company invoice</strong></span></h5>

		<?php } ?>

		<?php do_action('woocommerce_before_checkout_shipping_form', $checkout);

		$myshippingfields=array(
		    "shipping_first_name",
		    "shipping_last_name",
		    "shipping_address_1",
		    "shipping_city",
		    "shipping_state",
		    "shipping_postcode",
		    "shipping_country",
		    "shipping_email",
		    "shipping_phone",
		    "shipping_company",
		    "shipping_abn"
		);

		foreach ($myshippingfields as $key) : ?>

			<?php woocommerce_form_field( $key, $checkout->checkout_fields['shipping'][$key], $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

	</div>

<?php endif; ?>

<?php do_action('woocommerce_before_order_notes', $checkout); ?>

<?php if ( apply_filters( 'woocommerce_enable_order_notes_field', get_option( 'woocommerce_enable_order_comments', 'yes' ) === 'yes' ) ) : ?>

		<?php if ( ! WC()->cart->needs_shipping() || WC()->cart->ship_to_billing_address_only() ) : ?>

			<h3><?php _e( 'Additional Information', 'woocommerce' ); ?></h3>

		<?php endif; ?>

		<?php foreach ( $checkout->checkout_fields['order'] as $key => $field ) : ?>

			<?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>

		<?php endforeach; ?>

	<?php endif; ?>


<?php do_action('woocommerce_after_order_notes', $checkout); ?>
