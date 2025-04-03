<?php /* Template Name: All Safes (New) */
get_header();
?>

<?php get_template_part('template-parts/preline/content', 'modal-fullscreen'); ?>

<?php
if (get_field('page_include_banner') && get_field('page_banner_style') === 'Simple') {
    $hero_args = get_field('page_banner_simple');
    $hero_data = array_map(function ($value) {
        return is_string($value) ? strip_tags($value) : $value;
    }, $hero_args);
} else {
    $hero_data = [
        'callout' => "Houston's Largest Safe Dealer",
        'heading' => 'Safes for Sale',
        'description' => 'Houston Safe & Lock has the largest selection of in-stock, ready-to-ship safes in Houston. Need help or have questions? Our team of safe & security experts can help.',
        'products' => $products,
    ];
}

get_template_part('template-parts/tw-shared/content', 'hero-simple', $hero_data);
?>

<?php echo get_product_archive_open(); ?>

<?php get_template_part('template-parts/tw-shared/content', 'grid'); ?>

<?php echo get_product_archive_close(); ?>

<?php get_footer(); ?>