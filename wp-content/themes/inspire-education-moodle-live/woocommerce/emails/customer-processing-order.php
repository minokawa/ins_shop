<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates/Emails
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php _e( "Your order has been received and is now being processed. Your order details are shown below for your reference:", 'woocommerce' ); ?></p>
<p>Please print or download this order / invoice.</p>

<?php
$payment_method = $order->get_payment_method_title();
if ($payment_method == 'Direct Debit') { ?>
	<strong>Please download and complete our <a href="http://inspireeducation.net.au/documents/direct-debit-request-v1.4.pdf" title="direct debit form" target="_blank">Direct Debit Form</a> before returning it to the outlined address.</strong>
<?php } ?>

<?php
if ($payment_method == 'Invoice Payment' || $payment_method == 'Electronic Funds Transfer (EFT) - Direct Bank Transfer') { ?>
	<h3>Our Account Details</h3>
	<p><strong>Account Name</strong> Inspire Education Pty Ltd<br>
		<strong>BSB</strong> 124-001<br>
		<strong>Account Number</strong> 20844110<br>
		<strong>Bank Name</strong> Bank of Queensland<br>
		<strong>Payment Ref#</strong> <?php  echo $order->get_order_number(); ?>
	</p>

<?php } ?>

<?php // do_action('woocommerce_email_before_order_table', $order, false); ?>

<h2 style="color:#46809d;"><?php echo __( 'Tax Invoice:', 'woocommerce' ) . ' ' . $order->get_order_number(); ?> (<?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?>)</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( $order->is_download_permitted(), true, ($order->status=='processing') ? true : false ); ?>
	</tbody>
	<tfoot>

		<?php
			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;
				$ctr = 0;
				foreach ( $totals as $total ) {
					$i++;

					$price_string = $total["value"];

				    if (strpos($price_string, 'after 1 month free trial') !== false) {

				        $replacement[0] = '';

				        $price{$ctr} = strstr($price_string, 'after', true);


				    } elseif (strpos($price_string, 'for 1 month') !== false) {

				        $replacement[0] = '';

				        $price{$ctr} = strstr($price_string, 'for', true);


				    } elseif (strpos($price_string, '0.00') !== false) {

				        $replacement[0] = '';

				        $price{$ctr} = strstr($price_string, 'up', true);

				    } else {

				        $price{$ctr} = $total["value"];

				    }


				    if ($total['label'] == 'Cart Subtotal:') {
						// Do not show sub-total
						// var_dump($total);
					} else {

						?><tr>
							<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
							<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $price{$ctr}; ?></td>
						</tr><?php
					}


					$ctr++;
				}
			}
		?>
	</tfoot>
</table>

<?php // do_action('woocommerce_email_after_order_table', $order, false); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, false ); ?>

<h2 style="color:#46809d;"><?php _e( 'Customer Details', 'woocommerce' ); ?></h2>

<?php if ($order->billing_first_name) : ?>
	<p><strong><?php _e( 'Name:', 'woocommerce' ); ?></strong> <?php echo $order->billing_first_name; ?> <?php echo $order->billing_last_name; ?></p>
<?php endif; ?>

<?php if ($order->billing_email) : ?>
	<p><strong><?php _e( 'Email:', 'woocommerce' ); ?></strong> <?php echo $order->billing_email; ?></p>
<?php endif; ?>
<?php if ($order->billing_phone) : ?>
	<p><strong><?php _e( 'Tel:', 'woocommerce' ); ?></strong> <?php echo $order->billing_phone; ?></p>
<?php endif; ?>

<?php wc_get_template('emails/email-addresses.php', array( 'order' => $order )); ?>

<?php do_action('woocommerce_email_footer'); ?>
