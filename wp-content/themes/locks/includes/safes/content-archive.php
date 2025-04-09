<?php
function output_products(array $safe_ids, bool $hidden = false, bool $featured = false)
{
    if (! is_array($safe_ids) || empty($safe_ids)) {
        return null;
    }

    $products = '';

    foreach ($safe_ids as $safe_id) {
        $product_attributes = get_product_attributes($safe_id);

        if ($product_attributes['brand']) {

            $products .= output_product_grid_item_open($product_attributes, $hidden, $featured);

            $products .= output_product_grid_image($product_attributes);

            $products .= '<div class=" px-2 pt-5 pb-2 sm:px-3 lg:px-4 xl:px-6 h-full sm:h-auto sm:pb-6">';

            // Title & category
            $products .= '<div class="p-2 flex flex-col justify-center">';

            $products .= output_product_series($product_attributes);

            $products .= output_product_grid_title($safe_id);

            $products .= output_product_grid_category($safe_id);

            $products .= '</div>';

            $products .= output_featured_attributes($product_attributes['post_id']);

            $products .= output_product_description_clamp($safe_id);

            $products .= output_product_attribute_badges($product_attributes);

            if (is_sale_active()) {
                $products .= get_product_sale_callout($product_attributes['post_id'], 'grid');
            }

            $products .= '</div></a>';
        }
    }

    return $products;
}
