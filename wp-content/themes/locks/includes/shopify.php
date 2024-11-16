<?php
function get_pricing_data_for_safe($post_id)
{
    $shopify_data = get_field('product_inventory', $post_id);

    if (isset($shopify_data) && !empty($shopify_data[0])) {
        $pricing_data = [
            'price'            => $shopify_data[0]['price'],
            'discount_amount'  => $shopify_data[0]['discount_amount'],
            'discounted_price' => $shopify_data[0]['discount_price'],
            'discount'         => $shopify_data[0]['discount'],
        ];
    }

    return standardize_pricing_data($pricing_data) ?? null;
}

