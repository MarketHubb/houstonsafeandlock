<?php
set_query_var('modal_callouts', 'callouts-safes');
set_query_var('modal_heading', get_the_title() . ' Product Inquiry');
set_query_var('modal_mobile_heading', 'Safe Product Inquiry');
?>
<div class="product-single-container py-4 my-5" id="custom-product-single">

   <div class="bg-blue pb-5 d-none">
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1 class="product-detail-heading text-white mt-0 pt-0"><?php echo get_the_title(); ?> Gun Safe</h1>
                    <p class="product-detail-subheading mb-0 text-white"><?php echo get_field('post_product_gun_model_description'); ?></p>
                </div>
            </div>
       </div>
   </div>

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <h1 class="product-detail-heading"><?php echo get_the_title(); ?> Gun Safe</h1>
                <p class="product-detail-subheading"><?php echo get_field('post_product_gun_model_description'); ?></p>
                <div class="mt-5">
                    <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
                </div>
            </div>
            <div class="col-md-5">
                <?php get_template_part('template-parts/safes/content', 'inquiry'); ?>
                <?php get_template_part('template-parts/safes/content', 'tabs'); ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-end inquiry-container">
            <div class="col-md-6">
                <?php //get_template_part('template-parts/safes/content', 'inquiry'); ?>
            </div>
        </div>
    </div>

    

    <div class="container-fluid mb-5">
        <?php get_template_part('template-parts/safes/content', 'diff'); ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
            </div>
        </div>
    </div>



</div>
