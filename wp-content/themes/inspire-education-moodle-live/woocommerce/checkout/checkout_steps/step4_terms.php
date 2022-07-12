<?php

echo '<fieldset id="step4" class="tab-pane fade"><h1 class="course-title">'.__('Applicant Declaration').'</h1><div class="checkbox clearfix"><p>';

print get_the_content_by_id(9172);
echo '</p> <br>';
// Agree to terms
woocommerce_form_field_checkbox( 'ccf_terms_agree', array(
'type' => 'select',
'label' => __( '' ),
'placeholder' => __( '' ),
'required' => true,
'options' => array(
  'Yes' => 'Check to accept the above terms'

)), $checkout->get_value( 'ccf_terms_agree' ) );

echo '</div><a class="previous" data-prev-block="3" data-current-block="4">Previous Step</a> <a class="next" id="next-terms" data-current-block="4" data-next-block="5">Next Step</a> ';
echo '</fieldset>';
