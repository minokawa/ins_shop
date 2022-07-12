<?php

function lookup_moodle_events(WP_REST_Request $request){
	$ch = curl_init();
	$result = [];
	$last_minute_product_ids = $request->get_param('product_ids');

	curl_setopt($ch,CURLOPT_URL,WP_Moodle_specialevent);
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	foreach( $last_minute_product_ids as $post_id ) {
		$max_seat_check = get_post_meta( $post_id,'max_occupied_seats_',true);
		$min_seat_check = get_post_meta($post_id,'min_occupied_seats_',true);
		$data['data'] = json_encode(get_post_meta($post_id, '_sku',true));

		//Send request to Moodle special event api
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = json_decode(curl_exec($ch));

		//Grab event list from response, sort and save into cookie
		$eventlist = get_object_vars($response->datas);
		setcookie("eventCount", sizeof($eventlist) );
		ksort($eventlist, SORT_NUMERIC);

		//setup time ranges for event
		$date_now = strtotime(date('d-m-Y'));
		$maxtime1 = ('+'.$max_seat_check*7).' day';
		$lastdate = strtotime($maxtime1, $date_now);
		$mintime1 = ('+'.$min_seat_check*7).' day';
		$mintime = strtotime($mintime1, $date_now);

		$exists = 0;
		//event is marked $exist if date now is in valid date/time range.
		$exists_label = '';
		foreach ($eventlist as $keys =>  $eventname){
			$next = explode('_',$keys);
			$moodle_event_sched = $next[0];
			if(	$moodle_event_sched > $date_now && (	$moodle_event_sched < $lastdate || 	$moodle_event_sched < $mintime)){
				$exists = 1;
				$exists_label .= $eventname . ' <br/> ';
			}
		}

		$event = $response->event_count;
		$event_details = $response->events;
		if( $event > 0 && $exists == 1) {
			$start_date = $event_details->start_date;
			$min_seat = $event_details->min;
			$max_seat = $event_details->max;
			$enrollcount = $event_details->enrollcount;
			$min_seat_check = get_post_meta($post_id,'min_occupied_seats_',true);
			$date= date('Y-m-d');

			$mintime = ('-'.$min_seat_check*7).' day';
			$course_start_date = strtotime($mintime,$start_date);
			$minexpire = date('Y-m-d',$course_start_date);
			$mindatetime1 = new DateTime($date);
			$mindatetime2 = new DateTime($minexpire);
			$min_interval = $mindatetime1->diff($mindatetime2);
			$min_difference = (int)$min_interval->format('%R%a');

			$maxtime = ('-'.$max_seat_check*7).' day';
			$_course_start_date = strtotime($maxtime,$start_date);
			$maxexpire = date('Y-m-d',$_course_start_date);
			$maxdatetime1 = new DateTime($date);
			$maxdatetime2 = new DateTime($maxexpire);
			$max_interval = $maxdatetime1->diff($maxdatetime2);
			$max_difference = (int)$max_interval->format('%R%a');

			if(($max_difference <= 0 || $min_difference <= 0) && ($event_details->condition == 'match')) {
				$result[$post_id] = $exists_label;
			}
		}
	};

	return $result;

	curl_close($ch);
}
