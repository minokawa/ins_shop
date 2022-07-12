<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see       https://docs.woocommerce.com/document/template-structure/
 * @author    WooThemes
 * @package   WooCommerce/Templates
 * @version     2.0.0
 */
global $woocommerce;

$cart_item_count =  0;
if (!is_shop()) { return '<ul class="products">'; }
if ( $woocommerce->cart->cart_contents_count > 0) { $cart_item_count = $woocommerce->cart->cart_contents_count; }
?>
  <h2 class="course-cat">So what would you like to study?
    <span id="cart_tools" class="loop">
      <a href="<?php echo home_url(); ?>/cart">View Cart (<?php echo $cart_item_count?>)</a>
      <?php if ( is_user_logged_in() ) {
        $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
        if ( $myaccount_page_id ) {
          $myaccount_page_url = get_permalink( $myaccount_page_id );

          $logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );
          if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' )
            $logout_url = str_replace( 'http:', 'https:', $logout_url );
        }
      ?>
        &nbsp; | &nbsp;<a href="<?php echo $myaccount_page_url; ?>" title="My Account">My Account</a>&nbsp; | &nbsp; <a href="<?php echo $logout_url; ?>" title="Log Out">Log Out</a>
      <?php } ?>
    </span>
  </h2>

  <?php
    if( get_field('shop_banner', 'options') ) { ?>
      <a href="<?php the_field('banner_link', 'options') ?>" id="shop_banner" class="banner_ad">
        <img src="<?php the_field('shop_banner', 'options'); ?>" />
      </a>
  <?php } ?>

  <h2 class='choose-cat-title'> Congratulations for choosing to Enrol with one of Australia's Leading Institutes!<br><b>First choose a category, then select your course…</b><span>Please use the icons below to navigate between completed steps</span></h2>

  <?php include( TEMPLATEPATH . '/woocommerce/checkout-steps.php' );  ?>

  <ul id="category-tabs-shop" class="shop clearfix">
