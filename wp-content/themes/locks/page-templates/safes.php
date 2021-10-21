<?php /* Template Name: Safes */
get_header(); ?>

<!-- Hero Banner -->
<?php
$args = [
    'heading' => 'Houston\'s Largest Safe Shop',
    'subheading' => 'From large gun safes to small jewelry safes, we carry the largest selection of residential and commercial safes for sale in Houston. Come visit our showroom today to see over 300 in-stock models from top brands like American Security.',
    'subheading_mobile' => 'Over 400 models in-stock and ready to deliver. Visit our 5,000 sq. ft. showroom today.'

];
get_template_part('template-parts/hero/content', 'simple', $args); ?>

<?php get_template_part('template-parts/safes/content'); ?>

<?php get_footer(); ?>
