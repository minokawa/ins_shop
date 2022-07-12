<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
	<?php

	  if( get_field('shop_banner', 'options') ): ?>

	    <a href="<?php the_field('banner_link', 'options') ?>" id="shop_banner" class="banner_ad">

	      <img src="<?php the_field('shop_banner', 'options'); ?>" />

	    </a>

	<?php endif; ?>

  	<h2 class="course-cat">Inspire Products

        <span id="cart_tools">
          <a href="/cart/" target="_blank">View Cart (<?php
            if (sizeof($woocommerce->cart->get_cart())>0) :

              echo $woocommerce->cart->cart_contents_count;

            endif;
          ?>)</a>
          <?php if ( is_user_logged_in() ) {

            $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
            if ( $myaccount_page_id ) {
              $myaccount_page_url = get_permalink( $myaccount_page_id );

              $logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );
              if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' )
                $logout_url = str_replace( 'http:', 'https:', $logout_url );
            } ?>

            &nbsp; | &nbsp;<a href="<?php echo $myaccount_page_url; ?>" title="My Account">My Account</a>&nbsp; | &nbsp;
              <a href="<?php echo $logout_url; ?>" title="Log Out">Log Out</a>

          <?php } else { ?>
            &nbsp; | &nbsp; <a href="#" class="showlogin">Click here to login</a>
          <?php } ?>

        </span>

    </h2>

<div id="product-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>

	<div class="summary entry-summary">

		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
		<hr>
		<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	</div><!-- .summary -->

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
