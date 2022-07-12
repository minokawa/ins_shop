<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>

<?php if ( $product->is_type( 'simple' )) { ?>
	<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="simple-price">

		<p itemprop="price" class="price" <?php if ($product->is_on_sale()){ ?> style="color: rgb(255, 0, 0);"<?php } ?>><?php echo $product->get_price_html(); ?>

			<?php
					$price_detail =  get_field('pricing_detail', $post->ID);
					if($price_detail != 'None'){	echo $price_detail; }
			?>
		</p>

		<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
		<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

	</div>
<?php } else { // subscription products show price seperately ?>
	<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
<?php } ?>
