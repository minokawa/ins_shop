<?php

 function curl($service_url,$params){
	 global $DB;
	  $key = moodle_api();
    $username =$key->username;
	$authorization =$key->authorization;
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, "$username:$authorization");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			//"elementssupport1:c7c437e1358140926bd275a0b6ff7f85dc428350"
			curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml;charset=utf-8"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);
			$response = json_decode($curl_response);
			curl_close($curl);
		//print_r($curl_response);die;
 $to = 'kapil@virasatsolutions.com , ayush@virasatsolutions.com';
 $message = $curl_response;
 				@$subject="This Mail send from sso";
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";			
				$headers .= 'From: <'.$CFG->noreplyaddress.'>' . "\r\n";		
			
				//@mail($to,$subject,$message,$headers); 
		return $curl_response;  

			
	 }
	 /* $abc=call_xml($user_detail);
	 echo"<pre>";print_r($abc);die('okay'); */

      function call_xml($user_detail){
	  $ropdate = $user_detail['ccf_date_birth'];
	  	
		
		
		
	$choice = array
(
'AF' => 'Afghanistan',
'AX' => 'Aland Islands',
'AL' => 'Albania',
'DZ' => 'Algeria',
'AS' => 'American Samoa',
'AD' => 'Andorra',
'AO' => 'Angola',
'AI' => 'Anguilla',
'AQ' => 'Antarctica',
'AG' => 'Antigua And Barbuda',
'AR' => 'Argentina',
'AM' => 'Armenia',
'AW' => 'Aruba',
'AU' => 'Australia',
'AT' => 'Austria',
'AZ' => 'Azerbaijan',
'BS' => 'Bahamas',
'BH' => 'Bahrain',
'BD' => 'Bangladesh',
'BB' => 'Barbados',
'BY' => 'Belarus',
'BE' => 'Belgium',
'BZ' => 'Belize',
'BJ' => 'Benin',
'BM' => 'Bermuda',
'BT' => 'Bhutan',
'BO' => 'Bolivia',
'BA' => 'Bosnia And Herzegovina',
'BW' => 'Botswana',
'BV' => 'Bouvet Island',
'BR' => 'Brazil',
'IO' => 'British Indian Ocean Territory',
'BN' => 'Brunei Darussalam',
'BG' => 'Bulgaria',
'BF' => 'Burkina Faso',
'BI' => 'Burundi',
'KH' => 'Cambodia',
'CM' => 'Cameroon',
'CA' => 'Canada',
'CV' => 'Cape Verde',
'KY' => 'Cayman Islands',
'CF' => 'Central African Republic',
'TD' => 'Chad',
'CL' => 'Chile',
'CN' => 'China',
'CX' => 'Christmas Island',
'CC' => 'Cocos (Keeling) Islands',
'CO' => 'Colombia',
'KM' => 'Comoros',
'CG' => 'Congo',
'CD' => 'Congo, Democratic Republic',
'CK' => 'Cook Islands',
'CR' => 'Costa Rica',
'CI' => 'Cote D\'Ivoire',
'HR' => 'Croatia',
'CU' => 'Cuba',
'CY' => 'Cyprus',
'CZ' => 'Czech Republic',
'DK' => 'Denmark',
'DJ' => 'Djibouti',
'DM' => 'Dominica',
'DO' => 'Dominican Republic',
'EC' => 'Ecuador',
'EG' => 'Egypt',
'SV' => 'El Salvador',
'GQ' => 'Equatorial Guinea',
'ER' => 'Eritrea',
'EE' => 'Estonia',
'ET' => 'Ethiopia',
'FK' => 'Falkland Islands (Malvinas)',
'FO' => 'Faroe Islands',
'FJ' => 'Fiji',
'FI' => 'Finland',
'FR' => 'France',
'GF' => 'French Guiana',
'PF' => 'French Polynesia',
'TF' => 'French Southern Territories',
'GA' => 'Gabon',
'GM' => 'Gambia',
'GE' => 'Georgia',
'DE' => 'Germany',
'GH' => 'Ghana',
'GI' => 'Gibraltar',
'GR' => 'Greece',
'GL' => 'Greenland',
'GD' => 'Grenada',
'GP' => 'Guadeloupe',
'GU' => 'Guam',
'GT' => 'Guatemala',
'GG' => 'Guernsey',
'GN' => 'Guinea',
'GW' => 'Guinea-Bissau',
'GY' => 'Guyana',
'HT' => 'Haiti',
'HM' => 'Heard Island & Mcdonald Islands',
'VA' => 'Holy See (Vatican City State)',
'HN' => 'Honduras',
'HK' => 'Hong Kong',
'HU' => 'Hungary',
'IS' => 'Iceland',
'IN' => 'India',
'ID' => 'Indonesia',
'IR' => 'Iran, Islamic Republic Of',
'IQ' => 'Iraq',
'IE' => 'Ireland',
'IM' => 'Isle Of Man',
'IL' => 'Israel',
'IT' => 'Italy',
'JM' => 'Jamaica',
'JP' => 'Japan',
'JE' => 'Jersey',
'JO' => 'Jordan',
'KZ' => 'Kazakhstan',
'KE' => 'Kenya',
'KI' => 'Kiribati',
'KR' => 'Korea',
'KW' => 'Kuwait',
'KG' => 'Kyrgyzstan',
'LA' => 'Lao People\'s Democratic Republic',
'LV' => 'Latvia',
'LB' => 'Lebanon',
'LS' => 'Lesotho',
'LR' => 'Liberia',
'LY' => 'Libyan Arab Jamahiriya',
'LI' => 'Liechtenstein',
'LT' => 'Lithuania',
'LU' => 'Luxembourg',
'MO' => 'Macao',
'MK' => 'Macedonia',
'MG' => 'Madagascar',
'MW' => 'Malawi',
'MY' => 'Malaysia',
'MV' => 'Maldives',
'ML' => 'Mali',
'MT' => 'Malta',
'MH' => 'Marshall Islands',
'MQ' => 'Martinique',
'MR' => 'Mauritania',
'MU' => 'Mauritius',
'YT' => 'Mayotte',
'MX' => 'Mexico',
'FM' => 'Micronesia, Federated States Of',
'MD' => 'Moldova',
'MC' => 'Monaco',
'MN' => 'Mongolia',
'ME' => 'Montenegro',
'MS' => 'Montserrat',
'MA' => 'Morocco',
'MZ' => 'Mozambique',
'MM' => 'Myanmar',
'NA' => 'Namibia',
'NR' => 'Nauru',
'NP' => 'Nepal',
'NL' => 'Netherlands',
'AN' => 'Netherlands Antilles',
'NC' => 'New Caledonia',
'NZ' => 'New Zealand',
'NI' => 'Nicaragua',
'NE' => 'Niger',
'NG' => 'Nigeria',
'NU' => 'Niue',
'NF' => 'Norfolk Island',
'MP' => 'Northern Mariana Islands',
'NO' => 'Norway',
'OM' => 'Oman',
'PK' => 'Pakistan',
'PW' => 'Palau',
'PS' => 'Palestinian Territory, Occupied',
'PA' => 'Panama',
'PG' => 'Papua New Guinea',
'PY' => 'Paraguay',
'PE' => 'Peru',
'PH' => 'Philippines',
'PN' => 'Pitcairn',
'PL' => 'Poland',
'PT' => 'Portugal',
'PR' => 'Puerto Rico',
'QA' => 'Qatar',
'RE' => 'Reunion',
'RO' => 'Romania',
'RU' => 'Russian Federation',
'RW' => 'Rwanda',
'BL' => 'Saint Barthelemy',
'SH' => 'Saint Helena',
'KN' => 'Saint Kitts And Nevis',
'LC' => 'Saint Lucia',
'MF' => 'Saint Martin',
'PM' => 'Saint Pierre And Miquelon',
'VC' => 'Saint Vincent And Grenadines',
'WS' => 'Samoa',
'SM' => 'San Marino',
'ST' => 'Sao Tome And Principe',
'SA' => 'Saudi Arabia',
'SN' => 'Senegal',
'RS' => 'Serbia',
'SC' => 'Seychelles',
'SL' => 'Sierra Leone',
'SG' => 'Singapore',
'SK' => 'Slovakia',
'SI' => 'Slovenia',
'SB' => 'Solomon Islands',
'SO' => 'Somalia',
'ZA' => 'South Africa',
'GS' => 'South Georgia And Sandwich Isl.',
'ES' => 'Spain',
'LK' => 'Sri Lanka',
'SD' => 'Sudan',
'SR' => 'Suriname',
'SJ' => 'Svalbard And Jan Mayen',
'SZ' => 'Swaziland',
'SE' => 'Sweden',
'CH' => 'Switzerland',
'SY' => 'Syrian Arab Republic',
'TW' => 'Taiwan',
'TJ' => 'Tajikistan',
'TZ' => 'Tanzania',
'TH' => 'Thailand',
'TL' => 'Timor-Leste',
'TG' => 'Togo',
'TK' => 'Tokelau',
'TO' => 'Tonga',
'TT' => 'Trinidad And Tobago',
'TN' => 'Tunisia',
'TR' => 'Turkey',
'TM' => 'Turkmenistan',
'TC' => 'Turks And Caicos Islands',
'TV' => 'Tuvalu',
'UG' => 'Uganda',
'UA' => 'Ukraine',
'AE' => 'United Arab Emirates',
'GB' => 'United Kingdom',
'US' => 'United States',
'UM' => 'United States Outlying Islands',
'UY' => 'Uruguay',
'UZ' => 'Uzbekistan',
'VU' => 'Vanuatu',
'VE' => 'Venezuela',
'VN' => 'Viet Nam',
'VG' => 'Virgin Islands, British',
'VI' => 'Virgin Islands, U.S.',
'WF' => 'Wallis And Futuna',
'EH' => 'Western Sahara',
'YE' => 'Yemen',
'ZM' => 'Zambia',
'ZW' => 'Zimbabwe',
);

		
		$tt=explode('/',$ropdate);
		$bir="$tt[2]-$tt[1]-$tt[0]";
	 
	  $usi        = $user_detail['ccf_usi_num'];
	 $firstname  = $user_detail['billing_first_name'];
	 $lastname   = $user_detail['billing_last_name']; 
	 $midname   = $user_detail['billing_middle_name'];
	 $birth		 =  $bir;
	 $gender     = $user_detail['ccf_gender']; 
	 $address     =$user_detail['billing_pname'];
	 $streetname   = $user_detail['billing_sname'];
	 $postcode    = $user_detail['billing_postcode'];
	 $state       = $user_detail['billing_state'];
	 $country     = $user_detail['billing_country'];
	 //$city        =  $user_detail['_billing_city'];
	 $email       = $user_detail['billing_email']; 
	 
	 $prior       =$user_detail['ccf_prior_edu'];
	 $disability  =$user_detail['ccf_disability_toggle'];
	 $language    = $user_detail['ccf_main_lang'];
	// $homelang    = $user_detail['ccf_lang_home'];
	 $indigenous  = $user_detail['ccf_indig'];	
	 $school_level = $user_detail['ccf_school_level'];
	 $mobile       =$user_detail['billing_work_phone'];
	 $mobile2       =$user_detail['billing_work_mobile'];
	 $phone       = $user_detail['billing_home_phone'];
	 $phone1       = $user_detail['billing_mobile_phone'];
	 $country       = $choice[$country];
   //  $state       = $stateval[$state];
	// print_r($state);
	if(!empty($phone)){
	
	       $phone='<contact-detail>
              <primary>false</primary>
              <value>'. $phone .'</value>
              <contact-type>Phone</contact-type>
              <location>Home</location>
            </contact-detail>';
		 	 
	}else{
	$phone = '';
	
	}
	 
	 
	 if(!empty($mobile)){
	  $phone2='<contact-detail>
              <primary>false</primary>
              <value>'. $mobile .'</value>
              <contact-type>Phone</contact-type>
              <location>Work</location>
            </contact-detail>';
	 }else{
	 $phone2 = '';
	 
	 }
	 if(!empty($phone1)){
	 $phone3='<contact-detail>
              <primary>false</primary>
              <value>'. $phone1 .'</value>
              <contact-type>Phone</contact-type>
              <location>Work</location>
            </contact-detail>';
	 }else{
	$phone3 = '';
	
	}
	 
	 if(!empty($mobile2)){
	 $phone4='<contact-detail>
              <primary>false</primary>
              <value>'. $mobile2 .'</value>
              <contact-type>Mobile</contact-type>
              <location>Work</location>
            </contact-detail>';
	 
	 }else{
		$phone4 = '';
	
	}
	
	
	 $subrub       = $user_detail['billing_city'];
	 $cbirth       = $user_detail['ccf_country_birth'];
	 $industry     =  $user_detail['ccf_employed_industry'];
	  $unitno     =  $user_detail['billing_platno'];
	 
	  
	  $streetno     =  $user_detail['billing_lotno'];
	  	  $syear     =  $user_detail['ccf_school_higest_year'];
		  $income     =  $user_detail['ccf_yearly_income'];
		  $internet     =  $user_detail['ccf_internet_con'];
		  $computer     =  $user_detail['ccf_comp_skills'];
		  $number     =  $user_detail['ccf_num_ability'];
		  $support     =  $user_detail['ccf_support'];
		  $login =          "$email";
		  $postsubrub     =  $user_detail['ccf_add_two_sub'];
	  	  $poststate     =  $user_detail['ccf_add_two_state'];
		  $postcountry =  $user_detail['ccf_add_two_country'];
		  $postpostcode     =  $user_detail['ccf_add_two_post'];
		  $postbuilding     =  $user_detail['ccf_add_two_pname'];
		  $postunit     =  $user_detail['ccf_add_two_unumber'];
		  $postdelibox     =  $user_detail['ccf_add_two_pdbox'];
		  $poststrretno     =  $user_detail['ccf_add_two_lnumber'];
		   $poststreetname     =  $user_detail['ccf_add_two_sname'];		 
		   $priorlearning     =  $user_detail['ccf_learning_type'];
		    $labourestatus     =  $user_detail['employment-status'];
		    $studylast     =  $user_detail['ccf_school'];
		   $ausresidency     =  $user_detail['ccf_ausres'];
		   $distance_start     =  $user_detail['distance-start'];
		   $ccf_employ_stat     =  $user_detail['ccf_employ_stat'];
		   $highest_level     =  $user_detail['ccf_school_higest_year'];
		   $school_name     =  $user_detail['ccf_school_title'];
		  
		   
		  // print_r($poststate);
		   if($disability =='Yes'){
		    $disabilitytype     =  $user_detail['ccf_disability'];
		  }if($studylast =='Yes'){
		    $school_name     =  $user_detail['ccf_school_title'];
		  }
		   if($prior =='Yes'){
			   $learninglast     =  $user_detail['ccf_formal'];
		  }
		   if($support =='Yes'){
		    $supportspecify     =  $user_detail['additional-support-specify'];
		  }
		   if($language =='Not Stated'){		 
		    $undereng     =  $user_detail['ccf_read'];
			$language    = $user_detail['ccf_lang_home'];
		   }else{
		   $undereng ='Very Well';
		   }
		    $resonetaken     =  $user_detail['ccf_reason_undertake'];
			
			/* if($studylast =='Yes'){
		   $myschoolname = '<school>'.$school.'</school>';
		  }else{
		  $myschoolname = '';
		  } */
	//$xml='';	  
	/* $xml .= "<?xml version='1.0' encoding='UTF-8'?>
		<party>
		<party-identifier></party-identifier>
		<party-type>Person</party-type>
		<contact-method>Letter</contact-method>
		<usi-number>$usi</usi-number>
		<usi-status></usi-status>
		<surname>$lastname</surname>
		<first-name>$firstname</first-name>
		<middle-name>$midname</middle-name>
		<birth-date>$birth</birth-date>
		<gender>$gender</gender>
			<addresses>
				<address>
				<primary>true</primary>
				<street-address1>$address</street-address1>			
				<unit-type></unit-type>
				<unit-number>$unitno</unit-number>
				<street-number>$streetno</street-number>
				<street-name>$streetname</street-name>
				<street-line>$address</street-line>
				<street-suffix></street-suffix>
				<street-type></street-type>
				<suburb>$subrub</suburb>
				<post-code>$postcode</post-code>
				<state>$state</state>
				<country></country>
				<location>Home</location>								
				</address>";
				if(!empty($postbuilding)){
					$xml .= "<address>
					<primary>false</primary>
					<street-address2>$postbuilding</street-address2>				
					<unit-type></unit-type>
					<unit-number>$postunit</unit-number>
					<street-number>$poststrretno</street-number>
					<street-name>$poststreetname</street-name>
					<street-line>$postbuilding</street-line>
					<street-suffix></street-suffix>
					<street-type></street-type>
					<suburb>$postsubrub</suburb>
					<post-code>$postpostcode</post-code>
					<state>$poststate</state>
					<country></country>
					<location>Postal</location>								
					</address>";
					}
			$xml .= "</addresses>
		<known-by></known-by>
		<title></title>
		<login>$email</login>
		<password></password>
		<password-temporary></password-temporary>
		<logon-enabled>true</logon-enabled>
				<contact-details>
						<contact-detail>
						<primary>true</primary>
						<value>$email</value>
						<contact-type>Email</contact-type>
						<location>Home</location>
						</contact-detail>
				<contact-detail>
				<primary>true</primary>
				<value>$phone</value>
				<contact-type>Phone</contact-type>
				<location>Home</location>
				</contact-detail>
						<contact-detail>
						<primary>false</primary>
						<value>$mobile</value>
						<contact-type>Phone</contact-type>
						<location>work</location>
						</contact-detail>
						<contact-detail>
				<primary>true</primary>
				<value>$phone1</value>
				<contact-type>mobile</contact-type>
				<location>Home</location>
				</contact-detail>
						<contact-detail>
						<primary>false</primary>
						<value>$mobile1</value>
						<contact-type>mobile</contact-type>
						<location>work</location>
						</contact-detail>
				</contact-details>
		<avetmiss>
			<prior-education-flag>$prior</prior-education-flag>
			<labour-force-status>$ccf_employ_stat</labour-force-status>
			<year-highest-school-level>$syear</year-highest-school-level>
			<disability-flag>$disability</disability-flag>
				<disabilities>
					<disability>
					<disability-type>$disabilitytype</disability-type>
					</disability>
				</disabilities>
			<main-language>$language</main-language>
			<spoken-english-proficiency>$undereng</spoken-english-proficiency>
			<country-of-birth>$cbirth</country-of-birth>
			<indigenous-status>$indigenous</indigenous-status>
			<at-school-flag>$studylast</at-school-flag>
			<school>$school</school>
			<highest-school-level>$school_level</highest-school-level>
			<prior-educations>				
				<prior-education>
					<prior-education-type>$learninglast</prior-education-type>
				</prior-education>
			</prior-educations>
		</avetmiss>
		<ad-hoc-fields>
<ad-hoc-field>
<name>Current yearly household income?</name>
<value>$income </value>
</ad-hoc-field>
<ad-hoc-field>
<name>Industry currently employed in?</name>
<value>$industry</value>
</ad-hoc-field>
<ad-hoc-field>
<name>How well do you speak English?</name>
<value>$undereng</value>
</ad-hoc-field>
<ad-hoc-field>
<name>Do you have access to a computer with internet</name>
<value>$internet</value>
</ad-hoc-field>
<ad-hoc-field>
<name>How do you rate your computer skills</name>
<value>$computer</value>
</ad-hoc-field>
<ad-hoc-field>
<name>How do you rate your ability to work with numbers</name>
<value>$number</value>
</ad-hoc-field>
<ad-hoc-field>
<name>Do you need any additional support?</name>
<value>$support</value>
</ad-hoc-field>
<ad-hoc-field>
<name>Student's reason for doing the course:</name>
<value>$resonetaken</value>
</ad-hoc-field>
<ad-hoc-field>
<name>Do you want RPL?</name>
<value>$priorlearning</value>
</ad-hoc-field>
<ad-hoc-field>
<name>Distance Course Start Date</name>
<value>$distance_start</value>
</ad-hoc-field>
</ad-hoc-fields>
		</party>";
		
		  /// my changes /////  
		   $usi        = $user_detail['ccf_usi_num'];
	 $firstname  = $user_detail['billing_first_name'];
	 $lastname   = $user_detail['billing_last_name']; 
	 $midname   = $user_detail['billing_middle_name'];
	 $birth		 =  $bir;
	 $gender     = $user_detail['ccf_gender']; 
	 $address     =$user_detail['billing_pname'];
	 $streetname   = $user_detail['billing_sname'];
	 $postcode    = $user_detail['billing_postcode'];
	 $state       = $user_detail['billing_state'];
	 $country     = $user_detail['billing_country'];
	 //$city        =  $user_detail['_billing_city'];
	 $email       = $user_detail['billing_email']; 
	 $phone       = $user_detail['billing_home_phone'];
	 $phone1       = $user_detail['billing_mobile_phone'];
	 $prior       =$user_detail['ccf_prior_edu'];
	 $disability  =$user_detail['ccf_disability_toggle'];
	 $language    = $user_detail['ccf_main_lang'];
	 $indigenous  = $user_detail['ccf_indig'];	
	 $school_level = $user_detail['ccf_school_level'];
	 $mobile       =$user_detail['billing_work_phone'];
	 $mobile1       =$user_detail['billing_work_mobile'];
	 $subrub       = $user_detail['billing_city'];
	 $cbirth       = $user_detail['ccf_country_birth'];
	 $industry     =  $user_detail['ccf_employed_industry'];
	  $unitno     =  $user_detail['billing_platno'];
	 
	  $learninglast     =  $user_detail['last-formal-learning-0'];
	  $streetno     =  $user_detail['billing_lotno'];
	  	  $syear     =  $user_detail['ccf_school_higest_year'];
		  $income     =  $user_detail['ccf_yearly_income'];
		  $internet     =  $user_detail['ccf_internet_con'];
		  $computer     =  $user_detail['ccf_comp_skills'];
		  $number     =  $user_detail['ccf_num_ability'];
		  $support     =  $user_detail['ccf_support'];
		  $login =          "$email";
		  $postsubrub     =  $user_detail['ccf_add_two_sub'];
	  	  $poststate     =  $user_detail['ccf_add_two_state'];
		  $postpostcode     =  $user_detail['ccf_add_two_post'];
		  $postbuilding     =  $user_detail['ccf_add_two_pname'];
		  $postunit     =  $user_detail['ccf_add_two_unumber'];
		  $postdelibox     =  $user_detail['ccf_add_two_pdbox'];
		  $poststrretno     =  $user_detail['ccf_add_two_lnumber'];
		   $poststreetname     =  $user_detail['ccf_add_two_sname'];		 
		   $priorlearning     =  $user_detail['ccf_learning_type'];
		    $labourestatus     =  $user_detail['employment-status'];
		    $studylast     =  $user_detail['ccf_school'];
		   $ausresidency     =  $user_detail['ccf_ausres'];
		   $distance_start     =  $user_detail['distance-start'];
		   
		   if($disability =='Yes'){
		    $disabilitytype     =  $user_detail['ccf_disability'];
		  }if($studylast =='Yes'){
		    $school     =  $user_detail['ccf_school_title'];
		  }
		   if($support =='Yes'){
		    $supportspecify     =  $user_detail['additional-support-specify'];
		  }
		   if($language =='Not Stated'){		 
		    $undereng     =  $user_detail['ccf_read'];
		   }else{
		   $undereng ='Very Well';
		   }
		    $resonetaken     =  $user_detail['ccf_reason_undertake'];
		  
		  
		   */
		  
		
		$postal_st_address = $postunit.' '.$poststrretno.' '.$poststreetname.'  '.$postbuilding;
		$home_st_address = $unitno.' '.$streetno.' '.$streetname.' '.$address;
		  //print_r($home_st_address);
		  //print_r($postal_st_address);
		 // Variable to hold second address
        if ($poststreetname && $postdelibox) {
          $addressTwo = '<address>
            <primary>false</primary>
            <street-address1>' . $postdelibox . '</street-address1>
            <street-address2 />
			<unit-type />
			<unit-number>'.$postunit.'</unit-number>
			<street-number>'.$poststrretno.'</street-number>
			<street-name>'.$poststreetname.'</street-name>
			<street-line>'.$postbuilding.'</street-line>
			<street-suffix />
			<street-type />
            <suburb>'. $postsubrub .'</suburb>
            <post-code>'. $postpostcode .'</post-code>
            <state>'. $poststate .'</state>
            <country>'. $postcountry .'</country>
            <location>Postal</location>
          </address>';
        } elseif($poststreetname) {
		  $addressTwo = '<address>
            <primary>false</primary>
            <street-address1>' . $postal_st_address . '</street-address1>
            <street-address2 />
			<unit-type />
			<unit-number>'.$postunit.'</unit-number>
			<street-number>'.$poststrretno.'</street-number>
			<street-name>'.$poststreetname.'</street-name>
			<street-line>'.$postbuilding.'</street-line>
			<street-suffix />
			<street-type />
            <suburb>'. $postsubrub .'</suburb>
            <post-code>'. $postpostcode .'</post-code>
            <state>'. $poststate .'</state>
            <country>'. $postcountry .'</country>
            <location>Postal</location>
          </address>';
        } else{
          $addressTwo = '';
        }
     //print_r($addressTwo);die;
      
        // Variable to hold all enrolment xml
        $xml = '
        <?xml version="1.0" encoding="UTF-8"?>
        <party>
          <party-type>Person</party-type>
          <contact-method>Email</contact-method>
          <surname>'. $lastname .'</surname>
          <first-name>'. $firstname .'</first-name>
          <middle-name>'. $midname .'</middle-name>
          <birth-date>'. $birth .'</birth-date>
          <gender>'. $gender .'</gender>
          <usi-number>'. $usi .'</usi-number>
        <addresses>
          <address>
            <primary>true</primary>
            <street-address1>' . $home_st_address . '</street-address1>
            <street-address2 />
			<unit-type />
			<unit-number>'.$unitno.'</unit-number>
			<street-number>'.$streetno.'</street-number>
			<street-name>'.$streetname.'</street-name>
			<street-line>'.$address.'</street-line>
			<street-suffix />
			<street-type />
            <suburb>'. $subrub .'</suburb>
            <post-code>'. $postcode .'</post-code>
            <state>'. $state .'</state>
            <country>'. $country .'</country>
            <location>Home</location>
          </address>
          '.$addressTwo.'
        </addresses>
        <contact-details>
            <contact-detail>
              <primary>true</primary>
              <value>'. $email .'</value>
              <contact-type>Email</contact-type>
              <location>Home</location>
            </contact-detail>
             '.$phone.'
			 '.$phone2.'
			 '.$phone3.'
			 '.$phone4.'
          </contact-details>
          <avetmiss>
            <main-language>'. $language .'</main-language>
			<country-of-birth>'. $cbirth .'</country-of-birth>
            <disability-flag>' . $disability . '</disability-flag>
            <prior-education-flag>'. $prior .'</prior-education-flag>
			<labour-force-status>'.$ccf_employ_stat.'</labour-force-status>
            <at-school-flag>' . $studylast . '</at-school-flag>
            <school>' . $school_name . '</school>
			<year-highest-school-level>' . $highest_level . '</year-highest-school-level>
			
            <highest-school-level>' . $school_level . '</highest-school-level>
            <indigenous-status>' . $indigenous . '</indigenous-status>
            <employment-category>' . $ccf_employ_stat . '</employment-category>
            <at-school-flag>Yes</at-school-flag>
            <spoken-english-proficiency>'. $undereng .'</spoken-english-proficiency>
            <disabilities>
              <disability>
                <disability-type>' . $disabilitytype . '</disability-type>
              </disability>
            </disabilities>
			<prior-educations>
			';
			foreach($learninglast as $val){
					$xml .= '
              <prior-education>
                <prior-education-type>'. $val .'</prior-education-type>
              </prior-education>';
			}
           $xml .='
		   </prior-educations>
          </avetmiss>
          <ad-hoc-fields>
            <ad-hoc-field>
              <name>Do you have access to a computer with internet</name>
              <value>' . $internet . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>How do you rate your computer skills</name>
              <value>' . $computer . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>How do you rate your ability to work with numbers</name>
              <value>' . $number . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Do you need any additional support?</name>
              <value>' . $support . '</value>
            </ad-hoc-field>
			<ad-hoc-field>
			<name>If yes, please specify:</name>
			<value>' . $supportspecify . '</value>
			</ad-hoc-field>
            
          
            <ad-hoc-field>
              <name>Distance Course Start Date</name>
              <value>' . $distance_start . '</value>
            </ad-hoc-field>
          
            
            <ad-hoc-field>
              <name>Student\'s reason for doing the course:</name>
              <value>' . $resonetaken . '</value>
            </ad-hoc-field>
            
            <ad-hoc-field>
              <name>Current yearly household income?</name>
              <value>' . $income . '</value>
            </ad-hoc-field>
            <ad-hoc-field>
              <name>Industry currently employed in?</name>
              <value>' . $industry . '</value>
            </ad-hoc-field>

            <ad-hoc-field>
              <name>Do you want RPL?</name>
              <value>' . $priorlearning . '</value>
            </ad-hoc-field>
          
		  
		  <ad-hoc-field>
			<name>How well do you speak English?</name>
			<value>'.$undereng.'</value>
			</ad-hoc-field>
					  
		  
		  
          
          </ad-hoc-fields>
        </party>';   



        ///////my changes end //////
		
		
//echo '<pre>';print_r($xml);die('jobready_woo');
	//print_r(htmlspecialchars($xml));	 
return $xml;

}





















