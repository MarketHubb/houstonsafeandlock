<?php /* Template Name: Used Safes */
get_header();
set_query_var('form_id', 4);
?>

<?php
// Banner
$hero_args = array('section_classes' => 'mb-0');

if (get_field('page_include_banner')) {
    if (get_field('page_banner_style') === 'Split') {
        get_template_part('template-parts/global/content', 'hero-split', $hero_args);
    } else {
        get_template_part('template-parts/global/content', 'hero', $hero_args);
    }
}
?>

<?php get_template_part('template-parts/safes/content', 'used'); ?>



<?php get_footer(); ?>
