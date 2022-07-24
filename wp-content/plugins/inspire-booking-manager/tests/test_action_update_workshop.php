<?php
$args = ['pid'=>1,'s1'=>'2023-01-01 00:00','s2'=>'2023-01-01 24:00'];
ob_start();
	do_action( 'inspire_update_workshop',$args);
$action_data = ob_get_clean();

echo "\n" . $action_data . "\n";
