<?php

// WooCommerce Customisation
// add_action( 'woocommerce_order_status_completed', 'api_submission' );
/*
 * Do something after WooCommerce sets an order on completed
 */
function api_submission($order_id) {
  global $woocommerce;
  // Id's of the products in the cart
  $prod_ids = array();
  // Categories of the products in the cart
  $cats_cart = array();

  $order = new WC_Order( $order_id );
  $items = $order->get_items();

  $is_renewal = ma_is_subscription_renewal();

  foreach ( $items as $item ) {
    $product_id = $item['product_id'];

    $terms = get_the_terms( $product_id, 'product_cat' );
    foreach ($terms as $term) {
        $product_cat_id = $term->term_id;

        $cats_cart[] = $product_cat_id;
    }
  }

  if (empty($cats_cart)) {

    $array1 = array("a" => '1');

  } else {

    $array1 = $cats_cart;

  }

  $array2 = array("b" => '462', '463', '466', '502','472');
  $result = array_diff($array1, $array2);

  // If the category is Alptop or Software do noting...
  // if (in_array($product_cat_id, array('462', '463', '466') )) {
  if (empty($result) || $is_renewal) {

    // do nothing

  // } elseif (in_array('472', $cats_cart)) {

  // If is any other product and enrolment needs to take place...
  } else {

    // Grab custom fields and assign them to variables

    // Personal details

      // First Name
      $first_name = get_post_meta( $order_id, '_billing_first_name', true );

      // Middle Name
      $middle_name = get_post_meta( $order_id, 'middle-name', true );

      // Last Name
      $last_name = get_post_meta( $order_id, '_billing_last_name', true );

      // DOB
      $dob = get_post_meta( $order_id, 'date-of-birth', true );
      $dob = str_replace('/', '-', $dob);
      $final_dob = date('Y-m-d', strtotime($dob));

      // Country of birth
      $country_of_birth = get_post_meta( $order_id, 'country-of-birth', true );

      // Gender
      $gender = get_post_meta( $order_id, 'gender', true );


    // Contact Details

      // Postal Address - street
      //$address_street1 = get_post_meta( $order_id, '_billing_address_1', true );
      // Postal Address - suburb
      $address_suburb = get_post_meta( $order_id, '_billing_city', true );
      // Postal Address - post code
      $address_postcode = get_post_meta( $order_id, '_billing_postcode', true );
      // Postal Address - State
      $address_state = get_post_meta( $order_id, '_billing_state', true );


      // Postal Address Two - street
      $address_street2 = get_post_meta( $order_id, 'ccf_add_two_1', true );
      // Postal Address Two - suburb
      $address_suburb2 = get_post_meta( $order_id, 'ccf_add_two_sub', true );
      // Postal Address Two - post code
      $address_pobox2 = get_post_meta( $order_id, 'ccf_add_two_pobox', true );
      // Postal Address Two - PO Box
      $address_postcode2 = get_post_meta( $order_id, 'ccf_add_two_post', true );
      // Postal Address Two - State
      $address_state2 = get_post_meta( $order_id, 'ccf_add_two_state', true );

    $country_name = get_post_meta( $order_id, 'ccf_add_two_country', true );

      // Contact Phone
      $phone_primary_a = get_post_meta( $order_id, '_billing_phone', true );
      $phone_primary = str_replace(' ','',$phone_primary_a);

      // Contact Ph Second
      // $phone_second_a = get_post_meta( $order_id, 'home-phone', true );
      // $phone_second = str_replace(' ','',$phone_second_a);

      // if ( $phone_second == '' ) :

      //   $phone_second_xml = '';

      // else:

      //   $phone_second_xml = '<contact-detail><primary>true</primary><value>'. $phone_second .'</value><contact-type>Mobile</contact-type><location>Home</location></contact-detail>';

      // endif;


      // Billing & Contact Email
      $email = get_post_meta( $order_id, '_billing_email', true );

      // Shipping or Student email
      // $student_email = get_post_meta( $order_id, 'shipping-email', true );

      // Determine what email to submit to JobReady
      // if (isset($student_email)) {
      //   $enrol_email = $student_email;
      // } else {
      //   $enrol_email = $email;
      // }

    // Additional Info

      // Can you read, write and understand English
      $understand_english = get_post_meta( $order_id, 'understand-english', true );

      // Indigenous status
      $indigenous = get_post_meta( $order_id, 'indigenous', true );

      // What's your language
      // $language = get_post_meta( $order_id, 'language', true );

      // if (!empty($language) {
      //   $main_language = $language;
      // } else {
      //   $main_language = get_post_meta( $order_id, 'main-language', true );
      // }

      $main_language = get_post_meta( $order_id, 'main-language', true );
      $prior_edu_type = get_post_meta( $order_id, 'prior-edu-type', true );


      //What is the main language spoken at home?
    $home_language = get_post_meta( $order_id, 'home-language', true );

      // Do you have access to a computer with internet
      $internet_access = get_post_meta( $order_id, 'internet-access', true );

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

      // Blended Start Date
      $course_blended_start = get_post_meta( $order_id, 'start-date', true );

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

      // Still at school?
      $school = get_post_meta( $order_id, 'studied-last', true );

      // Where did you last undertake formal learning
      $school_name = get_post_meta( $order_id, 'school-name', true );

      // Study level
      $school_level = get_post_meta( $order_id, 'studied-level', true );

    // Study level
      $highest_level = get_post_meta( $order_id, 'school_higest_year', true );

      // Prior education flag (yes/no)
      $prior_edu = get_post_meta( $order_id, 'prior-education-flag', true );

      // Prior education options
      $prior_edu_cert_0 = get_post_meta( $order_id, 'last-formal-learning-0', true );
      $prior_edu_cert_1 = get_post_meta( $order_id, 'last-formal-learning-1', true );
      $prior_edu_cert_2 = get_post_meta( $order_id, 'last-formal-learning-2', true );
      $prior_edu_cert_3 = get_post_meta( $order_id, 'last-formal-learning-3', true );
      $prior_edu_cert_4 = get_post_meta( $order_id, 'last-formal-learning-4', true );
      $prior_edu_cert_5 = get_post_meta( $order_id, 'last-formal-learning-5', true );
      $prior_edu_cert_6 = get_post_meta( $order_id, 'last-formal-learning-6', true );
      $prior_edu_cert_7 = get_post_meta( $order_id, 'last-formal-learning-7', true );
      $prior_edu_cert_8 = get_post_meta( $order_id, 'last-formal-learning-8', true );

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

      // Employment status
      $usi_num = get_post_meta( $order_id, 'ccf_usi_num', true );



      // Course Name
      $order = new WC_Order( $order_id );
      $items = $order->get_items();
      foreach ( $items as $item ) {
          $product_name = $item['name'];

      }
      $entity_decode = strip_tags($product_name);
      $course_name = htmlentities($entity_decode);


      if ( $order ) :
        $payment_method = $order->get_payment_method_title();
      endif;
      $course_payment = $payment_method;


      if ($course_blended_start) :

        $course_start_date_final = $course_blended_start;

      else:

        $course_start_date_final = $course_start_date;

      endif;

      // ASAP?
      $asap = get_post_meta( $order_id, 'distance-start-asap', true );

      // Order Number & Date
      if ( $order ) :
        // Order num
        $order_num = $order->get_order_number();

        //  date
        $order_date = $order->get_date_created(); ;
        $order_date = str_replace('/', '-', $order_date);
        $final_order_date = date('d-m-Y', strtotime($order_date));

      endif;


      // // Test if the student already exists in JobReady
      // $resp = wp_remote_get( 'https://inspireeducation.jobready.com.au/webservice/parties?first_name='. $first_name .'&surname='. $last_name .'&birth-date='. $final_dob);

      // // If they do exist, update their JobReady details
      // if ( 200 == $resp['response']['code'] ) {
      //   $body = $resp['body'];
      //   // perform action with the content.
      // }

      // // If they don't exist, submit enrolment xml
      // else {

      // }


        // Variable to hold second address
        if ($address_street2) {
          $addressTwo = '<address>
            <primary>false</primary>
            <street-address1>' . $address_street2 . '</street-address1>
            <street-address2></street-address2>
            <suburb>'. $address_suburb2 .'</suburb>
            <post-code>'. $address_postcode2 .'</post-code>
            <state>'. $address_state2 .'</state>
            <country1>Australia</country>
            <location>Home</location>
          </address>';
        } else {
          $addressTwo = '';
        }


        // Variable to hold all enrolment xml
        $xml = '
        <?xml version="1.0" encoding="UTF-8"?>
        <party>
          <party-type>Person</party-type>
          <contact-method>Email</contact-method>
          <surname>'. $last_name .'</surname>
          <first-name>'. $first_name .'</first-name>
          <middle-name>'. $middle_name .'</middle-name>
          <birth-date>'. $final_dob .'</birth-date>
          <gender>'. $gender .'</gender>
          <usi-number>'. $usi_num .'</usi-number>
        <addresses>
          <address>
            <primary>true</primary>
            <street-address1>' . $address_street1 . '</street-address1>
            <street-address2></street-address2>
            <suburb>'. $address_suburb .'</suburb>
            <post-code>'. $address_postcode .'</post-code>
            <state>'. $address_state .'</state>
            <country>Australia</country>
            <location>Home</location>
          </address>
          '.$addressTwo.'
        </addresses>
        <contact-details>
            <contact-detail>
              <primary>true</primary>
              <value>'. $email .'</value>
              <contact-type>Email</contact-type>
              <location>Home</location>
            </contact-detail>
            <contact-detail>
              <primary>false</primary>
              <value>'. $phone_primary .'</value>
              <contact-type>Phone</contact-type>
              <location>Work</location>
            </contact-detail>
      <contact-detail>
              <primary>false</primary>
              <value>'. $phone_primary .'</value>
              <contact-type>Phone sss</contact-type>
              <location>Work</location>
            </contact-detail>
          </contact-details>
          <avetmiss>
            <main-language>'. $main_language .'</main-language>
            <country-of-birth>'. $country_of_birth .'</country-of-birth>
      <disability-flag>' . $disability_toggle . '</disability-flag>
            <prior-education-flag>'. $prior_edu .'</prior-education-flag>
            <at-school-flag>' . $school . '</at-school-flag>
            <highest-school-level>' . $school_level . '</highest-school-level>
            <year-highest-school-level>' . $highest_level . '</year-highest-school-level>
            <school-name>' . $school_name . '</school-name>
            <indigenous-status>' . $indigenous . '</indigenous-status>
            <employment-status>' . $employ_status . '</employment-status>
            <at-school-flag>Yes</at-school-flag>
            <spoken-english-proficiency>'. $understand_english .'</spoken-english-proficiency>
            <disabilities>
              <disability>
                <disability-type>' . $disability . '</disability-type>
              </disability>
            </disabilities>
            <prior-educations>
              <prior-education>
                <prior-education-type>'. $prior_edu_type .'</prior-education-type>
              </prior-education>
            </prior-educations>
          </avetmiss>
          <ad-hoc-fields>
            <ad-hoc-field>
              <name>Do you have access to a computer with internet</name>
              <value>' . $internet_access . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>How do you rate your computer skills</name>
              <value>' . $computer_ability . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>How do you rate your ability to work with numbers</name>
              <value>' . $number_ability . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Do you need any additional support?</name>
              <value>' . $additional_support . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>If yes, please specify:</name>
              <value>' . $additional_support_specify . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Start Date for Week 1</name>
              <value>' . $course_start_date_final . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Delivery Option</name>
              <value>' . $delivery_type . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Start Date for Week 2</name>
              <value>' . $course_start_date_two . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Distance Course Start Date</name>
              <value>' . $course_distance_start . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Blended Location Week 1</name>
              <value>' . $location_week_1 . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Blended Location Week 2</name>
              <value>' . $location_week_2 . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Course Name</name>
              <value>' . $course_name . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Student\'s reason for doing the course:</name>
              <value>' . $study_reason . '</value>
            </ad-hoc-field>

            <ad-hoc-field>
              <name>Current yearly household income?</name>
              <value>' . $yearly_income . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Industry currently employed in?</name>
              <value>' . $employed_industry . '</value>
            </ad-hoc-field>

            <ad-hoc-field>
              <name>Do you want RPL?</name>
              <value>' . $enrolment_type . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Course Name</name>
              <value>' . $course_name . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Course Payment</name>
              <value>' . $course_payment . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>ASAP</name>
              <value>' . $asap . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>order #</name>
              <value>' . $order_num . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Application Date</name>
              <value>' . $final_order_date . '</value>
            </ad-hoc-field>
          </ad-hoc-fields>
        </party>';





        // Post data to the API
        $username = 'api'; // API login
        $password = 'c7c437e1358140926bd275a0b6ff7f85dc428350'; // API password

        // Set the URL you are posting the data to:
        $post_url = "https://inspireeducation.jobreadyrto.com.au/webservice/parties?pretty_print=true";

        // Now, the HTTP request
        $args = array(
            'method' => 'POST',
            'timeout' => '45',
            'redirection' => '5',
            'httpversion' => '1.0',
            'headers' => array(
              'Authorization' => 'Basic '.base64_encode("$username:$password"),
              'Content-Type' => 'text/xml'
            ),
            'body' => $xml,
            'sslverify' => false
        );



        // $response to contain the XML of the new Single Record
        $response = wp_remote_post( $post_url, $args );

        // Echo the returned XML to see what you are getting
        // header('Content-type: text/xml');
        // echo $response;
        // info@markaugias.com brent.r@inspireeducation.net.au

        $to = "info@markaugias.com";
        $subject = "Inspire JobReady Enrollment";
        $message = $response['body'];
        $from = "onlineenrolments@inspireeducation.net.au";
        $headers = "From:" . $from;
        mail($to,$subject,$message,$headers);


// WP_REMOTE_POST

        // Set Headers
        // $headers = array(
        //   'Authorization' => 'Basic ' . base64_encode('$username:$password'),
        // );

        // $response = wp_remote_post(
        //   'https://inspireeducation.jobreadyrto.com.au/webservice/parties',
        //   array(
        //     'method'      => 'POST',
        //     'timeout'     => 45,
        //     'redirection' => 5,
        //     'headers'     => $headers,
        //     'body'        => $xml,
        //     'httpversion' => '1.1',
        //     'sslverify' => true,
        //   )
        // );

        // if (is_wp_error($response)) {
        //   $jrmessage = "There was an error";
        // }
        // else {
        //   $jrmessage = var_dump( $response );
        // }

        // // $response to contain the XML of the new Single Record
        // $to = "info@markaugias.com";
        // $subject = "Inspire JobReady Enrollment";
        // $message = $jrmessage;
        // $from = "onlineenrolments@inspireeducation.net.au";
        // $headers = "From:" . $from;
        // mail($to,$subject,$message,$headers);




  } // End else

}

?>
