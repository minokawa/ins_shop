<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author WooThemes
 * @package WooCommerce/Templates/Emails/HTML
 * @version 2.5.0
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }

?>

<?php
/**
  * @hooked WC_Emails::email_header() Output the email header
  */
 do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p><?php printf( __( 'You have received an order from %s. The order is as follows:', 'woocommerce' ), $order->get_formatted_billing_full_name() ); ?></p>


<?php do_action( 'woocommerce_email_before_order_table', $order, true, false ); ?>

<h2 style="color:#46809d;"><?php printf( __( 'Order: %s', 'woocommerce'), $order->get_order_number() ); ?> (<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( woocommerce_date_format(), strtotime( $order->order_date ) ) ); ?>)</h2>

<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
	<thead>
		<tr>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $order->email_order_items_table( false, true ); ?>
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

		<?php


			if ( $totals = $order->get_order_item_totals() ) {
				$i = 0;

				foreach ( $totals as $total ) {
					$i++;
					if ($total['label'] == 'Cart Subtotal:') {
						// Do not show sub-total
					} elseif ($total['label'] == 'Order Discount:') {

						?><tr>
							<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
							<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>">
								<?php

								$custom_discount_sub_a = $total['value'];
								$custom_discount_sub_b = strip_tags($custom_discount_sub_a);
								$custom_discount_sub_total = str_replace('up front then &#36;0 / month discount', '', $custom_discount_sub_b);

								// $custom_discount_sub = str_replace('now then <span class="amount">$0</span> / month', '', $custom_discount_sub_b);
							?>

								-<?php echo $custom_discount_sub_total;

								?>
							</td>
						</tr><?php
						// var_dump($test);
						if($coupon_codes) {
							echo $coupon_codes;
						}

					} else {
						?><tr>
							<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>"><?php echo $total['label']; ?></th>
							<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 ) echo 'border-top-width: 4px;'; ?>">

								<?php

								$mystring = $total['value'];
								$findme   = 'for 1 month';
								$pos = strpos($mystring, $findme);

								// Note our use of ===.  Simply == would not work as expected
								// because the position of 'a' was the 0th (first) character.
								if ($pos === false) {
									// Subscriptions
								    $custom_cart_sub_a = $total['value'];
									$custom_cart_sub_b = (string)$custom_cart_sub_a;
									$custom_cart_sub = str_ireplace('after 1 month free trial', '', $custom_cart_sub_b);
									echo $custom_cart_sub;

								} else {
									// One off payment
									$order_total_total = str_replace($findme, '', $mystring);
									echo $order_total_total;
								}

								?>
							</td>
						</tr><?php
					}
				}
			}

			if( $order->get_used_coupons() ) {
			    // Coupon code
			    foreach( $order->get_used_coupons() as $coupon) { ?>

			    	<?php echo '<tr>
						<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee;">Coupon Used:</th>
						<td style="text-align:left; border: 1px solid #eee; ">'.
								$coupon
						.'</td>
					</tr>';

			    }
			}
		?>

	</tfoot>
</table>

<?php do_action('woocommerce_email_after_order_table', $order, true); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, true ); ?>

<h2 style="color:#46809d;"><?php _e( 'Customer Details', 'woocommerce' ); ?></h2>

<?php if ( $order->billing_email ) : ?>
	<p><strong><?php _e( 'Email:', 'woocommerce' ); ?></strong> <?php echo $order->billing_email; ?></p>
<?php endif; ?>
<?php if ( $order->billing_phone ) : ?>
	<p><strong><?php _e( 'Tel:', 'woocommerce' ); ?></strong> <?php echo $order->billing_phone; ?></p>
<?php endif; ?>

