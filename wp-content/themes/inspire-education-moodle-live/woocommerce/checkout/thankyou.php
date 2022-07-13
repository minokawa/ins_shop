<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

			<p><?php
				if ( is_user_logged_in() )
					_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
				else
					_e( 'Please attempt your purchase again.', 'woocommerce' );
			?></p>

			<p>
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
				<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

	<?php else : ?>

		<ul class="order_details">
			<li class="order">
				<?php _e( 'Order Number:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'woocommerce' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->get_date_created() ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'woocommerce' ); ?>
				<?php
			      $custom_cart_sub = $order->get_total();
			      $original[0] = 'now then <span class="amount">&#36;0</span> for 1 month';
			      $original[1] = 'after 1 month free trial';
			      $replace[0] = ' one off payment!';
			      $replace[1] = '';
			      $custom_cart_sub = str_ireplace($original, $replace, $custom_cart_sub);
			  ?>
				<strong>$<?php echo $order->get_total(); ?></strong>
			</li>
			<?php if ( $order->get_payment_method_title() ) : ?>
			<li class="method">
				<?php _e( 'Payment method:', 'woocommerce' ); ?>
				<strong><?php echo $order->get_payment_method_title(); ?></strong>
				<?php // Payment method

				    $payment_method = $order->get_payment_method_title();

				    if ($payment_method == 'Bank Account Transfer (Manual Verification Required)') { ?></p>

					<p style="font-size:16px;"><b>IMPORTANT!</b>  Your <u>Enrolment is on Hold until Payment has Been Received</u>..  Please make payment immediately (details on the form):

					<p style="line-height:140%;font-size:16px;">
					use your <u><b>order number (<?php echo $order->get_order_number(); ?>)</b></u> in the Bank Transfer payment description, and your <b>Full Name (or Company Name)</b> as Reference.

				    <?php

				    // $order->update_status( 'processing' );

					}

					if ($payment_method == 'Offline Credit Card Payment') { ?>
						<strong>Please download and complete our <a href="http://www.inspireeducation.net.au/documents/credit_card.pdf" title="direct debit form" target="_blank">Credit Card Payment Form</a> before returning it to the outlined address.</strong>
				    <?php

				    // $order->update_status( 'processing' );

					}
					if ($payment_method == 'Direct Debit') { ?>
					<p style="font-size:16px;"><b>IMPORTANT!</b>  Your <u>Enrolment is on Hold until Payment has Been Received</u>.  Please make payment immediately (details on the form):
					<p style="line-height:140%;font-size:16px;">Complete our <b><u><a href="https://au1.documents.adobe.com/public/esignWidget?wid=CBFCIBAA3AAABLblqZhDHdBcOsRWaFrU2geNNnNcPU2EB42tAobVUTAM7mgA0cSm5nHS5hXJBbk1RMlkWFD8*" title="direct debit form" target="_blank">Direct Debit Form</a></b></u> Now to avoid delays.
				    <?php

				    // $order->update_status( 'processing' );

					}

					if ($payment_method == 'Credit card' || $payment_method == 'PayPal') {

				    	$order->update_status( 'completed' );

				    	// mail('onlineenrolments@inspireeducation.net.au', 'PayPal Order Info', print_r($order->get_order_number(), true));

					} ?>

					<?php
					if ($payment_method == 'Payment on Invoice') { ?>

							<br>Account Name <strong>Inspire Education Pty Ltd</strong><br>
							BSB <strong>124-001</strong><br>
							Account Number <strong>20844110</strong><br>
							Bank Name <strong>Bank of Queensland</strong><br>
							Payment Ref <strong><?php  echo $order->get_order_number(); ?></strong>


					<?php } ?>
			</li>
			<?php endif; ?>
			<li>
			<div id="order-details">
			<?php  do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
			</div>
		</ul>

		<p style="font-size:2em; font-weight:700; color:#4680b6; margin-bottom:8px;">Your enrolment has been received.</p>

		<p style="font-size:22px; font-weight:500; color:#4680b6; margin-bottom:8px;">Congratulations on taking the first step, and "sparking" your learning journey!</p><br>

		<p style="font-size:18px;">
				<strong>IMPORTANT:</strong> - Your enrolment cannot be processed until we confirm payment has been made.  To avoid losing any discount or special pricing, you <strong>must pay immediately.</strong>
		<p>


		<p>  Once paid, you will receive your course logins within 5 business days (usually less).  A confirmation email from Inspire Education <<a href="mailto:onlineenrolments@inspireeducation.net.au">onlineenrolments@inspireeducation.net.au</a>> has been sent to the email address below.</p>

		<p>If you have not received an email within 10 to 15 minutes, please check your spam/junk folder.</p>
		<?php
			$items = $order->get_items();
			$custom_messsage_skus = ['INS02584','INS02586','INS02582'];
			foreach ( $order->get_items() as $item_id => $item ) {
				$sku = $item->get_product()->get_sku();
				if (in_array($sku, $custom_messsage_skus)) {
					echo "<p><b>Scheduling instruction: </b>To book and confirm your preferred date, please email onlineenrolments@inspireeducation.net.au, or call 1800 506 509, after successfully enrolling in your first aid course. Enrolments over weekends and holidays will be attended to on the following business day.</p>";
					break;
				}
			}
		?>
		<p><b>*** NOTE:  If you have already paid through PayPal or credit card, no further action is required ***</b> </p>

		<p style="font-size:22px; font-weight:500; color:#4680b6; margin-bottom:8px;">We can't wait to help you "Find Your Spark!"</p>

		<div class="clear"></div>

		<script>Cookies.set('modal', null, { path: '/' });</script>

	<?php endif; ?>

	<div id="order-details">
		<?php	if ( $payment_method !== 'Invoice Payment') { do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() );} ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
	</div>
<br>

<?php else : ?>

	<p><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ); ?></p>

<?php endif; ?>
