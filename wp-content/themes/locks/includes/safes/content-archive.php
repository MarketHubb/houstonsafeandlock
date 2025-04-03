<?php
function output_products(array $safe_ids, bool $hidden = false, bool $featured = false)
{
    if (! is_array($safe_ids) || empty($safe_ids)) {
        return null;
    }

    $products = '';

    foreach ($safe_ids as $safe_id) {
        $data_attributes    = safe_data_attributes($safe_id, $featured);
        $product_attributes = get_product_attributes($safe_id);

        if ($product_attributes['brand']) {

            $products .= output_product_grid_open($safe_id, $data_attributes, $hidden);

            $products .= output_product_grid_image($product_attributes);

            $products .= '<div class=" px-2 pt-5 pb-2 sm:px-3 lg:px-4 xl:px-6 h-full sm:h-auto sm:pb-6">';

            // Price / Discount
            // if (! empty($product_attributes['discount_price'])) {
            //     $price = safes_output_discount_tag($product_attributes['post_id'], false);
            // } else {            //     $price = 'Call for pricing';
            // }
            // end Price / Discount

            // $product_card .= '<div class="flex justify-center gap-x-2 items-center mb-3">' . $price . '</div>';

            // Title & category
            $products .= '<div class="p-2 flex flex-col justify-center">';

            $products .= output_product_series($product_attributes);

            $products .= output_product_grid_title($safe_id);

            $products .= output_product_grid_category($safe_id);

            $products .= '</div>';

            $products .= output_featured_attributes($product_attributes['post_id']);

            $products .= output_product_description_clamp($safe_id);

            $products .= output_product_rating_badges($product_attributes);

            if (is_sale_active()) {
                $products .= get_product_sale_callout($product_attributes['post_id'], 'grid');
            }

            $products .= '</div></a>';
        }
    }

    return $products;
}
