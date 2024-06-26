<?php
/**
 * * Updated 8/29/21 for version 5.6.0
 *
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
// Custom:
//$item_num = $wp_query->current_post +1;
?>
<div <?php wc_product_class( ['col-md-3 mb-4 mb-md-5'], $product ); ?>>
    <div class="card h-100">
        <div class="card-body d-flex flex-column p-0">
<!-- <li <?php //wc_product_class( 'h-100', $product ); ?>> -->
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action( 'woocommerce_before_shop_loop_item' );

    /**
     * Hook: woocommerce_before_shop_loop_item_title.
     *
     * @hooked woocommerce_show_product_loop_sale_flash - 10
     * @hooked woocommerce_template_loop_product_thumbnail - 10
     */
    do_action( 'woocommerce_before_shop_loop_item_title' );

    /**
     * Hook: woocommerce_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_product_title - 10
     */
    do_action( 'woocommerce_shop_loop_item_title' );

    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );

    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>

    <!-- Container (After Title) -->
    <div class="text-center">
    
    <!-- Attributes -->
    <?php if (get_field('post_product_gun_weight')) { ?>
        <p class="mb-1 mb-md-0"><strong>Weight: </strong></p>
        <p><?php echo get_field('post_product_gun_weight'); ?>lbs</p>
    <?php } ?>

    <?php if (get_field('post_product_gun_exterior_depth')) { ?>
        <p class="mb-1 mb-md-0"><strong>Exterior Dimensions: </strong></p>
            <p>
            <?php echo get_field('post_product_gun_exterior_height'); ?>"(H) x
            <?php echo get_field('post_product_gun_exterior_width'); ?>"(W) x
            <?php echo get_field('post_product_gun_exterior_depth'); ?>"(D)</p>
            </p>
    <?php } ?>

    <!-- Button trigger modal -->
    <div class="text-center mx-auto mb-4 mt-auto pt-4 pb-3">
        <?php echo get_product_inquiry_btn($post->ID, 'Product Inquiry'); ?>
    </div>

    </div>

    </div>
</div>
</div>
<!-- </li> -->
