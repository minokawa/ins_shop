<?php
echo '<div class="checkbox clearfix"><p>';
woocommerce_form_field( 'ccf_terms_agree_hardware', array(
  'type'          => 'checkbox',
  'class'         => array('input-checkbox'),
  'label'         => __('Check to accept the terms outlined <a href="https://www.inspireeducation.net.au/purchase-terms-and-conditions/" target="_blank" title="Agree to terms">here</a>.'),
  'required'  => true,
  ), $checkout->get_value( 'ccf_terms_agree_hardware' ));
echo '</p></div>';
echo '<fieldset id="daveo_yeah">'; // Personal details end
