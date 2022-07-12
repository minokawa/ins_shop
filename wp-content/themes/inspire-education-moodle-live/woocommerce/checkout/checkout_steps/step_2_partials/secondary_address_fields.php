<?php

$country_options = get_woo_country_options();
  woocommerce_form_field( 'ccf_add_two_pname', array(
    'type'          => 'text',
    'required'  => false,
    'class'         => array('text required ccf_add_two_pname'),
    'label'         => __('Building/property name'),
    'placeholder'         => __('Building/property name'),
  ), $checkout->get_value( 'ccf_add_two_pname' ));

  woocommerce_form_field( 'ccf_add_two_unumber', array(
    'type'          => 'text',
    'required'  => false,
    'class'         => array('text required ccf_add_two_unumber'),
    'label'         => __('Flat/unit number'),
    'placeholder'         => __('Flat/unit number'),
  ), $checkout->get_value( 'ccf_add_two_unumber' ));

  woocommerce_form_field( 'ccf_add_two_lnumber', array(
    'type'          => 'text',
    'required'  => false,
    'class'         => array('text required ccf_add_two_lnumber'),
    'label'         => __('Street/Lot Number'),
    'placeholder'         => __('Street/Lot Number'),
  ), $checkout->get_value( 'ccf_add_two_lnumber' ));

  woocommerce_form_field( 'ccf_add_two_sname', array(
    'type'          => 'text',
    'required'  => false,
    'class'         => array('text required ccf_add_two_sname'),
    'label'         => __('Street Name'),
    'placeholder'         => __('Street Name'),
  ), $checkout->get_value( 'ccf_add_two_sname' ));

  woocommerce_form_field( 'ccf_add_two_pdbox', array(
    'type'          => 'text',
    'required'  => false,
    'class'         => array('text required ccf_add_two_pdbox'),
    'label'         => __('Postal Delivery Information (e.g. PO Box 254)'),
    'placeholder'         => __('Postal Delivery Box'),
  ), $checkout->get_value( 'ccf_add_two_pdbox' ));

  woocommerce_form_field( 'ccf_add_two_sub', array(
    'type'          => 'text',
    'required'  => true,
    'class'         => array('text required ccf_add_two_sub'),
    'label'         => __('Suburb'),
    'placeholder'         => __('eg: Happy Suburb'),
  ), $checkout->get_value( 'ccf_add_two_sub' ));

  woocommerce_form_field( 'ccf_add_two_state', array(
    'type'          => 'select',
    'required'  => true,
    'class'         => array('text required ccf_add_two_state'),
    'label'         => __('State '),
    'options'     => array(
      '' => __('Select state...', 'woocommerce' ),
      'ACT' => __('ACT', 'woocommerce' ),
      'New South Wales' => __('New South Wales', 'woocommerce' ),
      'Northern Territory' => __('Northern Territory', 'woocommerce' ),
      'Queensland' => __('Queensland', 'woocommerce' ),
      'South Australia' => __('South Australia', 'woocommerce' ),
      'Tasmania' => __('Tasmania', 'woocommerce' ),
      'Victoria' => __('Victoria', 'woocommerce' ),
      'Western Australia' => __('Western Australia', 'woocommerce' ),
      'Other' => __('Other', 'woocommerce' )
    ),
  ), $checkout->get_value( 'ccf_add_two_state' ));

  woocommerce_form_field( 'ccf_add_two_country', array(
    'type'          => 'select',
    'required'  => true,
    'class'         => array('text required ccf_add_two_country'),
    'label'         => __('Country '),
    'options'     => $country_options,
  ), $checkout->get_value( 'ccf_add_two_country' ));

  // Post Code
  woocommerce_form_field( 'ccf_add_two_post', array(
      'type'          => 'text',
      'required'  => true,
      'class'         => array('text required ccf_add_two_post'),
      'label'         => __('Postcode'),
      'placeholder'         => __('eg: 4012'),
  ), $checkout->get_value( 'ccf_add_two_post' ));