<?php // Start Student information

	$order_id = $order->id;
	$order = new WC_Order( $order_id );
	$items = $order->get_items();

	// Additional Info

	// First Name
    $first_name = get_post_meta( $order_id, '_billing_first_name', true );

    // Middle Name
    $middle_name = get_post_meta( $order_id, 'middle-name', true );

    // Last Name
    $last_name = get_post_meta( $order_id, '_billing_last_name', true );

    // Postal Address - street
    $address_street1 = get_post_meta( $order_id, '_billing_address_1', true );
    // Postal Address - suburb
    $address_suburb = get_post_meta( $order_id, '_billing_city', true );
    // Postal Address - post code
    $address_postcode = get_post_meta( $order_id, '_billing_postcode', true );
    // Postal Address - State
    $address_state = get_post_meta( $order_id, '_billing_state', true );

	// Country of birth
    $country_birth = get_post_meta( $order_id, 'country-of-birth', true );

	// Date of birth
    $date_birth = get_post_meta( $order_id, 'date-of-birth', true );

    // Gender
    $gender = get_post_meta( $order_id, 'gender', true );

    // Residency
    $residency = get_post_meta( $order_id, 'residency', true );

    // home phone
    $home_phone = get_post_meta( $order_id, 'home-phone', true );
    // work phone
    $work_phone = get_post_meta( $order_id, 'work-phone', true );
    // mobile phone
    $mobile_phone = get_post_meta( $order_id, 'mobile-phone', true );
    // work mobile phone
    $work_mobile_phone = get_post_meta( $order_id, 'work-mobile-phone', true );

    // Can you read, write and understand English
    $understand_english = get_post_meta( $order_id, 'understand-english', true );

    // Indigenous status
    $indigenous = get_post_meta( $order_id, 'indigenous', true );

    // Main language
    $main_language = get_post_meta( $order_id, 'main-language', true );

    // Do you have access to a computer with internet
    $internet_access = get_post_meta( $order_id, 'internet-access', true );

    // Agree to online corrispondence
    $online_agree = get_post_meta( $order_id, 'online-corrispondence-agree', true );

    // How do you rate your computer skills
    $computer_ability = get_post_meta( $order_id, 'computer-ability', true );

    // How do you rate your ability to work with numbers
    $number_ability = get_post_meta( $order_id, 'number-ability', true );

    // disability?
    $disability_toggle = get_post_meta( $order_id, 'disability-toggle', true );

    // disability type
    $disability = get_post_meta( $order_id, 'disability', true );

    // Do you need any additional support?
    $additional_support = get_post_meta( $order_id, 'additional-support', true );
    // Additional support, if yes, please specify
    $additional_support_specify = get_post_meta( $order_id, 'additional-support-specify', true );

    // Start Date - ASAP
    $course_start_date_asap = get_post_meta( $order_id, 'distance-start-asap', true );

    // Start Date - Blended
    $course_start_date_blended = get_post_meta( $order_id, 'start-date', true );

    // Start Date
    $course_start_date = get_post_meta( $order_id, 'course-start-date-1', true );

    // Second Week Start Date
    $course_start_date_two = get_post_meta( $order_id, 'course-start-date-2', true );

    // Distance Start Date
    $course_distance_start = get_post_meta( $order_id, 'distance-start', true );


    // Location Week 1
    $location_week_1 = get_post_meta( $order_id, 'delivery-location', true );

    // Location week 2
    $location_week_2 = get_post_meta( $order_id, 'delivery-location-2', true );


    $course_location_1 = get_post_meta( $order_id, 'course-location-1', true );
    $course_location_2 = get_post_meta( $order_id, 'course-location-2', true );
    $course_location_3 = get_post_meta( $order_id, 'course-location-3', true );

    $course_time_1 = get_post_meta( $order_id, 'course-date-1', true );
    $course_time_2 = get_post_meta( $order_id, 'course-date-2', true );
    $course_time_3 = get_post_meta( $order_id, 'course-date-3', true );

    // Still at school?
    $school = get_post_meta( $order_id, 'studied-last', true );

    // Where did you last undertake formal learning
    $school_name = get_post_meta( $order_id, 'school-name', true );

    // Study level
    $school_level = get_post_meta( $order_id, 'studied-level', true );

    // Prior education flag (yes/no)
    $prior_edu = get_post_meta( $order_id, 'prior-education-flag', true );

    // Prior education options
    $prior_edu_cert = get_post_meta( $order_id, 'last-formal-learning', true );

    // Reason for undertaking course
    $study_reason = get_post_meta( $order_id, 'reason-undertake', true );

    // Yearly Income
	$yearly_income = get_post_meta( $order_id, 'yearly-income', true );

	// Employed Industry
	$employed_industry = get_post_meta( $order_id, 'employed-industry', true );

    // Delivery Type - Full, Blended, Distance
    $delivery_type = get_post_meta( $order_id, 'delivery-type', true );

    // Enrolment Type - RPL
    $enrolment_type = get_post_meta( $order_id, 'learning-type', true );

    // Employment status
    $employ_status = get_post_meta( $order_id, 'employment-status', true );

    // ABN
    $abn = get_post_meta( $order_id, 'ABN', true );

    // Agree to terms?
    $agree_terms = get_post_meta( $order_id, 'agree-terms', true );

    // Get referrer
    $referrer = get_post_meta( $order_id, 'referrer-id', true );


    // Payment method
    if ( $order ) :
      $payment_method = $order->get_payment_method_title();
    endif;
    $course_payment = $payment_method;

    if ( $first_name ) :
		echo '<p><strong>First Name</strong> ' . $first_name . '</p>';
	endif;
	if ( $middle_name ) :
		echo '<p><strong>Middle Name</strong> ' . $middle_name . '</p>';
	endif;
	if ( $last_name ) :
		echo '<p><strong>Last Name</strong> ' . $last_name . '</p>';
	endif;

	if ( $product_name ) :
		echo '<p><strong>Product Name</strong> ' . $product_name . '</p>';
	endif;

    if ( $address_street1 ) :
		echo '<p><strong>Street Address</strong> ' . $address_street1 . '</p>';
	endif;
	if ( $address_suburb ) :
		echo '<p><strong>Suburb</strong> ' . $address_suburb . '</p>';
	endif;
	if ( $address_postcode ) :
		echo '<p><strong>Postcode</strong> ' . $address_postcode . '</p>';
	endif;
	if ( $address_state ) :
		echo '<p><strong>State</strong> ' . $address_state . '</p>';
	endif;

	if ( $country_birth ) :
		echo '<p><strong>Country of birth</strong> ' . $country_birth . '</p>';
	endif;
	if ( $date_birth ) :
		echo '<p><strong>Date of birth</strong> ' . $date_birth . '</p>';
	endif;
	if ( $gender ) :
		echo '<p><strong>Gender</strong> ' . $gender . '</p>';
	endif;

	echo '<h3>Additional Customer Information</h3>';
	if ( $understand_english ) :
		echo '<p><strong>Can they understand English?</strong> ' . $understand_english . '</p>';
	endif;
	if ( $home_phone ) :
		echo '<p><strong>Home phone number:</strong> ' . $home_phone . '</p>';
	endif;
	if ( $work_phone ) :
		echo '<p><strong>Work phone number:</strong> ' . $work_phone . '</p>';
	endif;
	if ( $mobile_phone ) :
		echo '<p><strong>Mobile phone number:</strong> ' . $mobile_phone . '</p>';
	endif;
	if ( $work_mobile_phone ) :
		echo '<p><strong>Mobile Work phone number:</strong> ' . $work_mobile_phone . '</p>';
	endif;

	if ( $indigenous ) :
		echo '<p><strong>Indigenous status</strong> ' . $indigenous . '</p>';
	endif;
	if ( $main_language ) :
		echo '<p><strong>Main language</strong> ' . $main_language . '</p>';
	endif;
	if ( $residency ) :
		echo '<p><strong>Australian resident?</strong> ' . $residency . '</p>';
	endif;
	if ( $internet_access ) :
		echo '<p><strong>Do they have internet access?</strong> ' . $internet_access . '</p>';
	endif;
	if ( $online_agree ) :
		echo '<p><strong>Do they agree to online corrispondence?</strong> ' . $online_agree . '</p>';
	endif;
	if ( $computer_ability ) :
		echo '<p><strong>Computer ability</strong> ' . $computer_ability . '</p>';
	endif;
	if ( $number_ability ) :
		echo '<p><strong>Number ability</strong> ' . $number_ability . '</p>';
	endif;
	if ( $disability_toggle ) :
		echo '<p><strong>Do they have a disability?</strong> ' . $disability_toggle . '</p>';
	endif;
	if ( $disability ) :
		echo '<p><strong>Disability Type</strong> ' . $disability . '</p>';
	endif;
	if ( $additional_support ) :
		echo '<p><strong>Do they need aditional support?</strong> ' . $additional_support . '</p>';
	endif;
	if ( $additional_support_specify ) :
		echo '<p><strong>Aditional type</strong> ' . $additional_support_specify . '</p>';
	endif;
	if ( $school ) :
		echo '<p><strong>Still at school?</strong> ' . $school . '</p>';
	endif;
	if ( $school_name ) :
		echo '<p><strong>School name</strong> ' . $school_name . '</p>';
	endif;
	if ( $school_level ) :
		echo '<p><strong>Study level</strong> ' . $school_level . '</p>';
	endif;
	if ( $prior_edu ) :
		echo '<p><strong>Do they have prior education?</strong> ' . $prior_edu . '</p>';
	endif;
	if ( $prior_edu_cert ) :
		echo '<p><strong>Prior education</strong> ' . $prior_edu_cert . '</p>';
	endif;
	if ( $study_reason ) :
		echo '<p><strong>Reason for undertaking course</strong> ' . $study_reason . '</p>';
	endif;
	if ( $yearly_income ) :
		echo '<p><strong>Students yearly income</strong> ' . $yearly_income . '</p>';
	endif;
	if ( $employed_industry ) :
		echo '<p><strong>Students employment industry</strong> ' . $employed_industry . '</p>';
	endif;
	if ( $employ_status ) :
		echo '<p><strong>Employment status</strong> ' . $employ_status . '</p>';
	endif;
	if ( $abn ) :
		echo '<p><strong>ABN</strong> ' . $abn . '</p>';
	endif;
	if ( $referrer ) :
		echo '<p><strong>Referrer ID</strong> ' . $referrer . '</p>';
	endif;

	echo '<h3>Course Information</h3>';
	// global $woocommerce;
	// var_dump($woocommerce);
	// foreach ($items as $item) :
	// 	$_product = $order->get_product_from_item( $item );
	// 	var_dump($item);

	// global $post;
	// $terms = get_the_terms( $order_id, 'product_cat' );
	// foreach ($terms as $term) {
	//     $product_cat_id = $term->term_id;
	//     break;
	// }

	foreach ( $items as $item ) {
	    $product_name = $item['name'];

		echo '<p><strong>Course Name</strong> ' . $product_name . '</p>';
	}

	// endforeach;

	if ( $course_payment ) :
		echo '<p><strong>Payment method</strong> ' . $course_payment . '</p>';
	endif;

	if ( $delivery_type ) :
		echo '<p><strong>Delivery type</strong> ' . $delivery_type . '</p>';
	endif;

	if ( $course_start_date_asap ) :
		echo '<p><strong>Start Date ASAP?</strong> ' . $course_start_date_asap . '</p>';
	endif;

	if ( $course_start_date_blended ) :
		echo '<p><strong>Start Date</strong> ' . $course_start_date_blended . '</p>';
	endif;
	if ( $course_start_date ) :
		echo '<p><strong>1st week start date</strong> ' . $course_start_date . '</p>';
	endif;
	// if ( $location_week_1 ) :
	// 	echo '<p><strong>Location week 1</strong> ' . $location_week_1 . '</p>';
	// endif;
	if ( $course_start_date_two ) :
		echo '<p><strong>2nd week start date</strong> ' . $course_start_date_two . '</p>';
	endif;
	// if ( $location_week_2 ) :
	// 	echo '<p><strong>Location week 2</strong> ' . $location_week_2 . '</p>';
	// endif;
	if ( $course_distance_start ) :
		echo '<p><strong>Distance start date</strong> ' . $course_distance_start . '</p>';
	endif;

	if ( $course_location_1 ) :
		echo '<p><strong>Course Location 1</strong> ' . $course_location_1 . '</p>';
	endif;
	if ( $course_time_1 ) :
		echo '<p><strong>Course time 1</strong> ' . $course_time_1 . '</p>';
	endif;

	if ( $course_location_2 ) :
		echo '<p><strong>Course Location 2</strong> ' . $course_location_2 . '</p>';
	endif;
	if ( $course_time_2 ) :
		echo '<p><strong>Course time 2</strong> ' . $course_time_2 . '</p>';
	endif;

	if ( $course_location_3 ) :
		echo '<p><strong>Course Location 3</strong> ' . $course_location_3 . '</p>';
	endif;
	if ( $course_time_3 ) :
		echo '<p><strong>Course time 3</strong> ' . $course_time_3 . '</p>';
	endif;


	if ( $enrolment_type ) :
		echo '<p><strong>RPL</strong> ' . $enrolment_type . '</p>';
	endif;

	if ( $agree_terms ) :
		echo '<h3>Customer Declaration</h3>';
		echo '<p><strong>Does the customer agree to the below terms?</strong> ' . $agree_terms . '</p>';
		print get_the_content_by_id(9172);
	endif;


 ?>



<?php wc_get_template( 'emails/email-addresses.php', array( 'order' => $order ) ); ?>

<?php do_action( 'woocommerce_email_footer' ); ?>
