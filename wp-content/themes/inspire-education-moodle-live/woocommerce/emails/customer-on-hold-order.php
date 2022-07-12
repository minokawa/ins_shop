<?php
/**
 * Customer on-hold order email
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



<?php /** _e( "Your order is on-hold until we confirm payment has been received. Your order details are shown below for your reference:", 'woocommerce' ); */ ?>


<!-- 
	Updated by Request from Marketing 
	Ticket: 25183
	Date: December 23, 2021
-->
<p>Congratulations on taking the first step to enrolling with Inspire! It is a smart, and well-considered career move - and once you've finished, your course could open up countless new job opportunities.</p>

<p><strong>IMPORTANT: URGENT ACTION REQUIRED</strong> - Note, your <u>enrolment is on-hold</u> until we confirm payment has been made.</p>

<p>You must pay no later than voucher expiry date (if applicable) to be eligible for your discount - and to get your course logins within 3 business days (of payment).</p>

<p>Failure to do you may void your eligibility, and delay your enrolment and login. Your order details are shown below for reference.</p>

<p>Please make payment immediately, to avoid delays and fee increases.</p>

<p>Please use your Order ID as the payment reference. Your enrolment is <u>not confirmed until the funds have cleared in our account</u>.</p>

<?php

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
