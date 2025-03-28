<?php
function get_related_safe_products($post_id)
{
    // Get all terms for the current product
    $terms_all = get_the_terms($post_id, 'product_cat');
    if ( ! $terms_all || is_wp_error($terms_all)) {
        return [];
    }

    $related_ids    = [];
    $posts_per_page = 4;

    // Determine which term to use
    $term_to_use = null;
    foreach ($terms_all as $term) {
        if ($term->term_id !== 75 && $term->term_id !== 78) {
            $term_to_use = $term;
            break;
        }
    }

    // If no suitable term found, use the last term in the array
    if ( ! $term_to_use) {
        $term_to_use = end($terms_all);
    }

    // First query using the selected term
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post__not_in'   => [$post_id],
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $term_to_use->term_id,
            ],
        ],
        'fields'         => 'ids', // Only get post IDs
    ];

    $related_products = get_posts($args);
    $related_ids      = $related_products;

    // If we don't have enough products, try the parent category
    if (count($related_ids) < $posts_per_page && isset($term_to_use->parent) && $term_to_use->parent != 0) {
        $remaining_needed = $posts_per_page - count($related_ids);

        $args['posts_per_page']        = $remaining_needed;
        $args['post__not_in']          = array_merge([$post_id], $related_ids);
        $args['tax_query'][0]['terms'] = $term_to_use->parent;

        $additional_products = get_posts($args);
        $related_ids         = array_merge($related_ids, $additional_products);
    }

    return array_slice($related_ids, 0, $posts_per_page);
}

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
