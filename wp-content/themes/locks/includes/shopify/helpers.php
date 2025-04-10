<?php
defined('ABSPATH') || exit;

// region Queries
function get_product_cat_terms($post_id)
{
    return get_the_terms($post_id, 'product_cat') ?? null;
}

function get_quantity_for_safe($post_id)
{
    $product_inventory = get_field('product_inventory', $post_id)[0] ?? null;

    if (! $product_inventory) {
        return null;
    }

    $hsl_qty       = $product_inventory['westheimer_available'] ?? 0;
    $ksl_qty       = $product_inventory['memorial_available'] ?? 0;
    $warehouse_qty = $product_inventory['warehouse_available'] ?? 0;

    return $hsl_qty + $ksl_qty + $warehouse_qty;
}

function get_pricing_data_for_safe($post_id)
{
    $shopify_data = get_field('product_inventory', $post_id);

    if (isset($shopify_data) && ! empty($shopify_data[0])) {
        $pricing_data = [
            'price'            => $shopify_data[0]['price'],
            'discount_amount'  => $shopify_data[0]['discount_amount'],
            'discounted_price' => $shopify_data[0]['discount_price'],
            'discount'         => $shopify_data[0]['discount'],
        ];
    }

    return standardize_pricing_data($pricing_data) ?? null;
}

function get_shopify_data($post_id)
{
    $product_inventory = get_field('product_inventory', $post_id)[0] ?? null;

    if (! $product_inventory) return null;

    return [
        'quantity' => get_quantity_for_safe($post_id),
        'price' => get_pricing_data_for_safe($post_id)
    ];
}
// endregion

// region Content
function get_manufacturer_amsec_attribute()
{
    return [
        'type' => 'Manufacturer',
        'value' => 'AMSEC',
        'icon' => null,
        'image' => '/wp-content/uploads/2024/08/AMSEC-Wings.png'
    ];
}

function get_fire_rating_attribute($post_id)
{
    $value = get_field('post_product_fire_rating', $post_id) ?? null;

    return [
        'type' => 'Fire Rating',
        'value' => $value,
        'icon' => null,
        'image' => '/wp-content/uploads/2024/03/fire-rating.svg'
    ];
}

function get_security_rating_attribute($post_id)
{
    $value = get_field('post_product_security_rating', $post_id) ?? null;

    return [
        'type' => 'Security Rating',
        'value' => $value,
        'icon' => null,
        'image' => '/wp-content/uploads/2024/03/security-rating.svg'
    ];
}

function get_gun_capacity_attribute($post_id)
{
    $value = get_field('post_product_gun_capacity_total', $post_id) ?? null;

    return [
        'type' => 'Capacity',
        'value' => $value,
        'icon' => null,
        'image' => '/wp-content/uploads/2024/11/Gun-Capacity.svg'
    ];
}

function get_bfx_series_callouts($post_id)
{
    $callouts = [];
    $callouts[] = get_manufacturer_amsec_attribute();
    $callouts[] = get_fire_rating_attribute($post_id);
    $callouts[] = get_security_rating_attribute($post_id);
    $callouts[] = get_gun_capacity_attribute($post_id);

    return $callouts;
}

function get_title($post_id)
{
    $title_text = get_the_title($post_id);
    $terms = get_product_cat_terms($post_id);
    $title  = '<div class="mb-8">';
    $title .= '<h1 class="text-2xl md:text-3xl lg:text-4xl text-gray-800 !leading-none">';

    if (!empty($terms) && in_array(75, array_column($terms, 'term_id'))) {
        $title .= '<span class="block font-normal tracking-[.25rem] text-gray-400 text-base uppercase">American Security</span>';
    }

    $title .= $title_text;
    $title .= '</h1>';
    $title .= '</div>';

    return $title;
}

function get_callout_attributes($post_id)
{
    $terms = get_product_cat_terms($post_id);

    if (!$terms) return null;

    $term_ids = array_column($terms, 'term_id');
    $callouts = null;

    switch (true) {
        case in_array(68, $term_ids):
            $callouts = get_bfx_series_callouts($post_id);
            break;

        default:
            // code...
            break;
    }

    return $callouts;
}
