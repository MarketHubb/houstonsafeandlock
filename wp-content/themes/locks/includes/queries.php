<?php
function get_product_cat_tax_terms($include_children = null)
{
    $tax_array = array(
            'taxonomy' => 'product_cat',
            'exclude' => [75]
    );

    if (!$include_children) {
        $tax_array['parent'] = 0;
    }

    return get_terms($tax_array);
}

function get_products_by_category($category_id)
{
    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    return $query->posts;
}

function add_amsec_tag_to_products()
{
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product_id = get_the_ID();
            $product_title = get_the_title($product_id);

            if (stripos($product_title, 'AMSEC') !== false) {
                wp_set_object_terms($product_id, 75, 'product_cat', true);
            }
        }
    }

    wp_reset_postdata();
}
