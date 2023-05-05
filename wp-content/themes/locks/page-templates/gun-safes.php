<?php

/* Template Name: Category - Gun Safes */

get_header();
set_query_var('modal_headline', 'Gun Safe Inquiry');
?>
<div id="primary" class="content-area d-none">
	<main id="main" class="site-main" role="main">

        <?php
        // Get post counts for filter categories (safe manufacturers)
        $amsec_query_args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_key'		=> 'post_product_gun_in_stock',
            'meta_value'	=> true,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => array(51, 38, 39, 41)
                ),
            ),
        );

        $amsec_query = new WP_Query($amsec_query_args);

        $original_query_args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'meta_key'		=> 'post_product_gun_in_stock',
            'meta_value'	=> true,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => 40
                ),
            ),
        );

        $original_query = new WP_Query($original_query_args);
         ?>

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

         <div class="container d-none" id="custom-page-template-title" data-url="<?php echo get_home_url(); ?>">
            <div class="row">
                <div class="col-12 text-center">
                    <?php
                    if( have_rows('page_category_gun_benefits') ):
                        $benefits = '<div class="row d-md-block features-benefits">';
                        while ( have_rows('page_category_gun_benefits') ) : the_row();
                            $benefits .= '<div class="col-4 text-center p-2 p-md-5 p-lg-5">';
                            $benefits .= '<i class="' . get_sub_field('page_category_gun_benefits_icon') . ' fa-2x" style="--fa-primary-color: #cce5ff;"></i>';
                            $benefits .= '<h5>' . get_sub_field('page_category_gun_benefits_benefit') . '</h5>';
                            $benefits .= '<p class="d-none d-lg-block">' . get_sub_field('page_category_gun_benefits_description') . '</p>';
                            $benefits .= '</div>';
                        endwhile;
                    endif;
                    $benefits .= '</div>';
                    echo $benefits;
                    ?>
                </div>
            </div>
         </div>

	</main>
</div>

<?php
$attributes=['capacity-total', 'weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];
get_template_part('template-parts/safes/content', 'grid-sort', ['attributes' => $attributes]);

$gun_safe_cats = [68, 69, 39, 41, 40];
get_template_part('template-parts/safes/content', 'grid-list', ['cat_id' => $gun_safe_cats, 'attributes' => $attributes]);

?>


<?php get_footer(); ?>