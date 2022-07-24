<?php
$args = ['pid'=>1,
					'year'=>'2023',
					'month'=>'1'];
ob_start();
	do_action( 'inspire_search_calendar',$args);
$action_data = ob_get_clean();

echo "\n" . $action_data . "\n";
