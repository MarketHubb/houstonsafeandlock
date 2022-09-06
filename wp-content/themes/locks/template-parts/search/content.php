<div id="search-results">
<?php
global $post;

$args = [
    's'         => get_search_query(),
    'nopaging'  => true,
    'posts_per_page' => -1
];

if ( ! empty( $args['s'] ) ) {
    $swp_query = new SWP_Query( $args );
} else {
    $swp_query = new WP_Query( $args );
}

if ( $swp_query->have_posts() ) {
    while ( $swp_query->have_posts() ) :
        $swp_query->the_post();
        ?>
        <div class="container">
            <div class="row align-items-center justify-content-center py-3 search-row">

                <div class="col-md-7">
                    <?php
                    $terms = get_the_terms( $post->ID, 'product_cat' );
                    $cat_list = '<div class="product-cat-">';

                    if ($terms) {
                        $terms = array_reverse($terms);
                        foreach ($terms as $term) {
                            $cat_list .= '<span class="pe-3 fst-italic text-secondary">';
                            $cat_list .= '<a class="text-secondary" href="' . get_term_link($term->term_id) . '" >';
                            $cat_list .= $term->name;
                            $cat_list .= '</a></span>';
                        }
                        $cat_list .= '</div>';
                        echo $cat_list;
                    }
                    ?>
                    <p class="font-weight-bold fs-4 my-3 text-decoration-underline">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </p>
                    <?php if ($post->post_type === 'product') { ?>
                        <p class="lead clamp-4">
                            <?php $short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt ); ?>
                            <?php if ($short_description) { echo $short_description; } ?>
                        </p>
                    <?php } ?>
                </div>

                <div class="col-md-4">
                    <?php if ($post->post_type === 'product') { ?>
                        <?php $product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
                        <img class="results-img" src="<?php echo $product_image[0]; ?>" alt="">
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php
    endwhile;
    wp_reset_postdata();
} ?>

</div>