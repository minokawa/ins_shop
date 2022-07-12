
<?php
/**
    * Step 2 - Employer Details
    **/
    echo '<div class="checkbox company-invoice-toggle">
            <h5 class="no-margin">Do you require a company invoice?</h5>
            <p class="form-row full" id="shiptobilling">
              <input id="shiptobilling-checkbox" class="input-checkbox" type="checkbox" name="shiptobilling"/>
              <label for="shiptobilling-checkbox" class="checkbox">If yes, please check this box to enter company details</label>
            </p>
          </div>';

    echo '<div class="shipping_address  shipping-address-group">
            <h3 class="no-margin">Company Details</h3>
            <h5 class="no-margin form-title">Please enter company information below. <span><strong>Only do so if you require a company invoice</strong></span></h5>';

            // First Name
            woocommerce_form_field( 'ccf_comp_name_1', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_name_1'),
                'label'         => __('First Name'),
                'placeholder'         => __('Joe'),
            ), $checkout->get_value( 'ccf_comp_name_1' ));

            // Last Name
            woocommerce_form_field( 'ccf_comp_name_2', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_name_2'),
                'label'         => __('Last Name'),
                'placeholder'         => __('Bloggs'),
            ), $checkout->get_value( 'ccf_comp_name_2' ));

            // Company Address 1
            woocommerce_form_field( 'ccf_comp_add_1', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_add_1'),
                'label'         => __('Address'),
                'placeholder'         => __('eg: Level 10, 243 Edward Street'),
            ), $checkout->get_value( 'ccf_comp_add_1' ));

            // Company Address 2
            woocommerce_form_field( 'ccf_comp_add_sub', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_add_sub'),
                'label'         => __('Town / City'),
                'placeholder'         => __('eg: Brisbane'),
            ), $checkout->get_value( 'ccf_comp_add_sub' ));

            // State
            woocommerce_form_field( 'ccf_comp_add_state', array(
                'type'          => 'select',
                'required'  => false,
                'class'         => array('text'),
                'label'         => __('State'),
		            'placeholder'       => __('Select state ...'),
                'options'     => array(
		              '' => __('Select state...', 'woocommerce' ),
                  'ACT' => __('ACT', 'woocommerce' ),
                  'New South Wales' => __('New South Wales', 'woocommerce' ),
                  'Northern Territory' => __('Northern Territory', 'woocommerce' ),
                  'Queensland' => __('Queensland', 'woocommerce' ),
                  'South Australia' => __('South Australia', 'woocommerce' ),
                  'Tasmania' => __('Tasmania', 'woocommerce' ),
                  'Victoria' => __('Victoria', 'woocommerce' ),
                  'Western Australia' => __('Western Australia', 'woocommerce' )
                ),
            ), $checkout->get_value( 'ccf_comp_add_state' ));

            // Post Code
            woocommerce_form_field( 'ccf_comp_add_post', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_add_post'),
                'label'         => __('Postcode'),
                'placeholder'         => __('eg: 4012'),
            ), $checkout->get_value( 'ccf_comp_add_post' ));

            // Email
            woocommerce_form_field( 'ccf_comp_cont_email', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_cont_email'),
                'label'         => __('Contact\'s Email'),
                'placeholder'         => __('eg: joeb@bloggs.com'),
            ), $checkout->get_value( 'ccf_comp_cont_email' ));

            // Phone
            woocommerce_form_field( 'ccf_comp_cont_phone', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_cont_phone'),
                'label'         => __('Phone Number'),
                'placeholder'         => __('eg: 1234567890'),
            ), $checkout->get_value( 'ccf_comp_cont_phone' ));

            // Company Name
            woocommerce_form_field( 'ccf_comp_name', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_name'),
                'label'         => __('Company Name')
            ), $checkout->get_value( 'ccf_comp_name' ));

            // ABN
            woocommerce_form_field( 'ccf_comp_abn', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_comp_abn'),
                'label'         => __('ABN'),
                'placeholder'         => __('Employers ABN number'),
            ), $checkout->get_value( 'ccf_comp_abn' ));

    echo '</div>';

    /**
    * Step 2 - Personal Details
    **/

        // Fieldset and header html opened in woocommerce/checkout/form-checkout.php

    echo '<div class="extra-details-group">';
	$country_options = get_woo_country_options();
	$def_country =  $checkout->get_value( 'ccf_country_birth' )?  $checkout->get_value( 'ccf_country_birth' ) : 'AU';
        woocommerce_form_field( 'ccf_country_birth', array(
            	'type'          => 'select',
            	'required'  => true,
            	'class'         => array('text required'),
        	'label'         => __('Country of Birth'),
		'options'     =>  $country_options,
		'default'     =>  'AU',
        ), $def_country );

        // Date of Birth
        woocommerce_form_field( 'ccf_date_birth', array(
            'type'          => 'text',
            'required'  => true,
            'class'         => array('text required ccf_date_birth'),
            'label'         => __('Date of Birth - dd/mm/yyyy'),
            'placeholder'         => __('eg: dd/mm/yyyy'),
        ), $checkout->get_value( 'ccf_date_birth' ));

        echo '<div class="checkbox clearfix gender_field_wrapper"><h5>What gender are you? <abbr class="required" title="required">*</abbr></h5>';

        woocommerce_form_field( 'ccf_gender', array(
          'type' => 'select',
          'label' => __( '' ),
          'placeholder' => __( '' ),
          'required' => true,
          'options' => array(
          '' => 'Select',
          'Male' => 'Male',
          'Female' => 'Female',
          'Non-Binary' => 'Non-Binary',
          'Transgender' => 'Transgender',
          'Intersex' => 'Intersex',
          'I prefer not to say' => 'I prefer not to say',
          "I don't know" => "I don't know",
          'Other' => 'Other'
       )), $checkout->get_value( 'ccf_gender' ) );

        echo '</div>';

        echo '<div class="checkbox clearfix residency_field_wrapper"><h5>Are you an Australian resident? <abbr class="required" title="required">*</abbr></h5>';

        // AUSTRALIAN RESIDENT
        woocommerce_form_field_radio( 'ccf_ausres', array(
            'type' => 'select',
            'label' => __( '' ),
            'placeholder' => __( '' ),
            'required' => true,
            'options' => array(
            'Yes' => 'Yes',
            'No' => 'No'

        )), $checkout->get_value( 'ccf_ausres' ) );
        echo '</div>'; // close checkbox div

        echo '<div id="visa_disclaimer" class="checkbox clearfix visa_disclaimer_field_wrapper"><p>Non-Australian residents studying in Australia must have the appropriate Visa to study with a non-CRICOS training provider. If your course requires vocational placement, your Visa must have enough time left to complete the requirement in an appropriate registered Australian facility.</p></div>';

        echo '<div class="hide_block123 ethnicity_group_wrapper"><div class="ethnicity_field_wrapper checkbox clearfix"><h5>Are you Aboriginal and/or Torres Strait Islander? <abbr class="required" title="required">*</abbr></h5>';

        // Indigenous / Islander
        woocommerce_form_field_radio( 'ccf_indig', array(
            'type' => 'select',
            'label' => __( '' ),
            'placeholder' => __( '' ),
            'required' => true,
            'options' => array(
            'No, Neither Aboriginal nor Torres Strait Islander' => 'No',
            'Yes, Aboriginal' => 'Aboriginal',
            'Yes, Torres Strait Islander' => 'Torres Strait Islander',
            'Not stated' => 'Not Stated'

        )), $checkout->get_value( 'ccf_indig' ) );
        echo '</div>'; // close checkbox div

        // Main Language
        woocommerce_form_field( 'ccf_main_lang', array(
            'type'          => 'select',
            'required'  => 'true',
            'class'         => array('text required'),
            'label'         => __('Main language spoken'),
            'options'     => array(
              'English' => __('English', 'woocommerce' ),
              'Not Stated' => __('Other', 'woocommerce' ),
            ),
        ), $checkout->get_value( 'ccf_main_lang' ));

        echo '<div id="english-level" class="checkbox clearfix">
          <h5>How well do you understand English? <abbr class="required" title="required">*</abbr></h5>';

          // Read English?
          woocommerce_form_field_radio( 'ccf_read', array(
            'type' => 'select',
            'label' => __( '' ),
            'placeholder' => __( '' ),
            'required' => true,
            'options' => array(
              'Very well' => 'Very well',
              'Well' => 'Well',
              'Not well' => 'Not well',
              'Not at all' => 'Not at all',
              'Not stated' => 'Not stated'
            ),
          ), $checkout->get_value( 'ccf_read' ) );

          echo '<p class="form-row text required" id="ccf_lang_home_field">
                  <label for="ccf_lang_home" class=""> <abbr class="required" title="required" style="display: none;">* <span>required</span></abbr></label>';

          // Other Language
          woocommerce_form_field( 'ccf_lang_home', array(
              'type'          => 'select',
              'required'  => 'true',
              'class'         => array('text required'),
              'label'         => __('What is the main language spoken at home?'),
              'options'     => array(
              '' => __('Select', 'woocommerce' ),
              'Afrikaans' => __('Afrikaans', 'woocommerce' ),
              'Albanian' => __('Albanian', 'woocommerce' ),
              'Arabic' => __('Arabic', 'woocommerce' ),
              'Armenian' => __('Armenian', 'woocommerce' ),
              'Azerbaijani' => __('Azerbaijani', 'woocommerce' ),
              'Basque' => __('Basque', 'woocommerce' ),
              'Belorussian' => __('Belorussian', 'woocommerce' ),
              'Bengali' => __('Bengali', 'woocommerce' ),
              'Bosnian' => __('Bosnian', 'woocommerce' ),
              'Catalan' => __('Catalan', 'woocommerce' ),
              'Bulgarian' => __('Bulgarian', 'woocommerce' ),
              'Burmese' => __('Burmese', 'woocommerce' ),
              'Cebuano' => __('Cebuano', 'woocommerce' ),
              'Chinese' => __('Chinese', 'woocommerce' ),
              'Croatian' => __('Croatian', 'woocommerce' ),
              'Danish' => __('Danish', 'woocommerce' ),
              'Dutch' => __('Dutch', 'woocommerce' ),
              'Esperanto' => __('Esperanto', 'woocommerce' ),
              'Estonian' => __('Estonian', 'woocommerce' ),
              'Filipino' => __('Filipino', 'woocommerce' ),
              'French' => __('French', 'woocommerce' ),
              'Georgian' => __('Georgian', 'woocommerce' ),
              'German' => __('German', 'woocommerce' ),
              'Gujarati' => __('Gujarati', 'woocommerce' ),
              'Hausa' => __('Hausa', 'woocommerce' ),
              'Hindi' => __('Hindi', 'woocommerce' ),
              'Hungarian' => __('Hungarian', 'woocommerce' ),
              'Igbo' => __('Igbo', 'woocommerce' ),
              'Indonesian' => __('Indonesian', 'woocommerce' ),
              'Irish' => __('Irish', 'woocommerce' ),
              'Italian' => __('Italian', 'woocommerce' ),
              'Japanese' => __('Japanese', 'woocommerce' ),
              'Javanese' => __('Javanese', 'woocommerce' ),
              'Kannada' => __('Kannada', 'woocommerce' ),
              'Korean' => __('Korean', 'woocommerce' ),
              'Latin' => __('Latin', 'woocommerce' ),
              'Malayalam' => __('Malayalam', 'woocommerce' ),
              'Mongolian' => __('Mongolian', 'woocommerce' ),
              'Spanish' => __('Spanish', 'woocommerce' ),
              'Swedish' => __('Swedish', 'woocommerce' ),
              'Tamil' => __('Tamil', 'woocommerce' ),
              'Telugu' => __('Telugu', 'woocommerce' ),
              'Urdu' => __('Urdu', 'woocommerce' ),
              'Vietnamese' => __('Vietnamese', 'woocommerce' ),
              'Yiddish' => __('Yiddish', 'woocommerce' ),
              'Not Stated' => __('Not Stated', 'woocommerce' ),
            ),
          ), $checkout->get_value( 'ccf_lang_home' ));


          echo '</p></div>'; // close checkbox div

        // Employment status
        woocommerce_form_field( 'ccf_employ_stat', array(
            'type'          => 'select',
            'required'  => 'true',
            'class'         => array('text required'),
            'label'         => __('Employment status'),
            'options'     => array(
              '' => __('Select status...', 'woocommerce' ),
              'Full time employee/01' => __('Full-time employee', 'woocommerce' ),
              'Part time employee/02' => __('Part-time employee', 'woocommerce' ),
              'Self employed - not employing others/03' => __('Self-employed – not employing others', 'woocommerce' ),
              'Employer/04' => __('Employer', 'woocommerce' ),
              'Employed - unpaid worker in a family business/05' => __('Employed – unpaid worker in family business', 'woocommerce' ),
              'Unemployed - seeking full time work/06' => __('Unemployed – seeking full-time work', 'woocommerce' ),
              'Unemployed - seeking part time work/07' => __('Unemployed – seeking part-time work', 'woocommerce' ),
              'Not employed - not seeking employment/08' => __('Not employed – not seeking employment', 'woocommerce' ),
              'Not stated/@@' => __('Not stated', 'woocommerce' )
            ),
        ), $checkout->get_value( 'ccf_employ_stat' ));


        echo '<div class="checkbox clearfix"><h5>Are you still enrolled in secondary or senior secondary education? <abbr class="required" title="required">*</abbr></h5>';

        // Still at School?
        woocommerce_form_field_radio( 'ccf_school', array(
            'type' => 'select',
            'label' => __( '' ),
            'placeholder' => __( '' ),
            'required' => true,
            'options' => array(
            'Yes' => 'Yes',
            'No' => 'No',
            'Not Stated' => 'Not Stated'

        )), $checkout->get_value( 'ccf_school' ) );

        echo '</div>'; // close checkbox div

        // added from moodle
        // School name
        woocommerce_form_field( 'ccf_school_title', array(
          'type'          => 'select',
          'required'  => false,
          'class'         => array('text'),
          'label'         => __('If yes, name of school?'),
          'options'     => array(
            '' => __('Select School', 'woocommerce' ),
            'Other School in Australia' => __('Other School in Australia', 'woocommerce' ),
			'Other School Abroad' => __('Other School Abroad', 'woocommerce' ),
			'Aboriginal Community College' => __('Aboriginal Community College', 'woocommerce' ),
            'Albany Secondary Education Support Centre' => __('Albany Secondary Education Support Centre', 'woocommerce' ),
            'Albany Senior High School' => __('Albany Senior High School', 'woocommerce' ),
            'Alexander Institute Of Technology' => __('Alexander Institute Of Technology', 'woocommerce' ),
            'Applecross Senior High School' => __('Applecross Senior High School', 'woocommerce' ),
            'Aquinas College' => __('Aquinas College', 'woocommerce' ),
            'Aranmore Catholic College' => __('Aranmore Catholic College', 'woocommerce' ),
            'Armadale Christian College' => __('Armadale Christian College', 'woocommerce' ),
            'Armadale Education Support Centre' => __('Armadale Education Support Centre', 'woocommerce' ),
            'Armadale Senior High School' => __('Armadale Senior High School', 'woocommerce' ),
            'Australian Institute for University Studies' => __('Australian Institute for University Studies', 'woocommerce' ),
            'Australian Islamic College - Kewdale' => __('Australian Islamic College - Kewdale', 'woocommerce' ),
            'Australian Islamic College-North' => __('Australian Islamic College-North', 'woocommerce' ),
            'Australian Islamic College-Perth' => __('Australian Islamic College-Perth', 'woocommerce' ),
            'Australian School International Education' => __('Australian School International Education', 'woocommerce' ),
            'Australind Senior High School' => __('Australind Senior High School', 'woocommerce' ),
            'Balcatta Senior High School' => __('Balcatta Senior High School', 'woocommerce' ),
            'Balga Senior High School' => __('Balga Senior High School', 'woocommerce' ),
            'Ballajura Community College' => __('Ballajura Community College', 'woocommerce' ),
            'Belmont City College' => __('Belmont City College', 'woocommerce' ),
            'Belridge Education Support Centre' => __('Belridge Education Support Centre', 'woocommerce' ),
            'Belridge Senior High School' => __('Belridge Senior High School', 'woocommerce' ),
            'Bethel Christian School' => __('Bethel Christian School', 'woocommerce' ),
            'Bible Baptist Christian Academy' => __('Bible Baptist Christian Academy', 'woocommerce' ),
            'Blackstone Remote Community School' => __('Blackstone Remote Community School', 'woocommerce' ),
            'Boddington District High School' => __('Boddington District High School', 'woocommerce' ),
            'Boyup Brook District High School' => __('Boyup Brook District High School', 'woocommerce'),
            'Bridgetown High School' => __('Bridgetown High School', 'woocommerce'),
            'Brookton District High School' => __('Brookton District High School', 'woocommerce'),
            'Broome Senior High School' => __('Broome Senior High School', 'woocommerce'),
            'Bruce Rock District High School' => __('Bruce Rock District High School', 'woocommerce'),
            'Bullsbrook District High School' => __('Bullsbrook District High School', 'woocommerce'),
            'Bunbury Cathedral Grammar School' => __('Bunbury Cathedral Grammar School', 'woocommerce'),
            'Bunbury Catholic College' => __('Bunbury Catholic College', 'woocommerce'),
            'Bunbury Senior High School' => __('Bunbury Senior High School', 'woocommerce'),
            'Burbridge School' => __('Burbridge School', 'woocommerce'),
            'Burringurrah Remote Community School' => __('Burringurrah Remote Community School', 'woocommerce'),
            'Busselton Senior High School' => __('Busselton Senior High School', 'woocommerce'),
            'Canning College' => __('Canning College', 'woocommerce'),
            'Canning Vale College' => __('Canning Vale College', 'woocommerce'),
            'Cannington Comm Education Support Centre' => __('Cannington Comm Education Support Centre', 'woocommerce'),
            'Cannington Community College' => __('Cannington Community College', 'woocommerce'),
            'Career Enterprise Centre' => __('Career Enterprise Centre', 'woocommerce'),
            'Carey Baptist College' => __('Carey Baptist College', 'woocommerce'),
            'Carine Senior High School' => __('Carine Senior High School', 'woocommerce'),
            'Carmel Advent College' => __('Carmel Advent College', 'woocommerce'),
            'Carmel School' => __('Carmel School', 'woocommerce'),
            'Carnamah District High School' => __('Carnamah District High School', 'woocommerce'),
            'Carnarvon Senior High School' => __('Carnarvon Senior High School', 'woocommerce'),
            'Castlereagh School' => __('Castlereagh School', 'woocommerce'),
            'Catholic Agricultural College' => __('Catholic Agricultural College', 'woocommerce'),
            'CBC Fremantle' => __('CBC Fremantle', 'woocommerce'),
            'Cecil Andrews Senior High School' => __('Cecil Andrews Senior High School', 'woocommerce'),
            'Central Midlands Senior High School' => __('Central Midlands Senior High School', 'woocommerce'),
            'Chisholm Catholic College' => __('Chisholm Catholic College', 'woocommerce'),
            'Christ Church Grammar School' => __('Christ Church Grammar School', 'woocommerce'),
            'Christian Aboriginal Pd School' => __('Christian Aboriginal Pd School', 'woocommerce'),
            'Christian Brothers Agricultural' => __('Christian Brothers Agricultural', 'woocommerce'),
            'Christmas Island District High School' => __('Christmas Island District High School', 'woocommerce'),
            'Churchlands Senior High School' => __('Churchlands Senior High School', 'woocommerce'),
            'Clarkson Community High School' => __('Clarkson Community High School', 'woocommerce'),
            'Clontarf Aboriginal College' => __('Clontarf Aboriginal College', 'woocommerce'),
            'Cocos Island District High School' => __('Cocos Island District High School', 'woocommerce'),
            'College Row School' => __('College Row School', 'woocommerce'),
            'Collie Senior High School' => __('Collie Senior High School', 'woocommerce'),
            'Comet Bay College' => __('Comet Bay College', 'woocommerce'),
            'Como Secondary College' => __('Como Secondary College', 'woocommerce'),
            'Coodanup Community College' => __('Coodanup Community College', 'woocommerce'),
            'Cornerstone Christian College' => __('Cornerstone Christian College', 'woocommerce'),
            'Corpus Christi College' => __('Corpus Christi College', 'woocommerce'),
            'Corridors College' => __('Corridors College', 'woocommerce'),
            'Corrigin District High School' => __('Corrigin District High School', 'woocommerce'),
            'Cosmo Newbery Remote Community School' => __('Cosmo Newbery Remote Community School', 'woocommerce'),
            'Cue Primary School' => __('Cue Primary School', 'woocommerce'),
            'Culunga Aboriginal Com School' => __('Culunga Aboriginal Com School', 'woocommerce'),
            'Cunderdin District High School' => __('Cunderdin District High School', 'woocommerce'),
            'Cyril Jackson Senior Campus' => __('Cyril Jackson Senior Campus', 'woocommerce'),
            'Cyril Jackson Snr Campus Education Support' => __('Cyril Jackson Snr Campus Education Support', 'woocommerce'),
            'Dale Christian School' => __('Dale Christian School', 'woocommerce'),
            'Dalwallinu District High School' => __('Dalwallinu District High School', 'woocommerce'),
            'Darkan District High School' => __('Darkan District High School', 'woocommerce'),
            'Dawul Remote Community School' => __('Dawul Remote Community School', 'woocommerce'),
            'Denmark High School' => __('Denmark High School', 'woocommerce'),
            'Derby District High School' => __('Derby District High School', 'woocommerce'),
            'Divine Mercy College' => __('Divine Mercy College', 'woocommerce'),
            'Djarindjin Lombadina Catholic School' => __('Djarindjin Lombadina Catholic School', 'woocommerce'),
            'Djugerari Remote Community School' => __('Djugerari Remote Community School', 'woocommerce'),
            'Dongara District High School' => __('Dongara District High School', 'woocommerce'),
            'Donnybrook District High School' => __('Donnybrook District High School', 'woocommerce'),
            'Dowerin District High School' => __('Dowerin District High School', 'woocommerce'),
            'Duncraig Senior High School' => __('Duncraig Senior High School', 'woocommerce'),
            'Duncraig SHS Education Support Centre' => __('Duncraig SHS Education Support Centre', 'woocommerce'),
            'Durham Road School' => __('Durham Road School', 'woocommerce'),
            'Eastern Goldfields SHS Education Support Centre' => __('Eastern Goldfields SHS Education Support Centre', 'woocommerce'),
            'Eastern Hills Senior High School' => __('Eastern Hills Senior High School', 'woocommerce'),
            'Eaton Community College' => __('Eaton Community College', 'woocommerce'),
            'El Shaddai College' => __('El Shaddai College', 'woocommerce'),
            'Ellenbrook Christian College' => __('Ellenbrook Christian College', 'woocommerce'),
            'Emmanuel Catholic College' => __('Emmanuel Catholic College', 'woocommerce'),
            'Esperance Senior High School' => __('Esperance Senior High School', 'woocommerce'),
            'Esperance SHS Education Support Centre' => __('Esperance SHS Education Support Centre', 'woocommerce'),
            'Exmouth District High School' => __('Exmouth District High School', 'woocommerce'),
            'Fitzroy Crossing District High School' => __('Fitzroy Crossing District High School', 'woocommerce'),
            'Forrestfield Senior High School' => __('Forrestfield Senior High School', 'woocommerce'),
            'Foundation Christian College' => __('Foundation Christian College', 'woocommerce'),
            'Frederick Irwin Anglican School' => __('Frederick Irwin Anglican School', 'woocommerce'),
            'Gascoyne Junction Remote Community School' => __('Gascoyne Junction Remote Community School', 'woocommerce'),
            'Geographe Education Support Centre' => __('Geographe Education Support Centre', 'woocommerce'),
            'Georgiana Molloy Anglican School' => __('Georgiana Molloy Anglican School', 'woocommerce'),
            'Geraldton Grammar School' => __('Geraldton Grammar School', 'woocommerce'),
            'Geraldton Senior College' => __('Geraldton Senior College', 'woocommerce'),
            'Gingin District High School' => __('Gingin District High School', 'woocommerce'),
            'Girrawheen Senior High School' => __('Girrawheen Senior High School', 'woocommerce'),
            'Gladys Newton School' => __('Gladys Newton School', 'woocommerce'),
            'Gnowangerup District High School' => __('Gnowangerup District High School', 'woocommerce'),
            'Goldfields Baptist College' => __('Goldfields Baptist College', 'woocommerce'),
            'Gosnells Senior High School' => __('Gosnells Senior High School', 'woocommerce'),
            'Governor Stirling Senior High School' => __('Governor Stirling Senior High School', 'woocommerce'),
            'Grace Christian School' => __('Grace Christian School', 'woocommerce'),
            'Great Southern Grammar' => __('Great Southern Grammar', 'woocommerce'),
            'Greenwood Senior High School' => __('Greenwood Senior High School', 'woocommerce'),
            'Guildford Grammar School' => __('Guildford Grammar School', 'woocommerce'),
            'Hale School' => __('Hale School', 'woocommerce'),
            'Halls Creek District High School' => __('Halls Creek District High School', 'woocommerce'),
            'Halls Head Com Coll Education Support Centre' => __('Halls Head Com Coll Education Support Centre', 'woocommerce'),
            'Halls Head Community College' => __('Halls Head Community College', 'woocommerce'),
            'Hamilton Senior High School' => __('Hamilton Senior High School', 'woocommerce'),
            'Hampton Senior High School' => __('Hampton Senior High School', 'woocommerce'),
            'Harvey Senior High School' => __('Harvey Senior High School', 'woocommerce'),
            'Hedland Senior High School' => __('Hedland Senior High School', 'woocommerce'),
            'Helena College Senior School' => __('Helena College Senior School', 'woocommerce'),
            'Heritage college' => __('Heritage college', 'woocommerce'),
            'Holland Street School' => __('Holland Street School', 'woocommerce'),
            'Hope Christian College' => __('Hope Christian College', 'woocommerce'),
            'Hospital School Services' => __('Hospital School Services', 'woocommerce'),
            'Iona Presentation College' => __('Iona Presentation College', 'woocommerce'),
            'Irene McCormack Catholic College' => __('Irene McCormack Catholic College', 'woocommerce'),
            'Jameson Remote Community School' => __('Jameson Remote Community School', 'woocommerce'),
            'Jerramungup District High School' => __('Jerramungup District High School', 'woocommerce'),
            'Jigalong Remote Community School' => __('Jigalong Remote Community School', 'woocommerce'),
            'John Calvin Christian College' => __('John Calvin Christian College', 'woocommerce'),
            'John Calvin School' => __('John Calvin School', 'woocommerce'),
            'John Curtin College Of The Arts' => __('John Curtin College Of The Arts', 'woocommerce'),
            'John Forrest Senior High School' => __('John Forrest Senior High School', 'woocommerce'),
            'John Paul College' => __('John Paul College', 'woocommerce'),
            'John Pujajangka Piyirn School' => __('John Pujajangka Piyirn School', 'woocommerce'),
            'John Septimus Roe Anglican Community School' => __('John Septimus Roe Anglican Community School', 'woocommerce'),
            'John Willcock College' => __('John Willcock College', 'woocommerce'),
            'John Wollaston Anglican Community School' => __('John Wollaston Anglican Community School', 'woocommerce'),
            'John XXIII College' => __('John XXIII College', 'woocommerce'),
            'Jungdranung Remote Community School' => __('Jungdranung Remote Community School', 'woocommerce'),
            'Jurien Bay District High School' => __('Jurien Bay District High School', 'woocommerce'),
            'Kalamunda Senior High School' => __('Kalamunda Senior High School', 'woocommerce'),
            'Kalamunda SHS Education Support Centre' => __('Kalamunda SHS Education Support Centre', 'woocommerce'),
            'Kalbarri District High School' => __('Kalbarri District High School', 'woocommerce'),
            'Kalgoorlie-Boulder Middle School' => __('Kalgoorlie-Boulder Middle School', 'woocommerce'),
            'Kalgoorlie-Boulder Senior College' => __('Kalgoorlie-Boulder Senior College', 'woocommerce'),
            'Kalumburu Remote Community School' => __('Kalumburu Remote Community School', 'woocommerce'),
            'Kambalda West District High School' => __('Kambalda West District High School', 'woocommerce'),
            'Karalundi Aboriginal Education Centre' => __('Karalundi Aboriginal Education Centre', 'woocommerce'),
            'Karratha Senior High School' => __('Karratha Senior High School', 'woocommerce'),
            'Katanning Senior High School' => __('Katanning Senior High School', 'woocommerce'),
            'Kearnan College' => __('Kearnan College', 'woocommerce'),
            'Kellerberrin District High School' => __('Kellerberrin District High School', 'woocommerce'),
            'Kelmscott Senior High School' => __('Kelmscott Senior High School', 'woocommerce'),
            'Kensington Secondary School' => __('Kensington Secondary School', 'woocommerce'),
            'Kent Street Senior High School' => __('Kent Street Senior High School', 'woocommerce'),
            'Kenwick School' => __('Kenwick School', 'woocommerce'),
            'Kids Open Learning School' => __('Kids Open Learning School', 'woocommerce'),
            'Kim Beazley School' => __('Kim Beazley School', 'woocommerce'),
            'Kingsway Christian College' => __('Kingsway Christian College', 'woocommerce'),
            'Kinross College' => __('Kinross College', 'woocommerce'),
            'Kiwirrkurra Remote Community School' => __('Kiwirrkurra Remote Community School', 'woocommerce'),
            'Kojonup District High School' => __('Kojonup District High School', 'woocommerce'),
            'Kolbe Catholic College' => __('Kolbe Catholic College', 'woocommerce'),
            'Kulin District High School' => __('Kulin District High School', 'woocommerce'),
            'Kulkarriya Community School' => __('Kulkarriya Community School', 'woocommerce'),
            'Kununurra District High School' => __('Kununurra District High School', 'woocommerce'),
            'Kururrungku Catholic Education Centre' => __('Kururrungku Catholic Education Centre', 'woocommerce'),
            'Kwinana Senior High School' => __('Kwinana Senior High School', 'woocommerce'),
            'La Grange Remote Community School' => __('La Grange Remote Community School', 'woocommerce'),
            'La Salle College' => __('La Salle College', 'woocommerce'),
            'Lake Grace District High School' => __('Lake Grace District High School', 'woocommerce'),
            'Lake Joondalup Baptist College' => __('Lake Joondalup Baptist College', 'woocommerce'),
            'Lakeland Senior High School' => __('Lakeland Senior High School', 'woocommerce'),
            'Langford Islamic College' => __('Langford Islamic College', 'woocommerce'),
            'Laverton Primary School' => __('Laverton Primary School', 'woocommerce'),
            'Leeming Senior High School' => __('Leeming Senior High School', 'woocommerce'),
            'Leeming SHS Education Support Centre' => __('Leeming SHS Education Support Centre', 'woocommerce'),
            'Leinster Primary School' => __('Leinster Primary School', 'woocommerce'),
            'Leonora District High School' => __('Leonora District High School', 'woocommerce'),
            'Lesmurdie Senior High School' => __('Lesmurdie Senior High School', 'woocommerce'),
            'Living Waters Lutheran College' => __('Living Waters Lutheran College', 'woocommerce'),
            'Lockridge Senior High School' => __('Lockridge Senior High School', 'woocommerce'),
            'Looma Remote Community School' => __('Looma Remote Community School', 'woocommerce'),
            'Lumen Christi College' => __('Lumen Christi College', 'woocommerce'),
            'Luurnpa Catholic School' => __('Luurnpa Catholic School', 'woocommerce'),
            'Lynwood Senior High School' => __('Lynwood Senior High School', 'woocommerce'),
            'Mackillop Catholic College' => __('Mackillop Catholic College', 'woocommerce'),
            'Malibu School' => __('Malibu School', 'woocommerce'),
            'Mandurah Baptist College' => __('Mandurah Baptist College', 'woocommerce'),
            'Mandurah Catholic College' => __('Mandurah Catholic College', 'woocommerce'),
            'Mandurah High School' => __('Mandurah High School', 'woocommerce'),
            'Mandurah Senior College' => __('Mandurah Senior College', 'woocommerce'),
            'Manjimup Education Support Centre' => __('Manjimup Education Support Centre', 'woocommerce'),
            'Manjimup Senior High School' => __('Manjimup Senior High School', 'woocommerce'),
            'Maranatha Christian Community School' => __('Maranatha Christian Community School', 'woocommerce'),
            'Marble Bar Primary School' => __('Marble Bar Primary School', 'woocommerce'),
            'Margaret River Senior High School' => __('Margaret River Senior High School', 'woocommerce'),
            'Mater Dei College' => __('Mater Dei College', 'woocommerce'),
            'Mazenod College' => __('Mazenod College', 'woocommerce'),
            'Meekatharra District High School' => __('Meekatharra District High School', 'woocommerce'),
            'Melville Senior High School' => __('Melville Senior High School', 'woocommerce'),
            'Menzies Remote Community School' => __('Menzies Remote Community School', 'woocommerce'),
            'Mercedes College' => __('Mercedes College', 'woocommerce'),
            'Mercy College' => __('Mercy College', 'woocommerce'),
            'Merredin Senior High School' => __('Merredin Senior High School', 'woocommerce'),
            'Mindarie Senior College' => __('Mindarie Senior College', 'woocommerce'),
            'Mirrabooka Senior High School' => __('Mirrabooka Senior High School', 'woocommerce'),
            'Mirrabooka SHS Education Support Centre' => __('Mirrabooka SHS Education Support Centre', 'woocommerce'),
            'Morawa District High School' => __('Morawa District High School', 'woocommerce'),
            'Morley Senior High School' => __('Morley Senior High School', 'woocommerce'),
            'Mount Barker Senior High School' => __('Mount Barker Senior High School', 'woocommerce'),
            'Mount Lawley Senior High School' => __('Mount Lawley Senior High School', 'woocommerce'),
            'Mt Magnet District High School' => __('Mt Magnet District High School', 'woocommerce'),
            'Mukinbudin Christian Community School' => __('Mukinbudin Christian Community School', 'woocommerce'),
            'Mukinbudin District High School' => __('Mukinbudin District High School', 'woocommerce'),
            'Mullewa District High School' => __('Mullewa District High School', 'woocommerce'),
            'Muludja Remote Community School' => __('Muludja Remote Community School', 'woocommerce'),
            'Mundaring Christian College' => __('Mundaring Christian College', 'woocommerce'),
            'Murdoch College' => __('Murdoch College', 'woocommerce'),
            'Muslim Ladies College Of Australia' => __('Muslim Ladies College Of Australia', 'woocommerce'),
            'Nagle Catholic College' => __('Nagle Catholic College', 'woocommerce'),
            'Nannup District High School' => __('Nannup District High School', 'woocommerce'),
            'Narembeen District High School' => __('Narembeen District High School', 'woocommerce'),
            'Narrogin Senior High School' => __('Narrogin Senior High School', 'woocommerce'),
            'Newman College' => __('Newman College', 'woocommerce'),
            'Newman Senior High School' => __('Newman Senior High School', 'woocommerce'),
            'Newton Moore Education Support Centre' => __('Newton Moore Education Support Centre', 'woocommerce'),
            'Newton Moore Senior High School' => __('Newton Moore Senior High School', 'woocommerce'),
            'Ngalangangpum School' => __('Ngalangangpum School', 'woocommerce'),
            'Ngalapita Remote Communit School' => __('Ngalapita Remote Communit School', 'woocommerce'),
            'Nollamara Christian Academy' => __('Nollamara Christian Academy', 'woocommerce'),
            'Norseman District High School' => __('Norseman District High School', 'woocommerce'),
            'North Albany Senior High School' => __('North Albany Senior High School', 'woocommerce'),
            'North Lake Senior Campus' => __('North Lake Senior Campus', 'woocommerce'),
            'Northam Senior High School' => __('Northam Senior High School', 'woocommerce'),
            'Northampton District High School' => __('Northampton District High School', 'woocommerce'),
            'Northcliffe District High School' => __('Northcliffe District High School', 'woocommerce'),
            'Nullagine Primary School' => __('Nullagine Primary School', 'woocommerce'),
            'Nyikina Mangala Community School' => __('Nyikina Mangala Community School', 'woocommerce'),
            'Ocean Forest Lutheran College' => __('Ocean Forest Lutheran College', 'woocommerce'),
            'Ocean Reef Senior High School' => __('Ocean Reef Senior High School', 'woocommerce'),
            'One Arm Point Remote Community School' => __('One Arm Point Remote Community School', 'woocommerce'),
            'Onslow Primary School' => __('Onslow Primary School', 'woocommerce'),
            'Oombulgurri Remote Community School' => __('Oombulgurri Remote Community School', 'woocommerce'),
            'Padbury Senior High School' => __('Padbury Senior High School', 'woocommerce'),
            'Parnngurr Community School' => __('Parnngurr Community School', 'woocommerce'),
            'Pemberton District High School' => __('Pemberton District High School', 'woocommerce'),
            'Penrhos College' => __('Penrhos College', 'woocommerce'),
            'Perth College' => __('Perth College', 'woocommerce'),
            'Perth Modern School' => __('Perth Modern School', 'woocommerce'),
            'Perth Waldorf School' => __('Perth Waldorf School', 'woocommerce'),
            'Peter Moyes Anglican Community School' => __('Peter Moyes Anglican Community School', 'woocommerce'),
            'Phoenix English Language Academy' => __('Phoenix English Language Academy', 'woocommerce'),
            'Phoenix West Vocational College' => __('Phoenix West Vocational College', 'woocommerce'),
            'Pia Wadjarri Remote Community School' => __('Pia Wadjarri Remote Community School', 'woocommerce'),
            'Pinjarra Senior High School' => __('Pinjarra Senior High School', 'woocommerce'),
            'Port Community High School' => __('Port Community High School', 'woocommerce'),
            'Prendiville Catholic College' => __('Prendiville Catholic College', 'woocommerce'),
            'Presbyterian Ladies College' => __('Presbyterian Ladies College', 'woocommerce'),
            'Quairading District High School' => __('Quairading District High School', 'woocommerce'),
            'Quinns Baptist College' => __('Quinns Baptist College', 'woocommerce'),
            'Ravensthorpe District High School' => __('Ravensthorpe District High School', 'woocommerce'),
            'Rawa Community School Aboriginal Corp' => __('Rawa Community School Aboriginal Corp', 'woocommerce'),
            'Rehoboth Christian School' => __('Rehoboth Christian School', 'woocommerce'),
            'Rockingham Senior High School' => __('Rockingham Senior High School', 'woocommerce'),
            'Rockingham SHS Education Support Centre' => __('Rockingham SHS Education Support Centre', 'woocommerce'),
            'Roebourne Primary School' => __('Roebourne Primary School', 'woocommerce'),
            'Roleystone District High School' => __('Roleystone District High School', 'woocommerce'),
            'Rossmoyne Senior High School' => __('Rossmoyne Senior High School', 'woocommerce'),
            'Sacred Heart College' => __('Sacred Heart College', 'woocommerce'),
            'Sacred Heart School' => __('Sacred Heart School', 'woocommerce'),
            'Safety Bay Senior High School' => __('Safety Bay Senior High School', 'woocommerce'),
            'Santa Maria College' => __('Santa Maria College', 'woocommerce'),
            'Schools Of Isolated & Distance Education' => __('Schools Of Isolated & Distance Education', 'woocommerce'),
            'Scotch College' => __('Scotch College', 'woocommerce'),
            'Serpentine-Jarrahdale Grammar School' => __('Serpentine-Jarrahdale Grammar School', 'woocommerce'),
            'Servite College' => __('Servite College', 'woocommerce'),
            'Seton Catholic College' => __('Seton Catholic College', 'woocommerce'),
            'Sevenoaks Senior College' => __('Sevenoaks Senior College', 'woocommerce'),
            'Shark Bay Primary School' => __('Shark Bay Primary School', 'woocommerce'),
            'Shenton College' => __('Shenton College', 'woocommerce'),
            'Shenton College Deaf Education Centre' => __('Shenton College Deaf Education Centre', 'woocommerce'),
            'Sir David Brand School' => __('Sir David Brand School', 'woocommerce'),
            'Somerville Baptist College' => __('Somerville Baptist College', 'woocommerce'),
            'South Fremantle Senior High School' => __('South Fremantle Senior High School', 'woocommerce'),
            'Southern Cross District High School' => __('Southern Cross District High School', 'woocommerce'),
            'Southlands Christian College' => __('Southlands Christian College', 'woocommerce'),
            'Sowilo Community High School' => __('Sowilo Community High School', 'woocommerce'),
            'Speech & Hearing Centre' => __('Speech & Hearing Centre', 'woocommerce'),
            'St Mary Star Of The Sea Catholic School' => __('St Mary Star Of The Sea Catholic School', 'woocommerce'),
            'St Norbert College' => __('St Norbert College', 'woocommerce'),
            'Strathalbyn Christian College' => __('Strathalbyn Christian College', 'woocommerce'),
            'Strelley Community School' => __('Strelley Community School', 'woocommerce'),
            'Swan Christian College' => __('Swan Christian College', 'woocommerce'),
            'Swan View Senior High School' => __('Swan View Senior High School', 'woocommerce'),
            'Swanleigh Anglican Community School' => __('Swanleigh Anglican Community School', 'woocommerce'),
            'Taylors College' => __('Taylors College', 'woocommerce'),
            'The Japanese School In Perth' => __('The Japanese School In Perth', 'woocommerce'),
            'The Montessori School' => __('The Montessori School', 'woocommerce'),
            'Thornlie Christian College' => __('Thornlie Christian College', 'woocommerce'),
            'Thornlie Senior High School' => __('Thornlie Senior High School', 'woocommerce'),
            'Tjirrkarli Remote Community School' => __('Tjirrkarli Remote Community School', 'woocommerce'),
            'Tjukurla Remote Community School' => __('Tjukurla Remote Community School', 'woocommerce'),
            'Tom Price Senior High School' => __('Tom Price Senior High School', 'woocommerce'),
            'Toodyay District High School' => __('Toodyay District High School', 'woocommerce'),
            'Tranby College' => __('Tranby College', 'woocommerce'),
            'Treetops Montessori School' => __('Treetops Montessori School', 'woocommerce'),
            'Trinity College' => __('Trinity College', 'woocommerce'),
            'Tuart College' => __('Tuart College', 'woocommerce'),
            'Ursula Frayne Catholic College' => __('Ursula Frayne Catholic College', 'woocommerce'),
            'WA College Of Agriculture - Cunderdin' => __('WA College Of Agriculture - Cunderdin', 'woocommerce'),
            'WA College Of Agriculture - Denmark' => __('WA College Of Agriculture - Denmark', 'woocommerce'),
            'WA College Of Agriculture - Harvey' => __('WA College Of Agriculture - Harvey', 'woocommerce'),
            'WA College Of Agriculture - Morawa' => __('WA College Of Agriculture - Morawa', 'woocommerce'),
            'WA College Of Agriculture - Narrogin' => __('WA College Of Agriculture - Narrogin', 'woocommerce'),
            'Wagin District High School' => __('Wagin District High School', 'woocommerce'),
            'Wananami Remote Community School' => __('Wananami Remote Community School', 'woocommerce'),
            'Wanarn Remote Community School' => __('Wanarn Remote Community School', 'woocommerce'),
            'Wangkatjungka Remote Community School' => __('Wangkatjungka Remote Community School', 'woocommerce'),
            'Wanneroo Senior High School' => __('Wanneroo Senior High School', 'woocommerce'),
            'Warakurna Remote Community School' => __('Warakurna Remote Community School', 'woocommerce'),
            'Warburton Ranges Remote Community School' => __('Warburton Ranges Remote Community School', 'woocommerce'),
            'Warnbro Community High School' => __('Warnbro Community High School', 'woocommerce'),
            'Warnbro Community High School Education Support' => __('Warnbro Community High School Education Support', 'woocommerce'),
            'Waroona District High School' => __('Waroona District High School', 'woocommerce'),
            'Warwick Senior High School' => __('Warwick Senior High School', 'woocommerce'),
            'Wesley College' => __('Wesley College', 'woocommerce'),
            'Willetton Senior High School' => __('Willetton Senior High School', 'woocommerce'),
            'Wiluna Remote Community School' => __('Wiluna Remote Community School', 'woocommerce'),
            'Wingellina Remote Community School' => __('Wingellina Remote Community School', 'woocommerce'),
            'Winthrop Baptist College' => __('Winthrop Baptist College', 'woocommerce'),
            'Wongan Hills District High' => __('Wongan Hills District High', 'woocommerce'),
            'Wongutha Christian Aboriginal' => __('Wongutha Christian Aboriginal', 'woocommerce'),
            'Woodthorpe Drive Secondary School' => __('Woodthorpe Drive Secondary School', 'woocommerce'),
            'Woodvale Senior High School' => __('Woodvale Senior High School', 'woocommerce'),
            'Wulungarra School' => __('Wulungarra School', 'woocommerce'),
            'Wyalkatchem District High School' => __('Wyalkatchem District High School', 'woocommerce'),
            'Wyndham District High School' => __('Wyndham District High School', 'woocommerce'),
            'Yakanarra Community School' => __('Yakanarra Community School', 'woocommerce'),
            'Yalgoo Primary School' => __('Yalgoo Primary School', 'woocommerce'),
            'Yanchep District High School' => __('Yanchep District High School', 'woocommerce'),
            'Yandeyarra Remote Community School' => __('Yandeyarra Remote Community School', 'woocommerce'),
            'Yintarri Remote Community School' => __('Yintarri Remote Community School', 'woocommerce'),
            'Yiyili Aboriginal Community School' => __('Yiyili Aboriginal Community School', 'woocommerce'),
            'York District High School' => __('York District High School', 'woocommerce'),
            'Yule Brook College' => __('Yule Brook College', 'woocommerce'),
            'Yulga Jinna Remote Community School' => __('Yulga Jinna Remote Community School', 'woocommerce'),
          ),
        ), $checkout->get_value( 'ccf_school_title' ));

        // School level
        woocommerce_form_field( 'ccf_school_level', array(
            'type'          => 'select',
            'required'  => false,
            'class'         => array('text'),
            'label'         => __('What is your highest completed school Level?'),
            'options'     => array(
              '' => __('Select level...', 'woocommerce' ),
              'Year 12/12' => __('Year 12 or equivalent', 'woocommerce' ),
              'Year 11/11' => __('Year 11 or equivalent', 'woocommerce' ),
              'Year 10/10' => __('Year 10 or equivalent', 'woocommerce' ),
              'Year 9 or lower/09' => __('Year 9 or equivalent', 'woocommerce' ),
              'Year 8 or below/08' => __('Year 8 or below', 'woocommerce' ),
              'Did not go to school/02' => __('Never attended school', 'woocommerce' ),
              'Not stated/@@' => __('Not Stated', 'woocommerce' )
            ),
        ), $checkout->get_value( 'ccf_school_level' ));


        // School name
        // woocommerce_form_field( 'ccf_school_title', array(
        //     'type'          => 'text',
        //     'required'  => false,
        //     'class'         => array('text'),
        //     'label'         => __('If yes, name of school?'),
        // ), $checkout->get_value( 'ccf_school_title' ));

        // added from moodle
        $year = array( '' => 'Select year' );
        for($i = date('Y') - 50; $i <= date('Y');$i++ ) {
          $year[$i] = $i;
        }
        // School year
        woocommerce_form_field( 'ccf_school_higest_year', array(
          'type'          => 'select',
          'required'  => true,
          'class'         => array('text'),
          'label'         => __('In which year did you complete that highest school level?'),
          'options'     => $year
        ), $checkout->get_value( 'ccf_school_higest_year' ));

    // USI Number
    echo '<div class="checkbox">
            <h5 class="no-margin">Do you have a Unique Student Identifier (USI)?</h5>
            <p class="form-row full" id="ccf_usi">
              <input id="ccf_usi_checkbox" class="input-checkbox" type="checkbox" name="ccf_usi" value="1" />
              <label for="ccf_usi_checkbox" class="checkbox">If yes, please check this box to enter your USI number</label>
              <br>
              <small>The Australian Government has initiated the USI and requires all students in VET courses to apply for their individual USI number and provide this to their Training Provider. A Training Provider cannot issue a Certificate unless the USI is supplied. Creating your USI is free, quick, and only needs one form of ID. To obtain your USI, simply go to <a href="https://www.usi.gov.au/students/create-your-usi" target="_blank">https://www.usi.gov.au/students/create-your-usi </a></small>
            </p>
          </div>';

    echo '<div class="usi_num">';

            // USI Number
            woocommerce_form_field( 'ccf_usi_num', array(
                'type'          => 'text',
                'required'  => true,
                'class'         => array('text required ccf_usi_num'),
                'label'         => __('Student USI Number'),
                'placeholder'         => __('3AW88YH9U5'),
            ), $checkout->get_value( 'ccf_usi_num' ));

    echo '</div>';

    echo '</div>'; // close section
    echo '<a class="next" id="next-personal" data-current-block="2" data-next-block="3" >Next Step</a>';
