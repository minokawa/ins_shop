<?php
  echo '<fieldset id="step3" class="tab-pane fade"><h1 class="course-title">'.__('Additional Info').'</h1>';

  // Open hidebloack
  echo '<div class="hide_block123">'; // added from moodle

  echo '<div class="checkbox clearfix"><h5>Have you completed any Prior Education? <abbr class="required" title="required">*</abbr></h5>';

  // Prior Education
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

  echo '</div>'; // close checkbox div

  echo '<div id="prior_education_options" class="checkbox clearfix"><h5>Please indicate the highest qualification you have previously achieved from the following list <abbr class="required" title="required">*</abbr></h5>';

    // Schedule Function
    // ======================================================
      formal_learning_options();

      // added from moodle
      $year = array( '' => 'Select year' );
      for($i=date('Y') - 50; $i <= date('Y');$i++ ){
        $year[$i] = $i;
      }
      echo '<div class="checkbox clearfix"><h5>What year did you complete your highest qualification?  <abbr class="required" title="required">* <span>required</span></abbr> </h5>';
        // Edu completed year
        woocommerce_form_field( 'ccf_comple_edu_year', array(
          'type' => 'select',
          'label' => __( '' ),
          'placeholder' => __( '' ),
          'required' => true,
           'class'         => array('completed required text'),
          'options' => $year
        ), $checkout->get_value( 'ccf_comple_edu_year' ) );
      echo '</div>'; // close checkbox div

  echo '</div>'; // close checkbox div

  echo '<div class="checkbox clearfix"><h5>Do you have access to a computer with internet? <abbr class="required" title="required">*</abbr></h5>';

  // Internet?
  woocommerce_form_field_radio( 'ccf_internet_con', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
        'Yes' => 'Yes',
        'No' => 'No'

    )), $checkout->get_value( 'ccf_internet_con' ) );

  echo '</div>'; // close checkbox div

  echo '<div class="checkbox clearfix"><h5>I understand that these are online courses and that I will access all my learning materials online, and that all my results and all my student correspondence will be received online. <abbr class="required" title="required">*</abbr></h5>';

  // Online correspondence  acknowledgement
  woocommerce_form_field_radio( 'ccf_online_cori', array(
        'type' => 'select',
        'label' => __( '' ),
        'placeholder' => __( '' ),
        'required' => true,
        'options' => array(
        'Yes' => 'Yes'

    )), $checkout->get_value( 'ccf_online_cori' ) );

  echo '</div>'; // close checkbox div

  echo '<div class="checkbox clearfix"><h5>How do you rate your computer skills? <abbr class="required" title="required">*</abbr></h5>';

  // Computer Skills
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

  echo '</div>'; // close checkbox div

  echo '<div class="checkbox clearfix"><h5>How do you rate your ability to work with numbers? <abbr class="required" title="required">*</abbr></h5>';

  // Number ability
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

  echo '</div>'; // close checkbox div

  // echo '<div class="checkbox clearfix"><h5>Do you consider yourself to have a Physical /Mental Disability that may affect your participation in the course? <abbr class="required" title="required">*</abbr></h5>';
  // added from moodle
  echo '<div class="checkbox clearfix"><h5>Do you consider yourself to have a disability, impairment or long term condition that may affect your participation in the course? <abbr class="required" title="required">*</abbr></h5>';

    // disability
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
    echo '</div>'; // close disability type
  echo '</div>'; // close checkbox div

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

  echo '</div>'; // close checkbox div

  echo '</div>'; // close hide_block123



  // Schedule Function
    // ======================================================
    /* jaz added */
    global $wpdb;
  // Find the id('s) of the product(s) in the cart
  foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
    $_product = $values['data'];

    // $product_id is the id of the product in the cart
    $product_id = $_product->get_id();
    $prod_ids[] = $product_id;

    $terms = get_the_terms( $product_id, 'product_cat' );

    foreach ($terms as $term) {

      $product_cat_id = $term->term_id;
      $product_cat_slug = $term->slug;

    }
  }


    $querystrj = "SELECT * from {$wpdb->postmeta} WHERE post_id = $product_id AND meta_key = '_sku'";
    $skuids = $wpdb->get_results($querystrj, OBJECT);
    //print_r($skuids);
    foreach ($skuids as $skuid) {
      $finlskuid = explode(',',$skuid->meta_value);
      foreach($finlskuid as $key => $finlskuids){

        $data['data'] = $finlskuids;

        if($product_cat_slug == 'workshop_event'){
          $data['sp_event'] = 'spevent';
        }

        //print_r($data);
        $server = explode('www.', $_SERVER['HTTP_HOST']);
        $serverurl  = $server[0];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, wp_sync);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
        $response = curl_exec($ch);
        curl_close($ch);
        $respo = json_decode($response,true);

        echo "<div id='debug-respo' style='display:none;'>";
        print_r($respo);
        print_r($key);
        echo "</div>";

        /* end jaz added */

        // var_dump($product_cat_slug);

        if($product_cat_slug != 'workshop_event'){
          grab_ids_in_category($respo, $key);
        } else {
          grab_ids_in_category_spacial($respo, $key);
        }
        /* jaz added */
      }
    } // End foreach

            /*$ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,'http://localhost/inspire_moodle/course/course_wpsync.php');
            curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

            $response = curl_exec($ch);
            print_r($response);

            curl_close($ch);
            $respo = json_decode($response,true);*/

             /* end jaz added */
                       //grab_ids_in_category($respo);
                /* jaz added */ ?>
    <script>
      jQuery(document).ready(function($) {

        $('#full_location_timetable').slideUp();
        $('#full_location_timetable_new').slideUp();
        // for tree val 1
        if ($('.ccf_input_deliv:checked')) {

        $('#full_location_timetable').slideDown();

        } else  {
          $('#full_location_timetable').slideUp();
        }

        $('.ccf_input_deliv:input').change(function() {
          if ($('.ccf_input_deliv:checked')) {
            $('#full_location_timetable').slideDown();
          } else  {
            $('#full_location_timetable').slideUp();
            $('#full_location_timetable_new').slideUp();
          }
        });

        // for tree val 2
        //$( "#myselect option:selected" ).text();
        $('#ccf_delivery_location:input').change(function() {
          var locationid = $( "#ccf_delivery_location option:selected" ).val();

          if(locationid > 0) {
            var courseid = document.getElementById('moodlecourseid').value;
            $.ajax({
              method: "GET",
              url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
              data: { course_id: courseid, location_id: locationid }
          })
          .done(function( msg ) {
            document.getElementById('ccf_delivery_location_timetable_full_1').innerHTML = msg;
          });

          // ajax wil run here
          $('#full_location_timetable_new').slideDown();

          } else {
            $('#full_location_timetable_new').slideUp();
          }
        });

        setTimeout( function(){
          var locationid = $( "#ccf_delivery_location option:selected" ).val();

          if(locationid > 0) {
            var courseid = document.getElementById('moodlecourseid').value;
            $('#full_location_timetable_new').slideDown();

            $.ajax({
              method: "GET",
              url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
              data: { course_id: courseid, location_id: locationid,action:'normal' }
            })
            .done(function( msg ) {
              var details = msg.split("__jaz__");
              var ndet = details[1].split("?>");
              document.getElementById('ccf_delivery_location_timetable_full_1').innerHTML = details[0]+ndet[1];
            });

          } else {
            $('#full_location_timetable_new').slideUp();
          }
        }, 5000);
      });

      function eventlocation(eventids , courseid) {
        //var courseid = document.getElementById('moodlecourseid').value;
        var custom_id = document.getElementById('custom_id');

        if(custom_id){
          var spacialevent = 'spacial';
        }else{
          var spacialevent = '';
        }

        var ids1 = 'ccf_event_id_'+eventids;
        //alert(ids1);
        var eventid = eventids;
        //alert(eventid);
        //  var eventid = eventids;
        var ids2 = 'ccf_delivery_location_'+eventids+'_'+courseid;
        var locationid = jQuery( "#"+ids2+" option:selected" ).val();

        var dateId = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;

        document.getElementById(dateId).innerHTML = "<option>Updating timetables...</option>";

        jQuery.ajax({
          method: "GET",
          url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
          data: { course_id: courseid, eventid_id: eventid,location_id:locationid,action:'eventlocation',eventtype:spacialevent }
        })
        .done(function( msg ) {
          var valueto = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;
    // alert(valueto);
    //alert(msg);
          document.getElementById(valueto).innerHTML = msg;
        });

        $('#'+dateId).on('change', function() {
          var locationstring = $('#'+ids2+' option:selected').text();
          var datestring = $('#'+dateId+' option:selected').text();
          // alert(datestring);
          $('#course_location_'+eventids).val(locationstring);
          $('#course_date_'+eventids).val(datestring);
        });
      }

      function eventlocationname(eventids,courseid) {
       // var courseid = document.getElementById('moodlecourseid').value;
        var custom_id = document.getElementById('custom_id');

        if(custom_id){
          var spacialevent = 'spacial';
        } else {
          var spacialevent = '';
        }

        var ids1 = 'ccf_event_id_'+eventids;
        //alert(ids1);
        var eventid = eventids;
        //alert(eventid);
        //  var eventid = eventids;
        var ids2 = 'ccf_delivery_location_'+eventids+'_'+courseid;
        var locationid = jQuery( "#"+ids2+" option:selected" ).val();

        jQuery.ajax({
          method: "GET",
          url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
          data: { course_id: courseid, eventid_id: eventid,location_id:locationid,action:'eventlocation',eventtype:spacialevent,display:'name' }
        })
        .done(function( msg ) {
          var valueto = 'ccf_delivery_location_timetable_full_'+eventids+'_'+courseid;
   // alert(valueto);
    //alert(msg);
          document.getElementById(valueto).innerHTML = msg;
        });
      }


      function eventclass(eventids) {
        var courseid = document.getElementById('moodlecourseid').value;
        var ids = 'ccf_event_id_'+eventids;
        var eventid = jQuery( "#"+ids+" option:selected" ).val();

        jQuery.ajax({
          method: "GET",
          url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
          data: { course_id: courseid, eventid_id: eventid,action:'eventclass' }
        })
        .done(function( msg ) {
          var valueto = 'ccf_delivery_location_'+eventids;
          document.getElementById(valueto).innerHTML = msg;
        });

      }


      function eventupdate(id) {
        var ids = 'ccf_delivery_location_timetable_full_'+id;
        var eventid = jQuery( "#"+ids).val();
        //alert(eventid);
        jQuery('#ccf_event_id_'+id).val(eventid);
      }

      function eventupdatetime(event) {
        //var ids = 'ccf_delivery_location_timetable_full_'+id;
        //var eventid = jQuery( "#"+ids).val();
        var eventid = event.value;
        //alert(eventid);
        jQuery.ajax({
          method: "GET",
          url: "<?php echo network_home_url(); ?>/ajax_moodle.php",
          data: { evid: eventid ,eventtyme:'time' }
        })
        .done(function( msg ) {
          //alert(msg);
          //var valueto = 'ccf_delivery_location_timetable_full_'+eventids;
          document.getElementById('time_event').value = msg;
        });
      }

    </script>

    <?php
    /* end jaz added */
  // end added from moodle

  // added from moodle
  echo '<div class="hide_block123">';
  echo '<div class="checkbox clearfix"><h5>Do you wish to apply for Recognition of Prior Learning (RPL)? <abbr class="required" title="required">*</abbr></h5>';

  // Distance Learning
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

  // Reason for undertaking
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

  // Yearly Income
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

  // What industry are you currently employed in?
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

