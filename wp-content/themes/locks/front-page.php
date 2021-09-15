<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package locks
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <a name="top"></a>
        <main id="main" class="site-main" role="main">

            <!-- NEW -->

            <!--Header Image Template Part-->
            <?php get_template_part( 'template-parts/home/content', 'hero'); ?>
            <!-- Reviews -->
            <?php get_template_part( 'template-parts/home/content', 'reviews'); ?>
            <!-- Services -->
            <?php get_template_part( 'template-parts/home/content', 'services'); ?>
            <!-- Featured -->
            <?php get_template_part( 'template-parts/home/content', 'featured'); ?>

            <!-- LEGACY -->

            <!--Testimonials Template Part-->
<!--            --><?php //get_template_part( 'template-parts/content', 'testimonials'); ?>
            <!--Lock Services Template Part-->
            <?php //get_template_part( 'template-parts/content', 'lock-services'); ?>
            <!--About Us Template Part-->
            <?php //get_template_part( 'template-parts/content', 'about-us'); ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
