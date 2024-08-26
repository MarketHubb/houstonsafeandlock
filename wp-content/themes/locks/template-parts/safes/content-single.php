<?php
set_query_var('modal_callouts', '');
set_query_var('modal_heading', 'Safe Product Inquiry');
set_query_var('modal_mobile_heading', 'Product Inquiry');
?>

<?php //get_template_part( 'template-parts/content', 'safebreadcrumbs' ); ?>

<div class="product-single-container py-4 mt-3 mb-5" id="custom-product-single">

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-6 pe-md-4 pe-lg-5">
                <?php
                $terms = get_the_terms(get_the_ID(),'product_cat');
                $safe_type = '';
                foreach ($terms as $term) {
                    if ($term->parent === 0) {
                        $safe_type = $term->name;
                        break;
                    }
                }
                ?>
                <?php if ($safe_type) { ?>
                    <h5 class="text-uppercase"><?php echo $safe_type; ?></h5>
                <?php } ?>
                <h1 class="product-detail-heading">
                    <?php echo get_the_title(); ?>
                </h1>
                <p class="lead fw-normal">
                    <?php echo get_field('post_product_gun_model_description'); ?>
                </p>
                <div class="mt-5">
                    <?php do_action( 'woocommerce_before_single_product_summary' ); ?>
                </div>
            </div>
            <div class="col-md-6">
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



    <div class="container-fluid mb-5 g-0">
        <?php get_template_part('template-parts/safes/content', 'diff'); ?>
    </div>

    <div class="container-fluid py-5">
        <?php get_template_part('template-parts/safes/content', 'delivery-cities'); ?>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
            </div>
        </div>
    </div>



</div>

