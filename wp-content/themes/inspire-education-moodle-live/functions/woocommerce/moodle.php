<?php
	//Utility function to check if any of cart items are in a 'specific' list of category
	function is_cart_items_in_category($category_list) {
		global $woocommerce;
		$product_in_cart = false;
		foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
			$_product = $values['data'];
			$terms = get_the_terms( $_product->get_id(), 'product_cat' );
			foreach ($terms as $term) {
				$_categoryid = $term->term_id;
				if (in_array($_categoryid, $category_list)){
					$product_in_cart = true;
				}
			}
		}

		return $product_in_cart;
	}

	//Get acess key from Inspires Moodle server
	function get_jobready_key(){
		$service_url = jobready_api_url;
		$curl = curl_init($service_url);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, Array(
			"Content-Type: text/xml;charset=utf-8"
		));
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$curl_response = curl_exec($curl);
		$response = json_decode($curl_response);
		return $response;
		// curl_close($curl);
	}

	function submit_jobready_payload($service_url, $params) {
			global $DB;
			$key = get_jobready_key();
			$username = $key->username;
			$authorization = $key->authorization;
			$curl = curl_init($service_url);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, "$username:$authorization");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml;charset=utf-8"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$curl_response = curl_exec($curl);


			curl_close($curl);
			// $tmp_dir = wp_upload_dir() ;


			// file_put_contents($tmp_dir['basedir']. '/job_ready_response'.$unix_time.'.xml', $curl_response);
			return $curl_response;
	}

	function generate_jobready_payload($user_detail) {
		$ropdate = $user_detail['ccf_date_birth'];
 		$choice = array( 'AF' => 'Afghanistan', 'AX' => 'Aland Islands', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica', 'AG' => 'Antigua And Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia And Herzegovina', 'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil', 'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei Darussalam', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island', 'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo, Democratic Republic', 'CK' => 'Cook Islands', 'CR' => 'Costa Rica', 'CI' => 'Cote D\'Ivoire', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'ET' => 'Ethiopia', 'FK' => 'Falkland Islands (Malvinas)', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana', 'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece', 'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HM' => 'Heard Island & Mcdonald Islands', 'VA' => 'Holy See (Vatican City State)', 'HN' => 'Honduras', 'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran, Islamic Republic Of', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle Of Man', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KR' => 'Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Lao People\'s Democratic Republic', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libyan Arab Jamahiriya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MO' => 'Macao', 'MK' => 'Macedonia', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia, Federated States Of', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'AN' => 'Netherlands Antilles', 'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue', 'NF' => 'Norfolk Island', 'MP' => 'Northern Mariana Islands', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PS' => 'Palestinian Territory, Occupied', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland', 'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar', 'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russian Federation', 'RW' => 'Rwanda', 'BL' => 'Saint Barthelemy', 'SH' => 'Saint Helena', 'KN' => 'Saint Kitts And Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin', 'PM' => 'Saint Pierre And Miquelon', 'VC' => 'Saint Vincent And Grenadines', 'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'Sao Tome And Principe', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia And Sandwich Isl.', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SJ' => 'Svalbard And Jan Mayen', 'SZ' => 'Swaziland', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syrian Arab Republic', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga', 'TT' => 'Trinidad And Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TC' => 'Turks And Caicos Islands', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States of America', 'UM' => 'United States Outlying Islands', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VE' => 'Venezuela', 'VN' => 'Viet Nam', 'VG' => 'Virgin Islands, British', 'VI' => 'Virgin Islands, U.S.', 'WF' => 'Wallis And Futuna', 'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe', );

		$tt           = explode('/', $ropdate);
		$bir          = "$tt[2]-$tt[1]-$tt[0]";
		$usi          = $user_detail['ccf_usi_num'];
		$firstname    = $user_detail['billing_first_name'];
		$lastname     = $user_detail['billing_last_name'];
		$midname      = $user_detail['billing_middle_name'];
		$birth        = $bir;
		/*$gender       = $user_detail['ccf_gender']; */
		$gender       = ( in_array( strtolower($user_detail['ccf_gender']), array('male', 'female')) ) ? $user_detail['ccf_gender'] : "X";
		$address      = $user_detail['billing_pname'];
		$streetname   = $user_detail['billing_sname'];
		$postcode     = $user_detail['billing_postcode'];
		$state        = $user_detail['billing_state'];
		$country      = $user_detail['billing_country'];

		// $city      =  $user_detail['_billing_city'];
		$email        = $user_detail['billing_email'];
		$prior        = $user_detail['ccf_prior_edu'];
		$disability   = $user_detail['ccf_disability_toggle'];
		$language     = $user_detail['ccf_main_lang'];

		// $homelang  = $user_detail['ccf_lang_home'];
		$indigenous   = $user_detail['ccf_indig'];
		$school_level = $user_detail['ccf_school_level'];
		$mobile       = $user_detail['billing_work_phone'];
		$phone1       = $user_detail['billing_work_mobile'];
		$phone        = $user_detail['billing_home_phone'];
		$mobile2      = $user_detail['billing_mobile_phone'];
		$country      = $choice[$country];

		$phone = '';
		if (!empty($phone)) {
			$phone = '<contact-detail>
								<primary>false</primary>
								<value>' . $phone . '</value>
								<contact-type>Phone</contact-type>
								<location>Home</location>
							</contact-detail>';
		}

		$phone2 = '';
		if (!empty($mobile)) {
			$phone2 = '<contact-detail>
								<primary>false</primary>
								<value>' . $mobile . '</value>
								<contact-type>Phone</contact-type>
								<location>Work</location>
							</contact-detail>';
		}

		$phone3 = '';
		if (!empty($phone1)) {
			$phone3 = '<contact-detail>
								<primary>false</primary>
								<value>' . $phone1 . '</value>
								<contact-type>Mobile</contact-type>
								<location>Work</location>
							</contact-detail>';
		}

		$phone4 = '';
		if (!empty($mobile2)) {
			$phone4 = '<contact-detail>
								<primary>false</primary>
								<value>' . $mobile2 . '</value>
								<contact-type>Mobile</contact-type>
								<location>Home</location>
							</contact-detail>';
		}

		$subrub            = $user_detail['billing_city'];
		$cbirth            = $user_detail['ccf_country_birth'];
		$industry          = $user_detail['ccf_employed_industry'];
		$unitno            = $user_detail['billing_platno'];
		$streetno          = $user_detail['billing_lotno'];
		$syear             = $user_detail['ccf_school_higest_year'];
		$income            = $user_detail['ccf_yearly_income'];
		$internet          = $user_detail['ccf_internet_con'];
		$computer          = $user_detail['ccf_comp_skills'];
		$number            = $user_detail['ccf_num_ability'];
		$support           = $user_detail['ccf_support'];
		$login             = "$email";
		$postsubrub        = $user_detail['ccf_add_two_sub'];
		$poststate         = $user_detail['ccf_add_two_state'];
		$postcountry       = $user_detail['ccf_add_two_country'];
		$postpostcode      = $user_detail['ccf_add_two_post'];
		$postbuilding      = $user_detail['ccf_add_two_pname'];
		$postunit          = $user_detail['ccf_add_two_unumber'];
		$postdelibox       = $user_detail['ccf_add_two_pdbox'];
		$poststrretno      = $user_detail['ccf_add_two_lnumber'];
		$poststreetname    = $user_detail['ccf_add_two_sname'];
		$priorlearning     = $user_detail['ccf_learning_type'];
		$labourestatus     = $user_detail['employment-status'];
		$studylast         = $user_detail['ccf_school'];
		$ausresidency      = $user_detail['ccf_ausres'];
		$distance_start    = $user_detail['distance-start'];
		$ccf_employ_stat   = $user_detail['ccf_employ_stat'];
		$highest_level     = $user_detail['ccf_school_higest_year'];
		$school_name       = $user_detail['ccf_school_title'];

		if ($disability == 'Yes') { $disabilitytype = $user_detail['ccf_disability']; }
		if ($studylast == 'Yes') { $school_name = $user_detail['ccf_school_title']; }
		if ($prior == 'Yes') { $learninglast = $user_detail['ccf_formal']; }
		if ($support == 'Yes') { $supportspecify = $user_detail['additional-support-specify'];}

		$undereng = 'Very Well';

		if ($language == 'Not Stated') {
			$undereng = $user_detail['ccf_read'];
			$language = $user_detail['ccf_lang_home'];
		}

		$resonetaken        = $user_detail['ccf_reason_undertake'];
		$postal_st_address  = $postunit . ' ' . $poststrretno . ' ' . $poststreetname . '  ' . $postbuilding;
		$home_st_address    = $unitno . ' ' . $streetno . ' ' . $streetname . ' ' . $address;

		if(empty($poststreetname)){
			$poststreetname = 'not set';
		}

		$addressTwo = '';
		if ($postdelibox) {
			$addressTwo = '<address>
							<primary>false</primary>
							<street-address1>' . $postdelibox . '</street-address1>
							<street-address2 />
							<unit-type />
							<unit-number>' . $postunit . '</unit-number>
							<street-number>' . $poststrretno . '</street-number>
							<street-name>' . $poststreetname . '</street-name>
							<street-line>' . $postbuilding . '</street-line>
							<street-suffix>not set</street-suffix >
							<street-type>not set </street-type>
							<suburb>' . $postsubrub . '</suburb>
							<post-code>' . $postpostcode . '</post-code>
							<state>' . $poststate . '</state>
							<country>' . $postcountry . '</country>
							<location>Postal</location>
						</address>';
		}elseif ($poststate && $postcountry) {
			$addressTwo = '<address>
							<primary>false</primary>
							<street-address1>' . $postal_st_address . '</street-address1>
							<street-address2 />
							<unit-type />
							<unit-number>' . $postunit . '</unit-number>
							<street-number>' . $poststrretno . '</street-number>
							<street-name>' . $poststreetname . '</street-name>
							<street-line>' . $postbuilding . '</street-line>
							<street-suffix>not set</street-suffix >
							<street-type>not set </street-type>
							<suburb>' . $postsubrub . '</suburb>
							<post-code>' . $postpostcode . '</post-code>
							<state>' . $poststate . '</state>
							<country>' . $postcountry . '</country>
							<location>Postal</location>
						</address>';
		}


		$xml = '
					<?xml version="1.0" encoding="UTF-8"?>
					<party>
						<party-type>Person</party-type>
						<contact-method>Email</contact-method>
						<surname>' . $lastname . '</surname>
						<first-name>' . $firstname . '</first-name>
						<middle-name>' . $midname . '</middle-name>
						<birth-date>' . $birth . '</birth-date>
						<gender>' . $gender . '</gender>
						<usi-number>' . $usi . '</usi-number>
					<contact-details>
							<contact-detail>
								<primary>true</primary>
								<value>' . $email . '</value>
								<contact-type>Email</contact-type>
								<location>Home</location>
							</contact-detail>
							' . $phone . '
							' . $phone2 . '
							' . $phone3 . '
							' . $phone4 . '
							</contact-details>
						<avetmiss>
							<main-language>' . $language . '</main-language>
							<country-of-birth>' . $cbirth . '</country-of-birth>
							<disability-flag>' . $disability . '</disability-flag>
							<prior-education-flag>' . $prior . '</prior-education-flag>
							<labour-force-status>' . $ccf_employ_stat . '</labour-force-status>
							<year-highest-school-level>' . $highest_level . '</year-highest-school-level>
							<highest-school-level>' . $school_level . '</highest-school-level>
							<indigenous-status>' . $indigenous . '</indigenous-status>
							<employment-category>' . $ccf_employ_stat . '</employment-category>
							<at-school-flag>Yes</at-school-flag>
							<spoken-english-proficiency>' . $undereng . '</spoken-english-proficiency>
							<disabilities>
								<disability>
									<disability-type>' . $disabilitytype . '</disability-type>
								</disability>
							</disabilities>
				<prior-educations>
				';
		foreach($learninglast as $val) {
			$xml.= '
								<prior-education>
									<prior-education-type>' . $val . '</prior-education-type>
								</prior-education>';
		}

		$xml.= '
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
							<value>' . $undereng . '</value>
							</ad-hoc-field>
						</ad-hoc-fields>
					</party>';

		//file_put_contents('/home/li2/inspire/site/public_html_enrol/dev_log/payload_jobready.xml', $xml);
		//file_put_contents('/home/li2/inspire/site/public_html_enrol/dev_log/payload_woo.json', json_encode($user_detail));
		return $xml;
	}

	function build_jobready_api_request($user_detail){
		global $DB;
		$key = get_jobready_key();
		$host = $key->host;
		$params = generate_jobready_payload($user_detail);
		$service_url = "$host/parties/";
		$curl_response = submit_jobready_payload($service_url, $params);

		$var_id = substr(strstr($curl_response, 'fier>') , 5);
		$user = strstr($var_id, '<', true);
		$array = array();
		$array['id'] = $user;
		$array['error'] = $curl_response;
		return $array;

	}

		// THIS ROUTINE IS TRIGGERED WHEN USER IS STILL IN CHECKOUT PAGE
	add_action('woocommerce_checkout_order_processed', 'send_user_to_moodle', 10, 1);
	function send_user_to_moodle($order_id){
		// Check to see if the product in the cart is in one of the following categories...
		// 462 = Laptop Hire
		// 463 = Software
		// 466 = Desktop Computer Systems
		// 502 = Printed Course Materials
		// 472 = Course Extensions
		$category_list = array(462, 463, 466, 502, 472);

		if (!is_cart_items_in_category($category_list)) {
			global $wpdb;
			global $woocommerce;
			$identifier_id = build_jobready_api_request($_REQUEST);
			$customer_detail = array();
			$cus = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE ( post_id = '". $order_id ."')");
			foreach($cus as $custom){
				$meta_key = $custom->meta_key;
				$customer_detail[$meta_key] = $custom->meta_value;
			}
			$customer_detail['api_id'] = $identifier_id['id'];
			$data['customer'] = serialize($customer_detail);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, WP_Moodle_SSO);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
			$response = curl_exec($ch);
			curl_close($ch);
		}
	}

	//THIS ROUTINE IS TRIGGERED WHEN USER PAYMENT IS CONFIRMED

	add_action('woocommerce_order_status_completed', 'customer_detail_enrol', 10, 1);
	function customer_detail_enrol($order_id){

		global $wpdb;
		global $woocommerce;

		$product_in_order = false;
		$order = new WC_Order($order_id );
		$items = $order->get_items();

		foreach ( $items as $item ) {
			$terms = get_the_terms( $item['product_id'], 'product_cat' );
			foreach ($terms as $term) {
				$_categoryid = $term->term_id;
				if (($_categoryid == 462) || ($_categoryid == 463) || ($_categoryid == 466) || ($_categoryid == 502) || ($_categoryid == 472)) {
						$product_in_order = true;
				}
			}
		}

		if (!$product_in_order) {

			$customer_detail = array();
			$ord = $wpdb->get_results("SELECT * FROM wp_woocommerce_order_items WHERE ( order_id = '". $order_id ."')");

			foreach($ord as $orderss){
				$orde[] = $wpdb->get_results("SELECT ID FROM wp_posts WHERE ( post_title = '". $orderss->order_item_name ."')");
			}

			foreach($orde as $bb){
				foreach($bb as $aa){

					$prod_sku  = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE (meta_key = '_sku' AND post_id = '". $aa->ID ."')");

					$parsid = explode('-v-', $prod_sku[0]->meta_value);
					$prod_sku[0]->meta_value = $parsid[0];

					$ordeb[] = $prod_sku;

				}
			}



			$data['data'] = serialize($ordeb);
			$current_user = wp_get_current_user();

			if ( 0 == $current_user->ID ) {
					// Not logged in.
			} else {
					$cid = $current_user->ID;
			}

			$cus = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE ( post_id = '". $order_id ."')");

			foreach($cus as $custom){
				$meta_key = $custom->meta_key;
				$customer_detail[$meta_key] = $custom->meta_value;
			}

			$order = wc_get_order($order_id);
			$items = $order->get_items();
			$product_id = '';
			foreach ( $items as $item ) {
				$product_id .= $item['product_id'];
				$product = wc_get_product( $product_id );
				$sku = $product->get_sku();
			}

			$data['customer'] = serialize($customer_detail);
			$data['sku'] = serialize($sku);

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, WP_Moodle_SSO2);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);
			curl_setopt($ch, CURLOPT_POST,1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
			$response = curl_exec($ch);
			curl_close($ch);
		}

	}
