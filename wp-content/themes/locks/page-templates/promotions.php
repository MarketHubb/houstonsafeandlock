<?php

/* Template Name: Promotions  */

get_header();

?>

<?php if(get_field('simple_header')) { ?>
    <?php 
    $header_args = [
        'heading' => get_the_title(get_the_id()),
        'callout' => 'From now until May 31st',
        'description' => get_field('header_description')
    ];
     ?>

    <?php get_template_part( 'template-parts/tw/content', 'header-center', $header_args ); ?>
    
<?php } else { ?>

    <div id="primary" class="content-area d-none">
        <main id="main" class="site-main" role="main">

            <!-- Hero Banner -->
            <?php
            $hero_args = array('section_classes' => 'mb-0');

            if (get_field('page_include_banner')) {
                if (get_field('page_banner_style') === 'Split') {
                    get_template_part('template-parts/global/content', 'hero-split', $hero_args);
                } else {
                    get_template_part('template-parts/global/content', 'hero', $hero_args);
                }
            }
            ?>

        </main>
    </div>
<?php } ?>

<!-- Panel Content -->
<?php get_template_part('template-parts/promotions/content-shared'); ?>

<?php //get_template_part('template-parts/promotions/content'); ?>


<?php get_footer(); ?>