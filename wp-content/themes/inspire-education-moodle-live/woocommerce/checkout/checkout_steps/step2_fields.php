<?php
global $woocommerce;
$step2_billing_fields=array("billing_first_name","billing_middle_name","billing_last_name","address_label","billing_pname","billing_platno","billing_lotno","billing_sname","billing_country","billing_state","billing_city","billing_postcode","billing_email","billing_email_confirm","billing_home_phone","billing_work_phone","billing_mobile_phone","billing_work_mobile");

//BASE STEP 2 FIELDS
foreach ($step2_billing_fields as $key) {
  switch ($key) {
    case 'address_label':
      echo '<h5>Home Address</h5>';
    break;
    case 'billing_home_phone':
      echo '<h5>Please provide at least one contact phone number</h5>';
woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
    break;
    case 'billing_email':
      // insert secondary address toggle before 'billing_email' secondaryaddress
      echo '<div class="checkbox home-address-toggle"><h5 class="no-margin">Do you have a postal address different from your home address?</h5>
            <p class="form-row full no-margin" id="secondry-address">
              <input id="secondry-address-checkbox" class="input-checkbox" type="checkbox" name="secondry-address" />
              <label for="secondry-address-checkbox" class="checkbox">Yes</label>
            </p></div><div class="secondary_address secondary-address-group"> <h3 class="no-margin">Postal Address</h3>';
      include( get_template_directory().'/woocommerce/checkout/checkout_steps/step_2_partials/secondary_address_fields.php');
      echo '</div>';

      echo '<h5>Contact Details</h5>';
      woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
    break;
    default:
      woocommerce_form_field( $key, $checkout->checkout_fields['billing'][$key], $checkout->get_value( $key ) );
  }
}

//VARIANT STEP 2 FIELDS
//ADDITIONAL FIELDS TRIGGERED BY CART ITEM CATEGORY
$prod_ids = array();
$cats_cart = array();
$is_renewal = ma_is_subscription_renewal();

foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
  $_product = $values['data'];
  $product_id = $_product->get_id();
  $prod_ids[] = $product_id;
  $terms = get_the_terms( $product_id, 'product_cat' );

  foreach ($terms as $term) {
    $product_cat_id = $term->term_id;
    $product_cat_slug = $term->slug;
    $cats_cart[] = $product_cat_id;
  }
}

$comma_separated = implode(",", $cats_cart);
$array1 = $cats_cart;

if (empty($cats_cart)) {  $array1 = array("a" => '1');}

//WTF IS THIS ARRAY2???
$array2 = array("b" => '462', '463', '466', '502');
$result = array_diff($array1, $array2);

//THIS CONDITIONS BREAK WHEN ALL CATEGORIES ARE IN THE CART!!!!
if (empty($result) || $is_renewal) {
  include( get_template_directory().'/woocommerce/checkout/checkout_steps/step_2_partials/hardware_checkout.php');
} elseif (in_array('472', $cats_cart)) {
  include( get_template_directory().'/woocommerce/checkout/checkout_steps/step_2_partials/courseextension_checkout.php');
} else {
  include( get_template_directory().'/woocommerce/checkout/checkout_steps/step_2_partials/generalproduct_checkout.php');
}
