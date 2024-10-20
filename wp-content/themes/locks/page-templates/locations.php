<?php /* Template Name: Locations */

get_header(); ?>

<?php
$hero_fields = get_field('hero', get_the_ID());
$heading = '<span class="block mt-24 text-2xl font-normal tracking-tight  text-gray-500 sm:mt-10 sm:text-4xl">Houston Safe & Lock</span>' . '<span class="mt-24 text-4xl font-bold tracking-wide text-brand-500 sm:mt-10 sm:text-6xl uppercase">' . get_the_title(get_the_ID()) . '</span>';
$hero_args = [
	'callout' => display_contact_info(get_the_ID()),
	'image' => $hero_fields['image'],
	'heading' => $heading,
	'description' => $hero_fields['description'],
	'address' => get_field('address', get_the_ID()),
	'email' => get_field('email', get_the_ID()),
	'phone' => get_field('phone', get_the_ID()),
];
 ?>

<?php get_template_part('template-parts/tw-shared/content', 'hero-image-split', $hero_args); ?>

<?php 
$images = get_field('gallery', get_the_ID());
get_template_part('template-parts/tw-shared/content', 'masonry', $images); ?>

<?php get_template_part('template-parts/tw-shared/content', 'embed-map'); ?>

<?php get_footer(); ?>
