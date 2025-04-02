<?php
defined('ABSPATH') || exit;
require_once "models.php";
require_once "queries.php";
require_once "helpers.php";
require_once "data.php";
require_once "components.php";
require_once "content-archive.php";
require_once "content-single.php";
require_once "filters-sorts.php";
require_once "styles.php";
require_once "sales.php";


function init_safes()
{
    $safe_ids = get_safe_init_ids();

    if (! is_array($safe_ids) || empty($safe_ids)) return null;

    $init_ids = is_array($safe_ids['init']) && !empty($safe_ids['init'])
        ? $safe_ids['all']
        : query_all_safe_ids();

    $filter_sort_data = get_safe_filter_sort_data($init_ids);

    return [
        'safe_ids'         => $safe_ids,
        'filter_sort_data' => $filter_sort_data
    ];
}

function get_safe_filter_sort_data($safe_ids)
{
    $range_data = get_product_attribute_ranges([
        // 'Price'  => 'post_product_gun_price',
        'Weight' => 'post_product_gun_weight',
        'Width'  => 'post_product_gun_exterior_width',
        'Depth'  => 'post_product_gun_exterior_depth',
        'Height' => 'post_product_gun_exterior_height',
    ],
    $safe_ids
);

    $filter_data = get_product_attribute_unique_values([
        'Security Rating' => 'post_product_security_rating',
        'Fire Rating'     => 'post_product_fire_rating',
    ]);

    $tax_terms = get_product_cat_tax_terms(null);

    if (is_array($tax_terms) && ! empty($tax_terms)) {
        $terms = [];
        foreach ($tax_terms as $term) {
            $terms[] = $term->name . ',' . $term->term_id;
        }
    }

    $filter_data['terms'] = $terms;

    return [
        'range'    => $range_data,
        'checkbox' => $filter_data,
    ];
}

function get_safe_init_ids()
{
    $safe_ids = query_all_safe_ids();

    if (is_safe_parent_page()) {
        $init_ids = get_featured_product_ids();
    } elseif (is_safe_tax_page()) {
        $init_ids = get_product_ids_by_tax(get_queried_object()->term_id);
    }

    if (empty($safe_ids) || empty($init_ids)) {
        return null;
    }

    $hidden_ids = [];

    foreach ($safe_ids as $safe_id) {
        if ( ! in_array($safe_id, $init_ids)) {
            $hidden_ids[] = $safe_id;
        }
    }

    return [
        'all'    => $safe_ids,
        'init'   => $init_ids,
        'hidden' => $hidden_ids,
    ];
}
