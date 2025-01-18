<?php get_header(); ?>

<?php
$queried_obj = get_queried_object();

if ($queried_obj->count == 0 || $queried_obj->term_id == 75) {
	exit();
}

$args = [];
$callout_name = strip_trailing_s(get_queried_object()->name);

$hero_args = [
	'callout' => "Houston's #1 " . $callout_name . ' dealer',
	'heading' => "Shop " . get_queried_object()->name,
	'description' => $queried_obj->description,
];

$args['hero'] = $hero_args;
$args['collection'] = get_products_by_tax($queried_obj);

get_template_part('template-parts/product/content', 'archive', $args);
?>


<?php get_footer(); ?>