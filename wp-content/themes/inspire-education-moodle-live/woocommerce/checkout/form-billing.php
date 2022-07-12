<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */
  if ( ! defined( 'ABSPATH' ) ) exit;
?>

<fieldset id="step2" class="tab-pane fade">
	<h1 class="course-title">Personal Details</h1>
	<div class="section clearfix">
    <?php  include('checkout_steps/step2_opening_messages.php') ?>
    <div class="hello checkout-form-personal-details">
      <?php include('checkout_steps/step2_fields.php') ?>
    </div>
</fieldset>
