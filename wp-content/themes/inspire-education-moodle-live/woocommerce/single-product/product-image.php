<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $woocommerce, $product;

?>
<div class="images product-thumb">
	<?php
		if ( has_post_thumbnail() ) {
			$attachment_count = count( $product->get_gallery_image_ids() );
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	 => $props['title'],
				'alt'    => $props['alt'],
			) );
			echo apply_filters(
				'woocommerce_single_product_image_html',
				sprintf(
					'<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto%s">%s</a>',
					esc_url( $props['url'] ),
					esc_attr( $props['caption'] ),
					$gallery,
					$image
				),
				$post->ID
			);
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}

		do_action( 'woocommerce_product_thumbnails' );
	?>

		<?php if ( $product->is_type( 'simple' )) : ?>
			<div class='two-column-layout'>
				<div class='column'>
					<?php wc_get_template( 'single-product/price.php' ); ?>
				</div>
				<div class='column'>
					<?php wc_get_template( 'single-product/add-to-cart/simple.php' ); ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="CTA-sidebar"><h3>IMPORTANT:</h3>If you have an <span class="highlight1"> additional discount voucher</span>  code, <span class="highlight2"> "Enrol Now"</span> and <b>enter it on the next page</b> </div>

</div>
