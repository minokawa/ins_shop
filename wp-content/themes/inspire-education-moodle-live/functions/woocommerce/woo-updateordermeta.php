<?php

// Shipping - Update the order meta
add_action('woocommerce_checkout_update_order_meta', 'add_shipping_order_meta');
function add_shipping_order_meta( $order_id ) {

	//META_NAME => FORM_FIELD_NAME =>
	$billing_info = array(
		'billing-property-name' => 'billing_pname',
		'billing-flat-number' => 'billing_platno' ,
		'billing-lot-number'	=> 'billing_lotno' ,
		'_billing_address_1' => array('billing_pname','billing_platno','billing_lotno','billing_sname'),
		'_billing_address_2' => 'billing_sname',
		'billing-country' => 'billing_country' ,
		'billing-state'	=> 'billing_state' ,
		'billing-city' => 'billing_city' ,
		'billing-postcode' => 'billing_postcode' ,
		'billing-email' => 'billing_email' ,
		'home-phone' => 'billing_home_phone' ,
		'work-phone' => 'billing_work_phone' ,
		'mobile-phone' => 'billing_mobile_phone' ,
		'work-mobile-phone' => 'billing_work_mobile' ,
		'cont_mobile_number' => 'billing_work_mobile' ,
		'country-of-birth' => 'ccf_country_birth' ,
		'date-of-birth' => 'ccf_date_birth' ,
		'gender' => 'ccf_gender' ,
		'residency' => 'ccf_ausres' ,
		'indigenous' => 'ccf_indig' ,
		'main-language' => 'ccf_main_lang' ,
		'understand-english' => 'ccf_read' ,
		'home-languag' => 'ccf_lang_home' ,
		'employment-status' => 'ccf_employ_stat' ,
		'studied-last' => 'ccf_school' ,
		'school-name' => 'ccf_school_title' ,
		'studied-level' => 'ccf_school_level' ,
		'school_higest_year' => 'ccf_school_higest_year' ,
		'ccf_usi_num' => 'ccf_usi_num'
	);

	$postal_address = array(
		'ccf_add_two_pname' => 'ccf_add_two_pname',
		'ccf_add_two_unumber' => 'ccf_add_two_unumber',
		'ccf_add_two_lnumber' => 'ccf_add_two_lnumber',
		'ccf_add_two_sname' => 'ccf_add_two_sname',
		'ccf_add_two_pdbox' => 'ccf_add_two_pdbox',
		'ccf_add_two_sub' => 'ccf_add_two_sub',
		'ccf_add_two_state' => 'ccf_add_two_state',
		'country-name' => 'ccf_add_two_country',
		'ccf_add_two_country' => 'ccf_add_two_country',
		'cont_fax' => 'cont_fax',
		'ccf_add_two_post' => 'ccf_add_two_post',
	);

	$company_address = array(
		'ccf_comp_name_1' => 'ccf_comp_name_1',
		'comp_name_1' => 'ccf_comp_name_1',
		'comp_name_2' => 'ccf_comp_name_2',
		'comp_add_1' => 'ccf_comp_add_1',
		'comp_add_sub' => 'ccf_comp_add_sub',
		'comp_add_state' => 'ccf_comp_add_state',
		'comp_add_post' => 'ccf_comp_add_post',
		'comp_cont_email' => 'ccf_comp_cont_email',
		'cont_email' => 'ccf_comp_cont_email',
		'comp_cont_phone'=>'ccf_comp_cont_phone',
		'cont_phone_number'=>'ccf_comp_cont_phone',
		'comp_name'=>'ccf_comp_name',
		'comp_abn'=>'ccf_comp_abn'
	);

	$additional_info = array(
		'prior-education-flag' => 'ccf_prior_edu' ,
		'prior-edu-type' => 'ccf_formal' ,
		'last-formal-learning' => 'ccf_formal' ,
		'comple_edu_year' => 'ccf_comple_edu_year' ,
		'internet-access' => 'ccf_internet_con' ,
		'online-corrispondence-agree' => 'ccf_online_cori' ,
		'ccf_comp_skills' => 'ccf_comp_skills' ,
		'computer-ability' => 'ccf_comp_skills' ,
		'number-ability' => 'ccf_num_ability' ,
		'disability-toggle' => 'ccf_disability_toggle' ,
		'disability' => 'ccf_disability' ,
		'additional-support' => 'ccf_support' ,
		'additional-support-specify' => 'ccf_support_specify' ,
		'learning-type' => 'ccf_learning_type' ,
		'reason-undertake' => 'ccf_reason_undertake' ,
		'yearly-income' => 'ccf_yearly_income' ,
		'employed-industry' => 'ccf_employed_industry',
		'delivery-type' => 'ccf_delivery',
		'referrer-id' => 'referral',
		'distance-start' => 'ccf_distance_start_date',
		'distance-start-asap' => 'ccf_distance_start_asap',
		'Browser Application' => 'browserApp',
		'Browser Version' => 'browserVer',
		'agree-terms' => 'ccf_terms_agree'
	);

	$fields = array_merge(	$billing_info , $postal_address, $company_address, $additional_info );

	foreach ($fields as $meta_key=>$form_field) {
		$field_value = '';
		$field_value = isset($_POST[$form_field])? sanitize_text_field($_POST[$form_field]): ''  ;
		$submitted = $_POST[$form_field];
		//if the value for the form field is an array/checkbox
		if(is_array(	$submitted)){
			$field_value = implode(", ", 	$submitted);
		}
		//if the value for the meta_field is a combiantion of form fields
		if(is_array($form_field)){
			$field_value  = '';
			foreach($form_field as $compound_field){
				if ( !isset($_POST[$compound_field] )) { continue; }
				$field_value .= sanitize_text_field($_POST[$compound_field]) . ' ';
			}
		}
		$res = update_post_meta( $order_id, $meta_key, $field_value );
	}

	update_post_meta($order_id, 'order_payment_date', time());
  update_post_meta($order_id, 'order_id', $order_id);
	update_post_meta( $order_id, 'company_invoice_flag', $_POST['ccf_comp_cont_phone'] );
	update_post_meta( $order_id, '_billing_phone', $_POST['billing_home_phone'] );

	if($_POST['shiptobilling']){
		update_post_meta( $order_id, '_billing_phone', $_POST['ccf_comp_cont_phone'] );
	}

	//Below are Meta Fields for Special Events
	//REFACTOR THIS!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

  // Delivery location - possibly redundant?
  if (! empty($_POST['ccf_delivery_location'])) {
    update_post_meta( $order_id, 'delivery-location', esc_attr($_POST['ccf_delivery_location'][0]));
  }

  // Delivery Locations
  if (isset($_POST['ccf_delivery_location'])) {
    $delivery_loc = implode(',',$_POST['ccf_delivery_location']);
    update_post_meta( $order_id, 'delivery-locations', $delivery_loc);
  }

  // Delivery Locations
  if (isset($_POST['ccf_delivery_location_1'])) {
    update_post_meta( $order_id, 'delivery-locations-1', esc_attr($_POST['ccf_delivery_location_1']));
  }

  // Event: Start Time
  if (! empty($_POST['ccf_delivery_location_timetable_1'])) {
    update_post_meta( $order_id, 'event_start_time', esc_attr($_POST['ccf_delivery_location_1']));
  }

  // Event: Ids
  if (! empty($_POST['ccf_event_id'])) {
    $event_ids = implode(',',$_POST['ccf_event_id']);
    update_post_meta( $order_id, 'course_event_ids', $event_ids);
  }

  // Delivery location 2
  if (! empty($_POST['ccf_delivery_location_2'])) {
   update_post_meta( $order_id, 'delivery-location-2', esc_attr($_POST['ccf_delivery_location_2']));
  }

  // Start date: Blended
  if (! empty($_POST['ccf_delivery_location_timetable'])) {
    $dateArray = $_POST['ccf_delivery_location_timetable'];
    $date = array_filter($dateArray);
    foreach( $date as $key => $n ) {
      update_post_meta( $order_id, 'start-date', $n);
    }
  }
  // Add first start date
  if (! empty($_POST['ccf_delivery_location_timetable_1'])) {
    $dateArray = $_POST['ccf_delivery_location_timetable_1'];
    $date = array_filter($dateArray);
    foreach( $date as $key => $n ) {
      update_post_meta( $order_id, 'course-start-date-1', $n);
    }
  }

  if (! empty($_POST['course_location_1'])) {
    update_post_meta( $order_id, 'course-location-1', esc_attr($_POST['course_location_1']));
  }

  if (! empty($_POST['course_location_2'])) {
    update_post_meta( $order_id, 'course-location-2', esc_attr($_POST['course_location_2']));
  }

  if (! empty($_POST['course_location_3'])) {
    update_post_meta( $order_id, 'course-location-3', esc_attr($_POST['course_location_3']));
  }

  if (! empty($_POST['course_location_4'])) {
    update_post_meta( $order_id, 'course-location-4', esc_attr($_POST['course_location_4']));
  }

  if (! empty($_POST['course_date_1'])) {
    update_post_meta( $order_id, 'course-date-1', esc_attr($_POST['course_date_1']));
  }

  if (! empty($_POST['course_date_2'])) {
    update_post_meta( $order_id, 'course-date-2', esc_attr($_POST['course_date_2']));
  }

  if (! empty($_POST['course_date_3'])) {
    update_post_meta( $order_id, 'course-date-3', esc_attr($_POST['course_date_3']));
  }

  if (! empty($_POST['course_date_4'])) {
    update_post_meta( $order_id, 'course-date-4', esc_attr($_POST['course_date_4']));
  }
  // Location timetable 2
  if (! empty($_POST['ccf_delivery_location_timetable_2'])) {
    // $ctr = 0;
    $dateArray = $_POST['ccf_delivery_location_timetable_2'];
    $date = array_filter($dateArray);

    foreach( $date as $key => $n ) {
        // Input has some text and is not empty.. process accordingly..
        update_post_meta( $order_id, 'course-start-date-2', $n);
      }
  }

  // Location timetable 3
  if (! empty($_POST['ccf_delivery_location_timetable_3'])) {
    // $ctr = 0;
    $dateArray = $_POST['ccf_delivery_location_timetable_3'];
    $date = array_filter($dateArray);

    foreach( $date as $key => $n ) {
        // Input has some text and is not empty.. process accordingly..
        update_post_meta( $order_id, 'course-start-date-3', $n);
      }
  }

  // Location timetable 4
  if (! empty($_POST['ccf_delivery_location_timetable_4'])) {
    // $ctr = 0;
    $dateArray = $_POST['ccf_delivery_location_timetable_4'];
    $date = array_filter($dateArray);

    foreach( $date as $key => $n ) {
        // Input has some text and is not empty.. process accordingly..
        update_post_meta( $order_id, 'course-start-date-4', $n);
      }
  }
  // Student number
  if (! empty($_POST['ccf_student_num'])) {
   update_post_meta( $order_id, 'Student Number', sanitize_text_field( $_POST['ccf_student_num']));
  }
  // Student course
  if (! empty($_POST['ccf_student_course'])) {
   update_post_meta( $order_id, 'Student Course', sanitize_text_field( $_POST['ccf_student_course']));
  }
  // Student coursee extend
  if (! empty($_POST['ccf_course_extnd'])) {
   update_post_meta( $order_id, 'Course Extension Date', sanitize_text_field( $_POST['ccf_course_extnd']));
  }
}

add_action('woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta');
function my_custom_checkout_field_update_order_meta( $order_id ) {
	global $woocommerce;

	foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];
		$product_id = $_product->get_id();
		$terms = get_the_terms( $product_id, 'product_cat' );
		foreach ($terms as $term) {
				$product_cat_id = $term->term_id;
				break;
		}
	}

	if (in_array($product_cat_id, array('462', '463', '466', '502') )) {
		if (! empty($_POST['ccf_terms_agree_hardware'])) {
			update_post_meta( $order_id, 'agree-terms', esc_attr($_POST['ccf_terms_agree_hardware']));
		}
	}
}
