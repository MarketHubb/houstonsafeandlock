<?php
function get_product_cat_tax_terms($include_children = null)
{
    $tax_query = [
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
        'exclude'    => [75, 78],
    ];

    if ( ! $include_children) {
        $tax_query['parent'] = 0;
    }

    return get_terms($tax_query);
}

function get_product_cat_child_terms($parent_term)
{
    return get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $parent_term->term_id,
        'hide_empty' => true,
    ]);
}

function get_products_by_category($category_id)
{
    $args = [
        'post_type'   => 'product',
        'post_status' => 'publish',
        'tax_query'   => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ],
        ],
    ];

    $query = new WP_Query($args);

    return $query->posts;
}

function add_amsec_tag_to_products()
{
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id    = get_the_ID();
            $product_title = get_the_title($product_id);

            if (stripos($product_title, 'AMSEC') !== false) {
                wp_set_object_terms($product_id, 75, 'product_cat', true);
            }
        }
    }

    wp_reset_postdata();
}

/* region posts */
function query_products_by_tax_term($term)
{
    $term_posts = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ],
        ],
    ]);

    return  ! empty($term_posts) ? $term_posts : null;
}
