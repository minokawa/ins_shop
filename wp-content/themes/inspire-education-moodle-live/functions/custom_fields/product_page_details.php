<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_62560e94b11d1',
	'title' => 'Product Page Price Details',
	'fields' => array(
		array(
			'key' => 'field_62560ec17ced9',
			'label' => 'Pricing Detail',
			'name' => 'pricing_detail',
			'type' => 'radio',
			'instructions' => 'Appears beside the purchase options in product pages.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'None' => 'None',
				'one off payment!' => 'one off payment!',
				'first payment only' => 'first payment only',
        'Massively Reduced' => 'Massively Reduced',
        'Lowest Fee' => 'Lowest Fee'
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
