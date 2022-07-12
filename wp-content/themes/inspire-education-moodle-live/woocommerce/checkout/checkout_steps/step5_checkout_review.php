<?php

  //THIS IS STEP 5
  echo '<fieldset id="step5" class="tab-pane fade"><h1 class="course-title">'.__('Checkout').'</h1><p style="width:100%"><b>Having trouble enrolling online?</b> Download a manual enrolment for here >> <a href="'.get_stylesheet_directory_uri().'/Student Enrolment Form - Revised.pdf" target="_blank">here</a></p>';
  echo '<p class="full">Is the below order correct? If not, you can amend your order by <a class="click-cart-modal" title="cart" data-toggle="modal" data-target="#cart-modal">clicking here</a></p>';
  do_action( 'woocommerce_checkout_order_review' );
  if ($result || !$is_renewal) {  echo '<hr><a class="previous" data-prev-block="4" data-current-block="5">Previous Step</a>';  }
  echo '</fieldset>';
