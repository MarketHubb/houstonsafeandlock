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

function get_featured_product_ids()
{
    return get_field('featured_safes', 'option');
}

function get_product_ids_by_tax($category_id)
{
    $ids = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ],
        ],
    ]);

    return $ids ?? null;
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

function query_all_safe_ids()
{
    $safe_ids = get_posts([
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ]);

    return $safe_ids ?? null;
}
