<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$custom_related = get_field('related_safes');

if (count($custom_related) > 1) { ?>

    <div class="row text-center my-3">
        <div class="col">
            <h3>Check out these related products:</h3>
        </div>
    </div>

    <div class="row row-cols-<?php echo count($custom_related); ?> sub-category-list">

        <?php
        foreach ($custom_related as $related) {
            echo safe_grid_item($related->ID, null);
        }
        ?>

    </div>


<?php

} else {


    if ( $related_products ) : ?>

        <section class="related products test">

            <?php
            $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

            if ( $heading ) :
                ?>
                <h2><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php foreach ( $related_products as $related_product ) : ?>

                <?php
                $post_object = get_post( $related_product->get_id() );

                if (!substr_count(get_the_title($post_object->ID), "FV")) {
                    setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                    wc_get_template_part( 'content', 'product' );
                }
                ?>

            <?php endforeach; ?>

            <?php woocommerce_product_loop_end(); ?>

        </section>
    <?php
    endif;

    wp_reset_postdata();
}


