<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce;
$result = get_product_cats();
$cart_size = sizeof($woocommerce->cart->get_cart());

if(!isset($_COOKIE['checkout_step'])){
	setcookie('checkout_step', 'step2', time() + (86400 * 30), "/");
}

?>

<div id="rootwizard" class="form-nav slide" <?php if(is_shop()) {echo 'style="margin-top: 0px;"';} ?>>
<?php
	if (is_product()) {return ''; }
	if (empty($result)) { return ''; }
	if (in_array('472', $result)) {  return '';   } // If is any other product and enrolment needs to take place...
	if ($cart_size == 0) {return ''; }
	$home_url = home_url();
	$checkout_url = $home_url . '/checkout/';

	$steps = 	array(
		"2" => array('title' => 'Personal details','li_id' => 'check-nav-personal','anchor_class' => 'class="next-personal"','link' => '#step2'),
		"3" => array('title' => 'Additional info','li_id' => 'check-nav-additional','anchor_class' => 'class="next-additional"','link' => '#step3'),
		"4" => array('title' => 'Terms','li_id' => 'check-nav-terms','anchor_class' => 'class="next-terms"','link' => '#step4'),
		"5" => array('title' => 'Checkout','li_id' => 'check-nav-check','anchor_class' => '','link' => '#step5')
	);

?>
<div class="mobile-sticky" <?php if(is_shop()) {echo 'style="height: 60px;padding-top:0px"';} ?>>
  <div class="user-links " >
        <?php
          $cart_item_count = 0;
          if (sizeof($woocommerce->cart->get_cart())>0 && !is_shop()) {
            $cart_item_count =  $woocommerce->cart->cart_contents_count;
            echo '<a href="#" data-toggle="modal" data-target="#cart-modal">View Cart (' . $cart_item_count . ')</a>';

            $user_account_links = '<a href="#" class="showlogin">Click here to login</a>';
            $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
            if ( is_user_logged_in() ) {
              if ( $myaccount_page_id ) {
                $myaccount_page_url = get_permalink( $myaccount_page_id );
                $logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );
                if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ){ $logout_url = str_replace( 'http:', 'https:', $logout_url );}
              }
              $user_account_links = '<a href="'.$myaccount_page_url.'" title="My Account">My Account</a> <a href="'.$logout_url.'" title="Log Out">Log Out</a>';
            }
            echo $user_account_links;
          }

        ?>
  </div>

<ul id="checkout-steps" class="">
	<li  data-fieldset="1" class="step-1 step">
		<a data-fieldset="1" href="<?php echo $home_url; ?>/shop/">Step 1 <span> Select a course</span></a>
		<div class="icon"></div>
	</li>

	<?php
		foreach($steps as $key => $val){
			$link =  $val['link'];
			$class = '';
			if (is_shop()) {
				$link = $checkout_url;
				$class = $val['anchor_class'];;
			}
	?>
			<li data-fieldset="<?php echo $key ?>" id="<?php echo $val['li_id']?>" class="step-<?php echo $key?> step link">
				<a data-fieldset="<?php echo $key ?>" href="<?php echo $link; ?>" <?php echo $class; ?>> Step <?php echo $key; ?> <span> <?php echo $val['title']?> </span></a>
				<div class="icon"></div>
			</li>
	<?php
		}
	?>
</ul>

</div>

<?php
	if (is_checkout()) {
?>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      var checkout_step= Cookies.get('checkout_step');
      if(typeof checkout_step !='undefined' && checkout_step!=''){
        $(".tab-pane").removeClass('active');
        $(".tab-pane").addClass('in');
          $("#"+checkout_step).addClass('active');
        $("#"+checkout_step).addClass('in');
      }

      var clickable_steps = $('#checkout-steps');
      clickable_steps.find('li').addClass('in active');
      clickable_steps.find('li[data-fieldset="' + checkout_step.substring(4) + '"] ~ li').removeClass('active in');

      clickable_steps.find('a').removeClass('selected');
      clickable_steps.find('a[data-fieldset="' + checkout_step.substring(4) + '"]').addClass('selected');
    });
  </script>
<?php
  }else{
?>
    <script type="text/javascript">
        var clickable_steps = $('#checkout-steps');


        clickable_steps.find('li[data-fieldset="1"]').addClass('active in');

        clickable_steps.find('a[data-fieldset="1"]').addClass('selected');
    </script>
<?php
  }
?>

