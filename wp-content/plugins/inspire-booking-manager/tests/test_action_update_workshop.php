<?php
$arg = 123;

ob_start();
	do_action( 'inspire_update_workshop',$arg);
$action_data = ob_get_clean();

echo "\n" . $action_data . "\n";