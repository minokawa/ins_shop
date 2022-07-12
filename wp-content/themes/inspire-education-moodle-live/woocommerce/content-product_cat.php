<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {	exit;}

global $woocommerce_loop;
if ( empty( $woocommerce_loop['loop'] ) ) {	$woocommerce_loop['loop'] = 0; }
if ( empty( $woocommerce_loop['columns'] ) ) { 	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 ); }
if($category->slug === 'uncategorised') { return ''; }

if (is_shop()) {
  $woocommerce_loop['loop'] ++;
  $single = 'opportunity';
  $category_image = '';
  $item_type = 'study';
  $cat_thumb_id  =  get_term_meta($category->term_id, 'thumbnail_id', true);
  $image = wp_get_attachment_image_src($cat_thumb_id);

  if ($category->count > 1) {  $single = 'opportunities'; }
  if ( $image ) { $category_image = '<img src="' . $image[0] . '" alt="" width="80" height="80" />'; }
  if(in_array($category->term_id, array('462', '463', '466', '502') )){ $item_type = 'product'; }
?>

    <li class="category-<?php echo $category->slug; ?>">
      <a class="<?php echo $category->slug; ?>" data-toggle="modal" data-target="#cart-modal-shop">
        <?php
          echo $category->name;
          if ( $category->count > 0 && $item_type === 'product'){
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count"><strong>' . $category->count . '</strong> products available!!</span>', $category );
          }
          if ( $category->count > 0  && $item_type === 'study') {
            // Fetch cookie. If existing, replace number for category count
            $actual_count = '';//$_COOKIE['eventCount'] ?: $category->count;
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count"><strong>' . $category->count. '</strong> study '.$single.' available!!</span>', $category );
          }
          echo $category_image;
        ?>
      </a>
    </li>

<?php } else {

  $product_class_suffix = '';
  $subcategory_count_html = '';
  if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1 ){ $product_class_suffix = ' first';  }
  if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 ){ $product_class_suffix =  'last'; }
  if ( $category->count > 0 ){ $subcategory_count_html = apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category ); }
?>
    <li class="product-category product<?php echo $product_class_suffix;?>">
      <?php do_action( 'woocommerce_before_subcategory', $category ); ?>
      <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
        <?php do_action( 'woocommerce_before_subcategory_title', $category ); ?>
        <h3> <?php  echo $category->name; echo $subcategory_count_html; ?> </h3>
        <?php do_action( 'woocommerce_after_subcategory_title', $category ); ?>
      </a>
      <?php do_action( 'woocommerce_after_subcategory', $category ); ?>
    </li>

<?php } ?>
