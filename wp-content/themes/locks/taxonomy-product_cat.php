<?php get_header(); ?>

<?php
$queried_obj = get_queried_object();

if ($queried_obj->count == 0 || $queried_obj->term_id == 75) {
	exit();
}

$callout_name = strip_trailing_s(get_queried_object()->name);

$hero_args = [
	'callout' => "Houston's #1 " . $callout_name . ' dealer',
	'heading' => "Shop " . get_queried_object()->name,
	'description' => $queried_obj->description,
];
get_template_part('template-parts/tw-shared/content', 'hero-simple', $hero_args);

?>

<?php echo get_product_archive_open(); ?>

<?php get_template_part('template-parts/tw-shared/content', 'grid'); ?>

<?php echo get_product_archive_close(); ?>

<?php get_footer(); ?>