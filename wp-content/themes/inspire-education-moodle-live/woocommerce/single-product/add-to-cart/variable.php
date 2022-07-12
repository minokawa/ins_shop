<?php
/**
 * Variable product add to cart
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $woocommerce, $product, $post;


$attribute_keys = array_keys( $attributes );

do_action('woocommerce_before_add_to_cart_form'); ?>


 <?php
 $ctr = 0;
 foreach($available_variations as $item) {

    $price_string = $item["price_html"];

    if (strpos($price_string, 'with 1 month free trial and a') !== false) {

        $sign_up_cost = $product->product_custom_fields['_subscription_sign_up_fee'];
        $pattern[0] = '/with 1 month free trial and a/';
        $replacement[0] = '';

        // $trial = strstr($price_string, 'with', true);


        $price{$ctr} = '$<span itemprop="price">'.$sign_up_cost[0].'</span> sign-up fee & '.strstr($price_string, 'with', true);
        // $price{$ctr} .= preg_replace($pattern, $replacement, $price_string);

    } elseif (strpos($price_string, 'Free!') !== false) {

        $price{$ctr} = '';

        $sign_up_sale_cost = get_post_meta( $product->get_id, 'woo-orig-price', true );

        $pattern[0] = '/and a/';
        $replacement[0] = '';

        $removefree = preg_replace($pattern, $replacement, $price_string);

        $pattern2[0] = '/Free!/';
        $replacement2[0] = '';

        if ($sign_up_sale_cost) {

            $price{$ctr} .= '<del style="color: rgb(255, 0, 0);">$'.$sign_up_sale_cost.'</del>';

        }
        $price{$ctr} .= preg_replace(
            $pattern2,
            $replacement2,
            $removefree);
        $price{$ctr} .= '<span style="color: rgb(255, 0, 0);">one off payment!</span>';


    } else {

        $price{$ctr} = '<span itemprop="price">' . $item["price_html"] . '</span>';

        if(is_single('55382')) {

            // var_dump($item);

            if($item["attributes"]["attribute_co-contribution-fee"] !=='') {

                $price{$ctr} .= ' - <span class="price">'.$item["attributes"]["attribute_co-contribution-fee"].'</span>';
            }

        }

    }

        // $price{$ctr} = $item["price_html"];
    $ctr++;

    // added from moodle
    $key_1_value = get_post_meta( $product->get_id, 'last_event_price_true', true );
    $caters = get_the_terms( $post->ID, 'product_cat' );

    if (is_array($key_1_value) || is_object($caters))
    {
        foreach($caters as $cater) { $cat_ids[] = $cater->term_id; }
        if( $key_1_value == 'true_event_price' && in_array('476',$cat_ids) ) {
            $cc = "last_price_varible";
        } else {
            $cc = '';
        }
    }


} ?>
<form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
    <div class="variations  <?php if(!empty($cc)) { echo $cc; } ?>">
            <?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>

					<h3>Payment plans</h3>
                    <fieldset itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="AUD" />
                        <p class="full"><em>Please choose your preferred payment option below!</em></p>
                        <?php
                            if ( is_array( $options ) ) {

                                if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
                                    $selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
                                } elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
                                    $selected_value = $selected_attributes[ sanitize_title( $name ) ];
                                } else {
                                    $selected_value = '';
                                }

                                // Get terms if this is a taxonomy - ordered
                                if ( taxonomy_exists( $name ) ) {

                                    $orderby = wc_attribute_orderby( $name );

                                    switch ( $orderby ) {
                                        case 'name' :
                                            $args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
                                        break;
                                        case 'id' :
                                            $args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
                                        break;
                                        case 'menu_order' :
                                            $args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
                                        break;
                                    }

                                    $terms = get_terms( $name, $args );

                                    foreach ( $terms as $term ) {
                                        if ( ! in_array( $term->slug, $options ) )
                                            continue;
                                        // echo '<input type="radio" value="' . apply_filters( 'woocommerce_variation_option_name', $option ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . ' id="'. esc_attr( sanitize_title($name) ) .'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '<br />';
                                        echo '<input class="turk" type="radio" value="' . apply_filters( 'woocommerce_variation_option_name', $option ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . ' id="'. esc_attr( sanitize_title($name) ) .'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $option ) . '<br />';
                                        // echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
                                    }
                                } else {

                                    $tick = 0;
                                    foreach ( $options as $option ) {

                                        if (sanitize_title($name) == 'print-options') {
                                            $variation_type = '<span class="price">'. apply_filters( 'woocommerce_variation_option_name', $option ) .'</span> -';
                                        } else {
                                            $variation_type = null;
                                        }


                                        echo '<label itemprop="price" class="raverface" for="attribute_'. sanitize_title($name).'-'. esc_attr( $post->ID ) .'-'.$tick.'">
                                        <input type="radio" value="' . apply_filters( 'woocommerce_variation_option_name', $option ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . ' id="attribute_'. sanitize_title($name).'-'. esc_attr( $post->ID ) .'-'.$tick.'" name="attribute_'. sanitize_title($name).'">'. $variation_type .' ' . $price{$tick} . '</label>';

                                        $tick++;
                                    }

                                }



        //                         if ( empty( $_POST ) )
        //                             $selected_value = ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) ? $selected_attributes[ sanitize_title( $name ) ] : '';
        //                         else
        //                             $selected_value = isset( $_POST[ 'attribute_' . sanitize_title( $name ) ] ) ? $_POST[ 'attribute_' . sanitize_title( $name ) ] : '';
								// //echo   $selected_value;
        //                         // Get terms if this is a taxonomy - ordered
        //                         if ( taxonomy_exists( sanitize_title( $name ) ) ) {

        //                             $terms = get_terms( sanitize_title($name), array('menu_order' => 'ASC') );

        //                             foreach ( $terms as $term ) {
        //                                 if ( ! in_array( $term->slug, $options ) ) continue;
        //                                 echo '<input type="radio" value="' . strtolower($term->slug) . '" ' . checked( strtolower ($selected_value), strtolower ($term->slug), false ) . ' id="'. esc_attr( sanitize_title($name) ) .'" name="attribute_'. sanitize_title($name).'">' . apply_filters( 'woocommerce_variation_option_name', $term->name ).'<br />';
        //                             }
        //                         } else {
        //                             $tick = 0; foreach ( $options as $option ) {
        //                                 echo '<label for="attribute_'. sanitize_title($name).'-'. esc_attr( $post->ID ) .'-'.$tick.'"><input type="radio" value="' .esc_attr( sanitize_title( $option ) ) . '" ' . checked( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . ' id="attribute_'. sanitize_title($name).'-'. esc_attr( $post->ID ) .'-'.$tick.'" name="attribute_'. sanitize_title($name).'"> ' . $price{$tick} . '</label>';$tick++;
        //                             }

        //                         }
                            }
                        ?>
                    </fieldset>  <?php
                        if ( sizeof($attributes) == $loop )
                            //echo '<a class="reset_variations" href="#reset">'.__('Clear selection', 'woocommerce').'</a>';
                    ?>
            <?php endforeach;?>
 	</div>
    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

        <div class="single_variation_wrap">
            <?php do_action( 'woocommerce_before_single_variation' ); ?>

            <div class="single_variation"></div>

            <div class="turkey variations_button">
                <?php woocommerce_quantity_input(); ?>
                <button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
            </div>

            <input type="hidden" name="add-to-cart" value="<?php echo $product->get_id; ?>" />
            <input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
            <input type="hidden" name="variation_id" value="" />

            <?php do_action( 'woocommerce_after_single_variation' ); ?>
        </div>

        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>


</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
