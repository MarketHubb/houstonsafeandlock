<?php /* Template Name: Safes */
get_header(); ?>

<!-- Hero Banner -->
<?php
//$hero_args = array('section_classes' => 'mb-0');
//
//if (get_field('page_include_banner')) {
//    if (get_field('page_banner_style') === 'Split') {
//        get_template_part('template-parts/global/content', 'hero-split', $hero_args);
//    } else {
//        get_template_part('template-parts/global/content', 'hero', $hero_args);
//    }
//}
?>
<div class="container-fluid">
    <div class="wrapper">
        <div class="row">
            <div class="col text-center mt-5 mb-3 py-2 bb-grey">
                <h1 class="page-title">Houston's Largest Safe Shop</h1>
                <p class="lead font-weight-bold">From large gun safes to small jewelry safes, we carry the largest selection of residential and commercial safes for sale in Houston. Come visit our showroom today to see over 300 in-stock models from top brands like American Security.
                </p>
            </div>
        </div>
    </div>
</div>

<?php get_template_part('template-parts/safes/content'); ?>

<?php get_footer(); ?>
