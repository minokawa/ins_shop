<?php
/**
 * Customer completed order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-completed-order.php.
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

<?php
	$items = $order->get_items();

	foreach ( $items as $item ) {
	    $product_id = $item['product_id'];

	    $terms = get_the_terms( $product_id, 'product_cat' );
	    foreach ($terms as $term) {
	        $product_cat_id = $term->term_id;
	        break;
	    }
	}
?>

<p>
	<?php

	if (in_array($product_cat_id, array('462', '463', '466', '502') )) {

		printf( __( "Hi there. Your recent order with Inspire Education has been completed. Your order details are shown below for your reference.", 'woocommerce' ), get_option( 'blogname' ) );

	} else {

		printf( __( "Hi there. Your recent order with Inspire Education has been completed. You will receive a Welcome Email with your course details in 5-10 business days. Please note that your course will only begin once your order is finalised. Your order details are shown below for your reference.", 'woocommerce' ), get_option( 'blogname' ) );

	} ?>

</p>
<p>Please print or download this order / invoice.</p>

<?php

	do_action('woocommerce_email_before_order_table', $order, false);

?>

<h2  style="color:#46809d;"><?php echo __( 'Tax Invoice/Payment Receipt:', 'woocommerce' ) . ' ' . $order->get_order_number(); ?> </h2>
<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( woocommerce_date_format(), strtotime( $order->order_date ) ) ); ?>
<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Products', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( true, false, true ); ?>
	</tbody>
	<tfoot>

		<tr>
			<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				GST
			</th>
			<td style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				$0
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				Total
			</th>
			<td style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				$<?php echo $order->get_total(); ?>
			</td>
		</tr>

		<tr>
			<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				Payment Method
			</th>
			<td style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				<?php echo $order->get_payment_method_title(); ?>
			</td>
		</tr>

		<!--<tr>
			<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				Balance Due
			</th>
			<td style="text-align:left; border: 1px solid #eee; <?php echo 'border-top-width: 4px;'; ?>">
				$0
			</td>
		</tr>-->
	</tfoot>
</table>

<?php // do_action('woocommerce_email_after_order_table', $order, false); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, false ); ?>

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

<?php

	// Get Order Paid date
    $order_id = $order->id;
	$paid_date = get_post_meta( $order_id, 'date_payment_was_recieved', true );

    if ( $paid_date ) :

    	$date_1 = date('d/m/Y', strtotime($paid_date));
    	echo '<h2  style="color:#46809d;">Payment Date: '. $date_1 .'</h2>';

   	endif;


 ?>

<p>This tax invoice is for payments that have been already made in full to Inspire Education. There may be outstanding balances in relation to this student account.</p>

<h2  style="color:#46809d;"><?php _e( 'Customer Details', 'woocommerce' ); ?></h2>

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
