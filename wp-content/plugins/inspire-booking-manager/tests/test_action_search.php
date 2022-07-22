<?php
$arg = 123;

ob_start();
	do_action( 'inspire_search_workshop_calendar',$arg);
$action_data = ob_get_clean();

echo "\n" . $action_data . "\n";
