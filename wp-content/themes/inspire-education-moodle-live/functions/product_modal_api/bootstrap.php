<?php
/**
 * Creates a json driven modal of all woo products.
 *
 * Replaces the old Product Modal routine that creates a lot(the amount that can freeze a view source tab) of html nodes
 * and makes curl connection/request for every(700++) product ...for each user ...everytime they refresh ...WHY!???!??!!
 *
 * Use do_action('inspire_generate_products_modal')
 * on pages where this feature is needed.
 */

require_once('async-task.php');
require_once('look-up-moodle-events.php');
require_once('endpoint.php');


function setup_async_moodle_event_lookup(){
	$Async_Event_Check = new Async_Moodle_Event_Check_Task();
	add_action( 'wp_async_lookup_moodle_events', 'lookup_moodle_events');
}

//setup the Async not any EARLIER than plugins_loaded
add_action( 'plugins_loaded ', 'setup_async_lookup_moodle_events' );

//Setup endpoint
add_action( 'rest_api_init', 'setup_products_modal_endpoint');

//Generate the base modal JS for page templates hooking unto inspire_generate_products_modal
add_action( 'inspire_generate_products_modal', 'setup_products_modal_JS');
