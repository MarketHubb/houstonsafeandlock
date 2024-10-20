<?php get_header(); ?>

<?php
if (get_field('new_layout', get_the_id())) {
    get_template_part( 'template-parts/preline/content', 'post');
} else {
    $content = get_the_content(null, false, $post->ID);
    $content_array = explode("/n", $content);

    if (strpos($content_array[0], 'wp:genesis-blocks') !== false) { ?>

        <div class="genesis-container">
            <?php
            while (have_posts()) : the_post();
                get_template_part('template-parts/content', 'page');
            endwhile; // End of the loop.
            ?>
        </div>


    <?php } else { ?>

        <div class="container">
            <div class="row justify-content-center my-5">
                <div class="col-11 col-md-10 col-lg-9">
                    <div class="post-title py-4">
                        <h1><?php echo get_the_title(); ?></h1>
                    </div>
                    <?php echo get_the_content($post->ID); ?>
                </div>
            </div>
        </div>


<?php }
} ?>



<?php get_footer(); ?>