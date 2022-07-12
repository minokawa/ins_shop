<?php

  global $woocommerce;

  $prod_ids = array();
  $cats_cart = array();
 // $is_renewal = ma_is_subscription_renewal();

  // Find the id('s) of the product(s) in the cart
  foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
    $_product = $values['data'];
    $product_id = $_product->get_id();
    $prod_ids[] = $product_id;
    $skuid = get_post_meta( $product_id, '_sku', true );
    $terms = get_the_terms( $product_id, 'product_cat' );
    foreach ($terms as $term) {
      $product_cat_id = $term->term_id;
      $product_cat_slug = $term->slug;
      $cats_cart[] = $product_cat_id;
    }
  }

  $comma_separated = implode(",", $cats_cart);
  $array1 = $cats_cart;
  $array2 = array("b" => '462', '463', '466', '502');
  $result = array_diff($array1, $array2);

  if (!empty($result) || !$is_renewal) {
    $student_details_opening = '<input type="hidden" name="custom_id" class ="input-text  garlic-auto-save">';
    $student_details_title =  '<h5 class="form-title"> Student Details <span style="font-size:10px;font-weight: bold; ">Please enter your details for enrolment.</span> </h5>';

    if($product_cat_slug == 'workshop_event') {
      $student_details_opening =  '<p style="font-size:12px;font-weight: bold; "></p><p class=""><h5 class="form-titlea" style="font-size:14px;font-weight: bold; ">Please enter your Student ID in the space provided below and click the Submit button.</span></h5><input type="text" name="custom_id" id="custom_id" class ="input-text  garlic-auto-save"></p><p><a href="javascript:void(0);"  id ="smuid" class="checkout-button " style="    border: 1px solid #cccccc; background-repeat: repeat-x;background-image: linear-gradient(to bottom, #ffffff, #e6e6e6); display: inline-block;    float: left;    padding: 6px 14px;    margin: 10px;    font-size: 14px;    line-height: 20px;    color: #333333;    text-align: center;    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);    vertical-align: middle;    cursor: pointer;    background-color: #f5f5f5;" value="submit" >Submit</a></p><input type="hidden" id="sku_iid" name="sku_iid" value="'.$skuid.'" class ="input-text  garlic-auto-save"><div id="myerrormsg" style="color:red;" >This User Id is not enrolled for this Course</div>';
    }

    if($product_cat_slug == 'workshop_event'){
      $student_details_title = '<h5 class="form-title"> Student Details <span style="font-size:14px;font-weight: bold; ">Review your student details below, make any necessary changes and click the Next button at the bottom of the page.</span> </h5>';
    }

    echo $student_details_opening;
    echo $student_details_title;
  }
