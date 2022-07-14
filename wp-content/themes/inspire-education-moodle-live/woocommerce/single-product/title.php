<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<?php if (is_shop()) { } else { ?>
	<span class="hidden" itemprop="brand">Inspire Education</span>
	<h1 itemprop="name" class="product_title entry-title">
		<?php the_title(); ?>
	</h1>
	<?php
	global $post;
	/* custom changes */
	global $wpdb;
	$_id = $post->ID;
	$cats = array();
	$_categories = get_the_terms( $post->ID, 'product_cat' );

	if (is_array($_categories) || is_object($_categories)) {
	    foreach($_categories as $_category) {
	        $cats[$_category->term_id] = strtolower($_category->slug);
	    }
	}

	$_metadata = get_post_meta($post->ID,'_sku',true);



	if(in_array('last-minute-specials',$cats)) {

	    $data['data'] = json_encode($_metadata);
	    $ch = curl_init();
	    curl_setopt($ch,CURLOPT_URL,WP_Moodle_specialevent);
	    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
	    curl_setopt($ch, CURLOPT_POST,1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($ch);
	    $_response = json_decode($response);
	    $_string = $_response->data;
	    $_strings = $_response->datas;
	    $_event = $_response->event_count;
	    $_event_details = $_response->events;
	    curl_close($ch);

	     $max_seat_check = get_post_meta($post->ID,'max_occupied_seats_',true);
	    $eventlist = get_object_vars($_strings);
	    ksort($eventlist, SORT_NUMERIC);
	    $exists = 0;
	    foreach ($eventlist as $keys =>  $eventname){
	    $next = explode('_',$keys);
	    $key = $next[0];
	        $date = date('d-m-Y');;
	        $cdate = strtotime($date);

	        $maxtime1 = ('+'.$max_seat_check*7).' day';
	        $lastdate = strtotime($maxtime1, $cdate);

	        if($key > $cdate && $key < $lastdate ){

	            $exists = 1;

	        }

	    }

	    //print "I am in last";
	    if( $_event > 0 && $exists == 1) {

	        $start_date = $_event_details->start_date;
	        $min_seat = $_event_details->min;
	        $max_seat = $_event_details->max;
	        $enrollcount = $_event_details->enrollcount;
	        $min_seat_check = get_post_meta($post->ID,'min_occupied_seats_',true);

	        //$enrolcount = isset( $final_products[$post->ID] ) ? $final_products[$post->ID] : 0;
	        $enrolcount = $enrollcount;
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

	       // if(($max_difference <= 0 || $min_difference <= 0) && ($enrolcount < $max_seat || $enrolcount < $min_seat)) {
	        if(($max_difference <= 0 || $min_difference <= 0) && ($_event_details->condition == 'match')) { ?>

				<div itemprop="description" class="tester-cont">
					<p>
						<?php
							$eventlist = get_object_vars($_strings);
							ksort($eventlist, SORT_NUMERIC);

							foreach ($eventlist as $keys => $eventname) {
							    $next = explode('_', $keys);
							    $key  = $next[0];
							    $date = date('d-m-Y');
							    ;
							    $cdate    = strtotime($date);
							    //echo'</br>';
							    $maxtime1 = ('+' . $max_seat_check * 7) . ' day';
							    $lastdate = strtotime($maxtime1, $cdate);

							    $mintime = ('+' . $min_seat_check * 7) . ' day';
							    $mindate = strtotime($mintime, $cdate);
							    //echo'</br>';
							    //echo $key .'event start';
							    // echo'</br>';
							    //echo 'last date:'. date('d-m-Y',$lastdate);
							    // echo'</br>';
							    //echo 'current date: '.date('d-m-Y',$cdate);
							    //echo'</br>';
							    //echo 'max week date: '.$max_seat_check;
							    //echo 'MIN week date: '.$min_seat_check;
							    if ($key > $cdate && ($key < $lastdate || $key < $mindate)) {

							        echo $eventname;

							    }
							    /* echo '<pre>';-
							    echo $course_start_date
							    print_r($_strings);
							    echo '</pre>'; */

							}

							//echo $_string;
							?>
					</p>

					<?php the_content(); ?>

				</div>

			<?php
			} // end if max difference

		} // end _event


	} else { /* custom changes end */ ?>

		<div itemprop="description" class="content">

			<?php the_content(); ?>

		</div>

	<?php } ?>
<?php } ?>
