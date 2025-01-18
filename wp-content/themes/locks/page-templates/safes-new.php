<?php /* Template Name: All Safes (New) */
get_header();
?>

<?php
$args = [];
// Hero
if (get_field('page_include_banner') && get_field('page_banner_style') === 'Simple') {
    $hero_args = get_field('page_banner_simple');
} else {
    $hero_args = [
        'heading' => 'Safes for Sale',
        'description' => 'Houston Safe & Lock has the largest selection of in-stock, ready-to-ship safes in Houston. Need help or have questions? Our team of safe & security experts can help.',
        'products' => $products,
    ];
}

$args['hero'] = $hero_args;
$args['collection'] = get_products_by_tax(get_queried_object());

get_template_part('template-parts/product/content', 'archive', $args);
?>

<?php get_footer(); ?>