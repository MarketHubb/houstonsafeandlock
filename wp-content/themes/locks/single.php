<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package locks
 */

get_header(); ?>

<?php if (get_post_type() === 'post') {

    get_template_part( 'template-parts/preline/content', 'posts');

} else { ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="container-fixed">
				<div class="content-with-sidebar">
					<div class="container-content">
					<?php
					while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/content', get_post_format() );

                        the_post_navigation();

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
					</div>
					<div class="container-sidebar">
						<?php get_sidebar(); ?>
					</div>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->
	<a href="#0" class="cd-top">Top</a>
<?php
}
get_footer();
