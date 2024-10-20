<?php get_header(); ?>

<?php
$queried_obj = get_queried_object();
if ($queried_obj->count == 0 || $queried_obj->term_id == 75) {
	exit();
}
?>

<?php 
$object = get_queried_object();
$term_id = $object->term_id;
if (isset($term_id) && is_int($term_id)) {
	$products_by_parent_term = get_product_posts_by_tax($term_id);
}

$grid_args = [
	'heading' => get_queried_object()->name,
	'description' => $object->description,
	'products' => $products_by_parent_term,
];
 ?>

<?php get_template_part('template-parts/tw-shared/content', 'grid', $grid_args); ?>

<?php get_footer(); ?>