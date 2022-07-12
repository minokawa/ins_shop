<?php

header("Access-Control-Allow-Origin: https://www.inspireeducation.net.au");
$action =$_GET['action'];
		
		
		if($action == 'example_ajax_request'){
		    $id = $_GET['id'];
		    $sku_id = $_GET['sku_id'];
            $key = moodle_api_pop($id,$sku_id); 
         print_r($key);

		}
		
		
		function moodle_api_pop($id,$sku_id){ 
$service_url = "https://inspireeducation.edu.au/learning/get_api.php?action=userdata&userid=$id&skuid=$sku_id";
$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);			
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);		
			curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml;charset=utf-8"));
			curl_setopt($curl, CURLOPT_POST, true);			
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$response = json_decode($curl_response);
			//print_R($curl_response);
return $curl_response;  
//curl_close($curl);
}

?>
