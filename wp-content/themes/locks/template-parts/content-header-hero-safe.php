<?php

if (get_field('page_include_banner')) {

    $hero_args = array('section_classes' => 'mb-0');

    if (get_field('page_include_banner')) {
        if (get_field('page_banner_style') === 'Split') {
            get_template_part('template-parts/global/content', 'hero-split', $hero_args);
        } else {
            get_template_part('template-parts/global/content', 'hero', $hero_args);
        }
    }
} else {

    if (is_singular('product')) {
        get_template_part( 'template-parts/content', 'safebreadcrumbs' );
    }
    if (is_shop() || is_archive()) {

       // get_template_part( 'template-parts/content', 'alerts' );
        get_template_part( 'template-parts/content', 'safebreadcrumbs' );

        if (is_shop()) {
            $title = get_field( 'page_headline', '2320' );
            $alert = get_field('field_5dea85d0f82c7', 'option');

        } else if (is_archive() && !is_shop()) {
            $title = woocommerce_page_title( false );
            $terms = get_the_terms( $post->ID, 'product_cat' );
            $parent_term = ri_get_product_parent_tax($terms);

        } else if (is_singular('product')) {
            $manufacturer = get_field('post_product_gun_manufacturer');
            $model = get_the_title();
            $title = trim($manufacturer . ' ' . $model);
        }
    }
    ?>

    <!--  SEM Locksmith Pages -->
    <?php
    if (is_page(get_sem_locksmith_pages())) {
        get_template_part( 'template-parts/content', 'alerts' );
    }
    ?>

    <div class="products-container container-fixed">

        <?php
        // Safe Shop
        if (is_shop()) {
            $headline = get_field( 'page_headline', '2320' ); ?>

            <h1 class="product-detail-heading"><?php echo $headline; ?></h1>

        <?php } ?>

        <?php
        //  Safe Category Pages (i.e Commercial Safes)
        if (is_archive() && !is_shop()) { ?>

            <h1 class="product-detail-heading"><?php woocommerce_page_title(); ?></h1>

        <?php } ?>

        <?php
        //  Safe Product Detail Page
        if (is_singular('product')) {

            $manufacturer = get_field('post_product_gun_manufacturer');
            $model = get_the_title(); ?>

            <div class="container">
                <div class="row">
                    <h1 class="product-detail-heading"><?php echo $model; ?></h1>
                    <p class="product-detail-subheading"><?php echo get_field('post_product_gun_model_description'); ?></p>
                </div>
            </div>

        <?php } ?>


    </div>

    <?php if (!is_shop() && !is_archive() && !is_singular('product')) { ?>

        <div id="header-hero" class="container-skew" <?php echo single_post_hero_background(); ?>>
            <div class="container-straight">
                <div class="container-fixed test">
                    <?php
                    $the_id = '';
                    if (is_shop()) {
                        $the_id = get_option( 'woocommerce_shop_page_id' );
                    } else {
                        $the_id = get_queried_object_id();
                    }
                    if (is_shop() ) {
                        $headline = get_field( 'page_headline' );
                        $sub_headline = get_field( 'page_sub_headline' );
                        $html = '';
                        if ( !empty( $headline ) ) {
                            $html .= '<h1 class="test_headline">' . $headline . '</h1>';
                        } else {
                            if (is_single()) {
                                $html .= '<h1 class="test_single">' . get_the_title() . '</h1>';
                            } else {
                                $html .= '<h1 class="test_fallback">' . sanitize_post( get_queried_object() )->name . '</h1>';
                            }

                        }

                        if ( !empty( $sub_headline) ) {
                            $html .= '<h2>' . $sub_headline . '</h2>';
                        } else {
                            if (is_single()) {
                                $terms = get_the_terms( get_the_ID(), 'safe_category');
                                $html .= '<h2>' . $terms[0]->name . '</h2>';
                            }
                        }
                        echo 'Shop';
                    }

                    render_single_post_hero_headlines($the_id); ?>
                </div>
            </div>
        </div>


<?php } } ?>