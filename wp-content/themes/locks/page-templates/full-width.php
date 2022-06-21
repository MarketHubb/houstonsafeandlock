<?php /* Template Name: Full-width */

get_header(); ?>
<?php if (is_page(6624)) { ?>
<div class="d-none container-fluid bg-orange py-3">
    <div class="row">
        <div class="col text-center">
			<p class="mb-0 text-white">
				<i class="fas fa-exclamation-triangle me-2"></i>
				Same-day appointments available - Call Now
			</p>
		</div>
    </div>
</div>
<?php } ?>
<?php 
while ( have_posts() ) : the_post();
	get_template_part( 'template-parts/content', 'page' );
endwhile; // End of the loop.
?>

<?php get_footer(); ?>