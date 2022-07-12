<?php
/*
Template Name: Checkout
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

  global $woocommerce;
  $prod_ids = array();
  $cats_cart = array();
  $is_renewal = ma_is_subscription_renewal();
  $array1 = $cats_cart;
  $array2 = array("b" => '462', '463', '466', '502');

  foreach($woocommerce->cart->get_cart() as $cart_item_key => $values ) {
    $_product = $values['data'];
    $product_id = $_product->get_id();
    $prod_ids[] = $product_id;
    $terms = get_the_terms( $product_id, 'product_cat' );
    foreach ($terms as $term) {
      $product_cat_id = $term->term_id;
      $cats_cart[] = $product_cat_id;
    }
  }

  if (empty($cats_cart)) { $array1 = array("a" => '1');}
  $result = array_diff($array1, $array2);
  get_header();
?>

<div id="content-wrap" class="clearfix wrapper">
  <div id="page" class="clearfix container">
    <div id="page-woo-checkout" class="section span-24">
      <?php
      if (have_posts()){
        while (have_posts()) { the_post(); ?>
          <div class="post" id="post-<?php the_ID(); ?>">
            <div class='checkout-intro'>
              <h2 class="course-cat"><?php the_title(); ?>
                <?php
                  $cart_item_count = 0;
                  if (sizeof($woocommerce->cart->get_cart())>0) { $cart_item_count =  $woocommerce->cart->cart_contents_count; }
                ?>
                <span id="cart_tools" class="dave">
                  <a href="#" data-toggle="modal" data-target="#cart-modal">Finalise Enrolments (<?php echo $cart_item_count ?>)</a>
                  <?php
                    $user_account_links = '&nbsp; | &nbsp; <a href="#" class="showlogin">Click here to login</a>';
                    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );

                    if ( is_user_logged_in() ) {
                      if ( $myaccount_page_id ) {
                        $myaccount_page_url = get_permalink( $myaccount_page_id );
                        $logout_url = wp_logout_url( get_permalink( $myaccount_page_id ) );

                        if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ){
                          $logout_url = str_replace( 'http:', 'https:', $logout_url );
                        }
                      }
                      $user_account_links = '&nbsp; | &nbsp;<a href="'.$myaccount_page_url.'" title="My Account">My Account</a>&nbsp; | &nbsp;<a href="'.$logout_url.'" title="Log Out">Log Out</a>';
                    }
                    echo $user_account_links;
                  ?>
                </span>
              </h2>

              <?php
              $cart_item_names = '';
              $is_thankyou_page = is_wc_endpoint_url('order-received');
                if ($result || !$is_renewal) {
                  foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
                    $_product = $cart_item['data'];
                    $cart_item_names .= $_product->get_title();
                  }
                  if(!$is_thankyou_page){
                  echo '<h2>To Enrol Now, fill out the form below....<br><span> Congratulations, for choosing to enrol in the <strong> <?php echo $cart_item_names; ?> </strong> with one of Australia\'s Leading Institutes!<br><a href="#" class="click-cart-modal" title="cart" data-toggle="modal" data-target="#cart-modal">Click here</a> if you need to review or change your course choice. </span></h2>
                  <p class="small">
									<b> HAVING TROUBLE ENROLLING ONLINE? -</b> If so, please GO <b>>>> <a href="https://www.inspireeducation.net.au/documents/Student%20Enrolment%20Form.pdf">HERE</a></b> to download an Enrolment Form - or call 1800 506 509 Now for Immediate Assistance! (or email us after hours)
									<br>
									<br>
									<b>WANT TO ENROL IN TWO COURSES AT THE SAME TIME? If so, you will need to checkout twice:</b> <br>1) Checkout and pay for your first course <br>2) Go back to the shop, select and checkout your second course
                  </p>';
                  }
                }
                the_content('<p>Read the rest of this page &raquo;</p>');
                wp_link_pages(array('before' => '<p>Pages: ', 'after' => '</p>', 'next_or_number' => 'number'));
              ?>
            </div>
          </div>
          <?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
      <?php
        };
      }
      ?>
    </div>
  </div>
</div>

<a href="" class="click-cart-modal hidden" data-toggle="modal" data-target="#cart-modal">open</a>
<div class="reveal-modal modal" id="cart-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <a href="#" class="close" data-dismiss="modal" aria-label="Close"><i class="far fa-times-circle"></i></a>
      <h2>Confirm your order</h2>
      <p>Please review the order details below, click the 'Update Cart' button to head over to your shopping cart so you can remove any unwanted items... otherwise click 'Proceed to Checkout' to purchase!</p>
      <?php do_action( 'woocommerce_before_mini_cart' ); ?>
      <ul class="cart_list product_list_widget">
        <?php
          $cart_item_markup = '<li class="empty"> No products in the cart. </li>';


          if ( $woocommerce->cart->get_cart_contents_count() > 0 ) {
            $cart_item_markup = '';
            foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $cart_item ) {
              $_product = $cart_item['data'];
              if ( !apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) || ! $_product->exists() || $cart_item['quantity'] == 0 ){  continue; }
              $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax($_product) : wc_get_price_including_tax($_product);
              $product_price = apply_filters( 'woocommerce_cart_item_price_html', wc_price( $_product ), $cart_item, $cart_item_key );
              $cart_item_markup .=  '<li>' . $_product->get_image('single_product_large_thumbnail_size') .  '<h2>' . apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product ) . '</h2><br>' . wc_get_formatted_cart_item_data( $cart_item ) .  '</li>';
            }
          }
          echo $cart_item_markup;
        ?>
      </ul>

      <?php
        if (  $woocommerce->cart->get_cart_contents_count()  > 0 )  { woocommerce_cart_totals(); ?>
          <p class="buttons">
            <a class="button" href="<?php echo home_url(); ?>/shop/">← Return To Shop</a><a href="<?php echo home_url(); ?>/cart" class="button"  title="Update Cart">Update Cart</a><a href="#" class="checkout-button button alt close-reveal-modal" data-dismiss="modal" title="Proceed to Checkout →">Proceed to Checkout →</a>
          </p>
      <?php } do_action( 'woocommerce_after_mini_cart' );  ?>
    </div>
  </div>
</div>

<?php get_footer();
