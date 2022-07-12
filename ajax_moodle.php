<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
 require( './wp-config.php' );

 if($_GET['eventtyme']){
 $data['eventtymeid'] = $_GET['evid'];
 $ch = curl_init();
	//curl_setopt($ch,CURLOPT_URL,'http://inspireeducation.edu.au/learning28/course/course_wpevent.php');
	curl_setopt($ch,CURLOPT_URL, WP_Moodle_courseevent);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

	$response = curl_exec($ch);
	curl_close($ch);
	 $respo = json_decode($response,true);
	foreach($respo['event'] as $keyevent=>$valueevent) {
					$eventid = $valueevent['event_id'];
					$productidds = gettingvalues($eventid,$locationid);
					$firstdate = explode(',',$valueevent['event_fulltimestart']);
					$enddate = explode(',',$valueevent['event_fulltimeduration']);
					$startdate = $firstdate[0];
					$starttime = $firstdate[1];
					$enddates = $enddate[0];
					$endtime = $enddate[1];
				echo $finaldatelocation = $startdate.' - '.$enddates.', '.$starttime.' - '.$endtime;
					
					
				}
 
 }

if(isset($_GET['action']) && $_GET['action'] == 'normal') {
$courseid = $_GET['course_id'];
$locationid = $_GET['location_id'];
$data['action'] = 'normal';
$data['courseid'] = $courseid;
$data['locationid'] = $locationid;


$ch = curl_init();
	//curl_setopt($ch,CURLOPT_URL,'http://inspireeducation.edu.au/learning28/course/course_wpevent.php');
	curl_setopt($ch,CURLOPT_URL, WP_Moodle_courseevent);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

	$response = curl_exec($ch);
	curl_close($ch);
	$respo = json_decode($response,true);
	// echo "<pre>";
	// print_r($respo);
	// echo "</pre>";
	
	if(!empty($respo['event'])) {
				echo '<div id="full_location_timetable_new" class="checkbox clearfix">';
				echo '<h5>Full Delivery Course location <abbr class="required" title="required">* </abbr></h5>';
				echo '<p class="text required" id="distance_learning_field_full">';
				echo '<label for="ccf_delivery_location_timetable_1" class="">Select 1st start date <abbr class="required" title="required">* </abbr></label><br>';
                echo '<select name="ccf_delivery_location_timetable_1[]" id="ccf_delivery_location_timetable_full_1" class="select text">';
				echo '<option value="">Please select your desired start date</option>';
				echo '__jaz__';
				foreach($respo['event'] as $keyevent=>$valueevent) {
					$eventid = $valueevent['event_id'];
					$productidds = gettingvalues($eventid,$locationid);
					$firstdate = explode(',',$valueevent['event_fulltimestart']);
					$enddate = explode(',',$valueevent['event_fulltimeduration']);
					$startdate = $firstdate[0];
					$starttime = $firstdate[1];
					$enddates = $enddate[0];
					$endtime = $enddate[1];
					$finaldatelocation = $startdate.' - '.$enddates.', '.$starttime.' - '.$endtime;
					// echo '<option value="'.date('d/m/Y',$valueevent['event_timestart']).'">' . $finaldatelocation . '</option>';
					if(count($productidds) < $valueevent['event_max_seat']) {
						echo '<option value="'.$eventid.'">' . $finaldatelocation . '</option>';
					}
				}
				echo "</select>";
				echo "</div>";
	}
	} else if (isset($_GET['action']) && $_GET['action'] == 'eventclass') {
		$courseid = $_GET['course_id'];
		$eventid = $_GET['eventid_id'];
		$data['action'] = 'classevent';
		$data['courseid'] = $courseid;
		$data['eventid'] = $eventid;

		$ch = curl_init();
		//curl_setopt($ch,CURLOPT_URL,'http://inspireeducation.edu.au/learning28/course/course_wpevent.php');
		curl_setopt($ch,CURLOPT_URL,WP_Moodle_courseevent);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

		$response = curl_exec($ch);
		curl_close($ch);
		$respos = json_decode($response,true); 
		$value = '';
		if(isset($respos['delivery_details'])) {
			$value .= '<option value="" selected>Please select your desired location</option>';
			foreach($respos['delivery_details'] as $key=>$respo) {
				$value .= '<option id="ccf_course_'. $key .'" value="'. $key .'">'. $respo['location'] .'</option>';
			}
		}
		echo $value;
	} else if(isset($_GET['action']) && $_GET['action'] == 'eventlocation') {
		$courseid = $_GET['course_id'];
		$eventid = $_GET['eventid_id'];
		$locationid = $_GET['location_id'];
		$data['action'] = 'eventlocation';
		$data['courseid'] = $courseid;
		$data['eventid'] = $eventid;
		$data['locationid'] = $locationid;
		$data['eventtype'] = $_GET['eventtype'];
		$ch = curl_init();
		//curl_setopt($ch,CURLOPT_URL,'http://inspireeducation.edu.au/learning28/course/course_wpevent.php');
		curl_setopt($ch,CURLOPT_URL, WP_Moodle_courseevent);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));

		$response = curl_exec($ch);
		//print_r($response);//die('ddddd');
		
		
		curl_close($ch);
		$respo = json_decode($response,true);
		$value = '';
		if($_GET['display'] == 'name'){
		$value .= '<option value="">Please select your desired event</option>';
		}else{
		$value .= '<option value="">Please select your desired start date</option>';
		}
		foreach($woocommerce->cart->get_cart() as $products){
		$ids[] = $products['product_id'];
		}
		 $date = date('d-m-Y');
           $cdate = strtotime($date); 
		   
		   $max_seat_check = get_post_meta($ids[0],'max_occupied_seats_',true);
		    $min_seat_check = get_post_meta($ids[0],'min_occupied_seats_',true);
			
			$mintime = ('+'.$min_seat_check*7).' day';
			$mindate = strtotime($mintime, $cdate);
			
		                                               
           $maxtime1 = ('+'.$max_seat_check*7).' day';
           $lastdate = strtotime($maxtime1, $cdate);		

			$cats = array();
            $_categories = get_the_terms( $ids[0], 'product_cat' );
                
            if (is_array($_categories) || is_object($_categories)) {
                foreach($_categories as $_category) {
                   $cats[$_category->term_id] = strtolower($_category->slug);
                        }
                    }
			if(in_array('last-minute-specials',$cats)) {
				$spacial = 'spacial';
			}else{
				$spacial = '';
			}

		 // echo '<pre>';
		//  echo $ids[0];
				//	print_r($respo);
								
		 
		foreach($respo['event'] as $keyevent=>$valueevent) {
			$eventid = $valueevent['event_id'];
			//$productidds = gettingvalues($eventid,$locationid);
			$firstdate = explode(',',$valueevent['event_fulltimestart']);
			$enddate = explode(',',$valueevent['event_fulltimeduration']);
			$startdate = $firstdate[0];
			$starttime = $firstdate[1];
			$enddates = $enddate[0];
			$endtime = $enddate[1];
			$name = $valueevent['event_name'];
			$finaldatelocation = $startdate.' - '.$enddates.', '.$starttime.' - '.$endtime;
			
			//print_r($valueevent);
			//if(count($productidds) < $valueevent['event_max_seat']) {
			$key = $valueevent['event_timestart'];
			//echo $respo['eventtype'];
			if($spacial == 'spacial'){
			
						if($key > $cdate && ($key < $lastdate || $key < $mindate) ){

                                    if($_GET['display'] == 'name'){
					
									$value .= '<option value="'.$eventid.'">' . $name . '</option>';
					
								}else{
									$value .= '<option value="'.$eventid.'">' . $finaldatelocation . '</option>';
						
										}

                        }
			}else{
					if($valueevent['event_countmember'] < $valueevent['event_max_seat'] ){
						
						if($_GET['display'] == 'name'){
					
						$value .= '<option value="'.$eventid.'">' . $name . '</option>';
					
					}else{
						$value .= '<option value="'.$eventid.'">' . $finaldatelocation . '</option>';
						
						}
					}
				}
		}

		echo $value;
	}
	
	function gettingvalues($eventid,$locationid) {
	require( './wp-load.php' );
	global $wpdb;
	$productidd = "SELECT * from {$wpdb->postmeta} WHERE meta_key = 'course-start-date-1' AND  meta_value = $eventid";
	return $wpdb->get_results($productidd, OBJECT);
	}