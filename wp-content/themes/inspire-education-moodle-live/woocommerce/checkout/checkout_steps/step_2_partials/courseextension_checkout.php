<?php
   echo '<h5 class="form-title">
   Additional Extension details
   <span>Please enter your details for enrolment.</span>
 </h5>';

woocommerce_form_field( 'ccf_student_num', array(
'type'          => 'text',
'class'         => array('text'),
'label'         => __('Student Number'),
'placeholder'   => __('Enter your student number here'),
), $checkout->get_value( 'ccf_student_num' ));


woocommerce_form_field( 'ccf_student_course', array(
	'label' => "What's the name of the course you want to extend?",
	'type'        => 'select',
	'required'        => true,
	'placeholder' => 'select course',
	'class'=>  ['select-course-ext'],
	'priority'=> 50,
	'options'     => array(
		'' => 'Select',
		'Cert III Accounts Admin' => 'Cert III Accounts Admin',
		'Cert III and Diploma Early Childhood Education' => 'Cert III and Diploma Early Childhood Education',
		'Cert III Individual Support (Ageing)' => 'Cert III Individual Support (Ageing)',
		'Cert III Individual Support (Disability)' => 'Cert III Individual Support (Disability)',
		'Cert III Individual Support (Home and Community)' => 'Cert III Individual Support (Home and Community)',
		'Cert IV Accounting and Bookkeeping' => 'Cert IV Accounting and Bookkeeping',
		'Cert IV Accounting and Bookkeeping + Tax Exam Bundle' => 'Cert IV Accounting and Bookkeeping + Tax Exam Bundle',
		'Cert IV Accounting and Bookkeeping and Diploma Bundle' => 'Cert IV Accounting and Bookkeeping and Diploma Bundle',
		'Cert IV Accounting and Bookkeeping Upgrade and Transition' => 'Cert IV Accounting and Bookkeeping Upgrade and Transition',
		'Cert IV Ageing Support' => 'Cert IV Ageing Support',
		'Cert IV Business (Administration)' => 'Cert IV Business (Administration)',
		'Cert IV Business (Operations)' => 'Cert IV Business (Operations)',
		'Cert IV Disability' => 'Cert IV Disability',
		'Cert IV Entrepreneurship and New Business' => 'Cert IV Entrepreneurship and New Business',
		'Cert IV Health Administration' => 'Cert IV Health Administration',
		'Cert IV HR Management' => 'Cert IV HR Management',
		'Cert IV Leadership and Management' => 'Cert IV Leadership and Management',
		'Cert IV Marketing and Communication' => 'Cert IV Marketing and Communication',
		'Cert IV Project Management Practice' => 'Cert IV Project Management Practice',
		'Cert IV Retail Management' => 'Cert IV Retail Management',
		'Cert IV TAE' => 'Cert IV TAE',
		'Cert IV TESOL' => 'Cert IV TESOL',
		'Cert IV WHS' => 'Cert IV WHS',
		'Cert IV WHS and Diploma Bundle' => 'Cert IV WHS and Diploma Bundle',
		'Design and Develop Assessment Tools' => 'Design and Develop Assessment Tools',
		'Diploma Business (Operations)' => 'Diploma Business (Operations)',
		'Diploma Community Services' => 'Diploma Community Services',
		'Diploma Early Childhood Education' => 'Diploma Early Childhood Education',
		'Diploma Leadership and Management' => 'Diploma Leadership and Management',
		'Diploma Accounting' => 'Diploma Accounting',
		'Diploma Project Management' => 'Diploma Project Management',
		'Diploma Training Design' => 'Diploma Training Design',
		'Diploma WHS' => 'Diploma WHS',
		'Diploma WHS and Prerequisite Training' => 'Diploma WHS and Prerequisite Training',
		'Double Certificate III Individual Support (Ageing/Home Community)' => 'Double Certificate III Individual Support (Ageing/Home Community)',
		'Double Certificate III Individual Support (Ageing/Disability)' => 'Double Certificate III Individual Support (Ageing/Disability)',
		'Double Certificate III Individual Support (Disability/Home Community)' => 'Double Certificate III Individual Support (Disability/Home Community)',
		'TAE40110 to TAE40116 Upgrade' => 'TAE40110 to TAE40116 Upgrade',
		'TAELLN411 Unit' => 'TAELLN411 Unit',
		'TAEDEL301 Unit' => 'TAEDEL301 Unit',
		'HLTINF001 Unit' => 'HLTINF001 Unit'),
	), $checkout->get_value( 'ccf_student_course' ));

// Date of Birth
woocommerce_form_field( 'ccf_course_extnd', array(
   'type'          => 'text',
   'required'  => true,
   'class'         => array('text ccf_course_extnd'),
   'label'         => __('Extend until - dd/mm/yyyy'),
   'placeholder'         => __('eg: 15/03/2015'),
), $checkout->get_value( 'ccf_course_extnd' ));

echo '<fieldset id="daveo_yeah">'; // Personal details end

echo '<style>fieldset#step2, fieldset#step5 {
    display: block;
    opacity: 1;
}</style>';