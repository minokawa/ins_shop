<?php
  echo '<fieldset id="step3" class="tab-pane fade"><h1 class="course-title">'.__('Additional Info').'</h1>';
  echo '<div class="hide_block123">';
  echo '<div class="checkbox clearfix"><h5>Have you completed any Prior Education? <abbr class="required" title="required">*</abbr></h5>';
  woocommerce_form_field_radio( 'ccf_prior_edu', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'class'         => array('text required'),
        'required' => true,
        'options' => array(
          'Yes' => 'Yes',
          'No' => 'No',
          'Not stated' => 'Not stated'

    )), $checkout->get_value( 'ccf_prior_edu' ) );

  echo '</div>';
  echo '<div id="prior_education_options" class="checkbox clearfix"><h5>Please indicate the highest qualification you have previously achieved from the following list <abbr class="required" title="required">*</abbr></h5>';

	echo formal_learning_options();

	$year = array( '' => 'Select year' );
	for($i=date('Y') - 50; $i <= date('Y');$i++ ){
		$year[$i] = $i;
	}
	echo '<div class="checkbox clearfix"><h5>What year did you complete your highest qualification?  <abbr class="required" title="required">* <span>required</span></abbr> </h5>';
		woocommerce_form_field( 'ccf_comple_edu_year', array(
			'type' => 'select',
			'label' => __( '' ),
			'placeholder' => __( '' ),
			'required' => true,
				'class'         => array('completed required text'),
			'options' => $year
		), $checkout->get_value( 'ccf_comple_edu_year' ) );

	echo '</div>';
  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>Do you have access to a computer with internet? <abbr class="required" title="required">*</abbr></h5>';


  woocommerce_form_field_radio( 'ccf_internet_con', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
        'Yes' => 'Yes',
        'No' => 'No'

    )), $checkout->get_value( 'ccf_internet_con' ) );

  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>I understand that these are online courses and that I will access all my learning materials online, and that all my results and all my student correspondence will be received online. <abbr class="required" title="required">*</abbr></h5>';

  woocommerce_form_field_radio( 'ccf_online_cori', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
        'Yes' => 'Yes'

    )), $checkout->get_value( 'ccf_online_cori' ) );

  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>How do you rate your computer skills? <abbr class="required" title="required">*</abbr></h5>';
  woocommerce_form_field_radio( 'ccf_comp_skills', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
          'Excellent' => 'Excellent',
          'Good' => 'Good',
          'Basic' => 'Basic',
          'Poor' => 'Poor'

    )), $checkout->get_value( 'ccf_comp_skills' ) );

  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>How do you rate your ability to work with numbers? <abbr class="required" title="required">*</abbr></h5>';


  woocommerce_form_field_radio( 'ccf_num_ability', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
          'Excellent' => 'Excellent',
          'Good' => 'Good',
          'Basic' => 'Basic',
          'Poor' => 'Poor'

    )), $checkout->get_value( 'ccf_num_ability' ) );

  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>Do you consider yourself to have a disability, impairment or long term condition that may affect your participation in the course? <abbr class="required" title="required">*</abbr></h5>';

	woocommerce_form_field_radio( 'ccf_disability_toggle', array(
			'type' => 'select',
			'label' => __( '' ),
			'placeholder' => __( '' ),
			'required' => true,
			'options' => array(
				'No' => 'No',
				'Yes' => 'Yes',
				'Not Stated' => 'Not Stated'

	)), $checkout->get_value( 'ccf_disability_toggle' ) );

	echo'<div id="disability-type"><h5>Please select what disability relates most to you</h5>';
		woocommerce_form_field_radio( 'ccf_disability', array(
				'type' => 'select',
				'label' => __( '' ),
				'placeholder' => __( '' ),
				'required' => true,
				'options' => array(
					// added from moodle
					'' => 'Select',
					'Vision' => 'Vision',
					'Physical' => 'Physical',
					'Hearing/Deaf' => 'Hearing',
					'Intellectual' => 'Intellectual',
					'Learning' => 'Learning',
					'Mental illness' => 'Mental illness',
					'Acquired brain impairment' => 'Acquired brain impairment',
					'Medical condition' => 'Medical condition',
					// 'Illness' => 'Illness',
					'Other' => 'Other'

		)), $checkout->get_value( 'ccf_disability' ) );
	echo '</div>';
  echo '</div>';
  echo '<div class="checkbox clearfix"><h5>Do you need any additional support? <abbr class="required" title="required">*</abbr></h5>';

  // Support?
  woocommerce_form_field_radio( 'ccf_support', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
        'Yes' => 'Yes',
        'No' => 'No'

    )), $checkout->get_value( 'ccf_support' ) );
  // If yes, please specify
  woocommerce_form_field( 'ccf_support_specify', array(
        'type'          => 'text',
        'required'  => false,
        'class'         => array('text'),
        'label'         => __('If yes, please specify'),
        'placeholder'         => __(''),
        ), $checkout->get_value( 'ccf_support_specify' ));

  echo '</div>';
  echo '</div>';

	global $wpdb;

	//WTF IS THIS LOOP TRYING TO DO?
	foreach($woocommerce->cart->get_cart() as $cart_item_key => $cart_item_values ) {
		$product_id = $cart_item_values['product_id'];
		$prod_ids[] = $product_id;
	}

	$product = wc_get_product( $product_id );
	$product_skus = $product->get_sku();
	$product_skus_arr = explode(',',$product_skus);
	$server = explode('www.', $_SERVER['HTTP_HOST']);
	$serverurl  = $server[0];
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, wp_sync);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	foreach($product_skus_arr as $key => $sku_id){
		$data['data'] = $sku_id;
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		$respo = json_decode($response,true);
		grab_ids_in_category($respo, $key);
	}
	curl_close($ch);

  echo '<div class="hide_block123">';
  echo '<div class="checkbox clearfix"><h5>Do you wish to apply for Recognition of Prior Learning (RPL)? <abbr class="required" title="required">*</abbr></h5>';

  woocommerce_form_field_radio( 'ccf_learning_type', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
            'Yes' => 'Yes',
            'No' => 'No'

  )), $checkout->get_value( 'ccf_learning_type' ) );

  echo '</div>'; // close checkbox div

  woocommerce_form_field( 'ccf_reason_undertake', array(
    'type'          => 'select',
    'required'  => true,
    'class'         => array('text clearfix full-width'),
    'label'         => __('Of the following options, which BEST describes your main reason for undertaking this course?'),
    'options'     => array(
      '' => __('Select reason...', 'woocommerce' ),
      'To get a job' => __('To get a job', 'woocommerce' ),
      'To develop my existing business' => __('To develop my existing business', 'woocommerce' ),
      'To start my own business' => __('To start my own business', 'woocommerce' ),
      'To try for a different career' => __('To try for a different career', 'woocommerce' ),
      'To get a job or promotion' => __('To get a job or promotion', 'woocommerce' ),
      'It was a requirement of my job' => __('It was a requirement of my job', 'woocommerce' ),
      'I wanted extra skills for my job' => __('I wanted extra skills for my job', 'woocommerce' ),
      'To get into another course of study' => __('To get into another course', 'woocommerce' ),
      'For personal reasons or self development' => __('For personal reasons or self development', 'woocommerce' ),
      'Other reasons' => __('Other reasons', 'woocommerce' ),

    ),
  ), $checkout->get_value( 'ccf_reason_undertake' ));

  woocommerce_form_field( 'ccf_yearly_income', array(
    'type'          => 'select',
    'required'  => true,
    'class'         => array('text clearfix full-width'),
    'label'         => __('What is your current yearly household income?'),
    'options'     => array(
      '' => __('Select income...', 'woocommerce' ),
      '$19,999 or less' => __('$19,999 or less', 'woocommerce' ),
      '$20,000 to $29,999' => __('$20,000 to $29,999', 'woocommerce' ),
      '$30,000 to $39,999' => __('$30,000 to $39,999', 'woocommerce' ),
      '$40,000 to $49,999' => __('$40,000 to $49,999', 'woocommerce' ),
      '$50,000 to $59,999' => __('$50,000 to $59,999', 'woocommerce' ),
      '$60,000 to $69,999' => __('$60,000 to $69,999', 'woocommerce' ),
      '$70,000 to $79,999' => __('$70,000 to $79,999', 'woocommerce' ),
      '$80,000 to $89,999' => __('$80,000 to $89,999', 'woocommerce' ),
      '$90,000 to $99,999' => __('$90,000 to $99,999', 'woocommerce' ),
      '$100,000 or more' => __('$100,000 or more', 'woocommerce' ),
      'Not Stated' => __('Not Stated', 'woocommerce' )
    ),

  ), $checkout->get_value( 'ccf_yearly_income' ));

  woocommerce_form_field( 'ccf_employed_industry', array(
    'type'          => 'select',
    'required'  => true,
    'class'         => array('text clearfix full-width'),
    'label'         => __('What industry are you currently employed in?'),
    'options'     => array(
      '' => __('Select industry...', 'woocommerce' ),
      'Not currently employed' => __('Not currently employed', 'woocommerce' ),
      'Accommodation and Food Services' => __('Accommodation and Food Services', 'woocommerce' ),
      'Administrative and Support Services' => __('Administrative and Support Services', 'woocommerce' ),
      'Arts and Recreation Services' => __('Arts and Recreation Services', 'woocommerce' ),
      'Construction' => __('Construction', 'woocommerce' ),
      'Education and Training' => __('Education and Training', 'woocommerce' ),
      'Electricity, Gas, Water, Waste Services' => __('Electricity, Gas, Water, Waste Services', 'woocommerce' ),
      'Financial and Insurance Services' => __('Financial and Insurance Services', 'woocommerce' ),
      'Health Care and Social Assistance' => __('Health Care and Social Assistance', 'woocommerce' ),
      'Information Media and Telecommunications' => __('Information Media and Telecommunications', 'woocommerce' ),
      'Manufacturing' => __('Manufacturing', 'woocommerce' ),
      'Mining' => __('Mining', 'woocommerce' ),
      'Professional, Scientific, Technical Services' => __('Professional, Scientific, Technical Services', 'woocommerce' ),
      'Public Administration and Safety' => __('Public Administration and Safety', 'woocommerce' ),
      'Retail Trade' => __('Retail Trade', 'woocommerce' ),
      'Transport, Postal and Warehousing' => __('Transport, Postal and Warehousing', 'woocommerce' ),
      'Wholesale Trade' => __('Wholesale Trade', 'woocommerce' ),
      'Other' => __('Other', 'woocommerce' ),
    ),

  ), $checkout->get_value( 'ccf_employed_industry' ));

  echo '</div>'; // close hide_block123
  echo '<a class="previous" data-prev-block="2" data-current-block="3">Previous Step</a> <a class="next" id="next-additional" data-current-block="3" data-next-block="4" >Next Step</a>';
	echo '</fieldset>'; // Additional info close
