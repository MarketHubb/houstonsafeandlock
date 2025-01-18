<?php if (!isset($args)) return; ?>

<?php get_template_part('template-parts/preline/content', 'modal-fullscreen'); ?>

<?php echo get_product_archive_open(); ?>

<?php
if (!empty($args['hero'])) {
	get_template_part('template-parts/tw-shared/content', 'hero-simple', $args['hero']); 
}
?>

<?php
if (!empty($args['collection'])) {
	get_template_part('template-parts/tw-shared/content', 'grid', $args['collection']); 
}
?>

<?php echo get_product_archive_close(); ?>