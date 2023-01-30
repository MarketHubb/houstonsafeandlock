<?php /* Template Name: Genesis Custom */

get_header(); ?>

<div class="container my-5" id="genesis-custom-template">
    <div class="row px-4 px-md-0">
        <div class="col-12">
            <div class="">
                <h1 class="text-blue font-source fw-bold text-center mt-3 mb-lg-5"><?php echo get_the_title(); ?></h1>
                <?php
                while ( have_posts() ) : the_post();
                    get_template_part( 'template-parts/content', 'page' );
                endwhile; // End of the loop.
                ?>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
