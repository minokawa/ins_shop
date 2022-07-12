<?php
/**
* Variable subscription product add to cart
*
* @author Prospress
* @package WooCommerce-Subscriptions/Templates
* @version 2.0.9
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function dashesToCamelCase($string, $capitalizeFirstCharacter = true) {

    $str = ucwords(str_replace('-', ' ', $string));

    if (!$capitalizeFirstCharacter) {
        $str[0] = strtolower($str[0]);
    }

    return $str;
}




if ( ! function_exists( 'print_attribute_radio' ) ) {
    function print_attribute_radio( $checked_value, $value, $label, $name, $key  ) {
        // This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
        $checked = sanitize_title( $checked_value ) === $checked_value ? checked( $checked_value, sanitize_title( $value ), false ) : checked( $checked_value, $value, false );

        $input_name = 'attribute_' . esc_attr( $name ) ;
        $esc_value = esc_attr( $value );
        $id = esc_attr( $name . '_v_' . $value );
        $filtered_label = dashesToCamelCase( $label );

        printf( '<label for="%3$s"><input type="radio" class="radio-variation" name="%1$s" value="%2$s" data-key="%3$s" id="%4$s" %5$s>%6$s</label>', $input_name, $esc_value,$key , $id, $checked, $filtered_label );
    }
}


global $product;



$attribute_keys = array_keys( $attributes );
$user_id        = get_current_user_id();

do_action( 'woocommerce_before_add_to_cart_form' ); ?>


<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wcs_json_encode( $available_variations ) ) ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

			<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
				<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce-subscriptions' ); ?></p>
			<?php else : ?>
				<?php if ( ! $product->is_purchasable() && 0 !== $user_id && 'no' !== wcs_get_product_limitation( $product ) && wcs_is_product_limited_for_user( $product, $user_id ) ) : ?>
					<?php $resubscribe_link = wcs_get_users_resubscribe_link_for_product( $product->get_id() ); ?>
					<?php if ( ! empty( $resubscribe_link ) && 'any' === wcs_get_product_limitation( $product ) && wcs_user_has_subscription( $user_id, $product->get_id(), wcs_get_product_limitation( $product ) ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'active' ) && ! wcs_user_has_subscription( $user_id, $product->get_id(), 'on-hold' ) ) : // customer has an inactive subscription, maybe offer the renewal button. ?>
						<a href="<?php echo esc_url( $resubscribe_link ); ?>" class="woocommerce-button button product-resubscribe-link"><?php esc_html_e( 'Resubscribe', 'woocommerce-subscriptions' ); ?></a>
					<?php else : ?>
						<p class="limited-subscription-notice notice"><?php esc_html_e( 'You have an active subscription to this product already.', 'woocommerce-subscriptions' ); ?></p>
					<?php endif; ?>
				<?php else : ?>



                <table class="variations" cellspacing="0">
                    <tbody>
                        <?php foreach ( $attributes as $name => $options ) : ?>
                            <tr>
                                <h3>Payment plans </h3>
                                <td class="value">
                                <?php
                                $sanitized_name = sanitize_title( $name );
                                if ( isset( $_REQUEST[ 'attribute_' . $sanitized_name ] ) ) {
                                    $checked_value = $_REQUEST[ 'attribute_' . $sanitized_name ];
                                } elseif ( isset( $selected_attributes[ $sanitized_name ] ) ) {
                                    $checked_value = $selected_attributes[ $sanitized_name ];
                                } else {
                                    $checked_value = '';
                                }

                                ?>
                                    <?php
                                    if ( ! empty( $options ) ) {
                                        if ( taxonomy_exists( $name ) ) {
                                            // Get terms if this is a taxonomy – ordered. We need the names too.
                                            $terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'all' ) );

                                            foreach ( $terms as $term ) {
                                                if ( ! in_array( $term->slug, $options ) ) {
                                                    continue;
                                                }
                                                print_attribute_radio( $checked_value, $term->slug, $term->name, $sanitized_name,0 );
                                            }
                                        } else {
                                            $tick = 0;
                                            foreach ( $options as $key => $option ) {
                                                $price = ma_customised_price_string($option);
                                                print_attribute_radio( $checked_value, $option, $price, $sanitized_name,$key  );
                                                $tick++;
                                            }
                                        }
                                    }

                                    echo end( $attribute_keys ) === $name ? apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . __( 'Clear', 'woocommerce' ) . '</a>' ) : '';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
								<?php
									/**
									 * Post WC 3.4 the woocommerce_before_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
									 */
									if (wcs_is_woocommerce_pre ( '3.4' ) ) {
										do_action( 'woocommerce_before_add_to_cart_button' );
									}
									?>

						<div class="single_variation_wrap">
							<?php
							/**
							 * woocommerce_before_single_variation Hook.
							 */
							do_action( 'woocommerce_before_single_variation' );

							/**
							 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
							 *
							 * @since  2.4.0
							 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
							 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
							 */
							do_action( 'woocommerce_single_variation' );

							/**
							 * woocommerce_after_single_variation Hook.
							 */
							do_action( 'woocommerce_after_single_variation' );
							?>
						</div>

						<?php
							/**
							 * Post WC 3.4 the woocommerce_after_add_to_cart_button hook is triggered by the callback @see woocommerce_single_variation_add_to_cart_button() hooked onto woocommerce_single_variation.
							 */
							if ( WC_Subscriptions::is_woocommerce_pre( '3.4' ) ) {
								do_action( 'woocommerce_after_add_to_cart_button' );
							}
						?>

        <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_after_variations_form' ); ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
