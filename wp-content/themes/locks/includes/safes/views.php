<?php
function product_attributes($post_id)
{
    $attributes = [];
    $attribute_keys = ['series', 'weight', 'width', 'depth', 'height', 'category', 'fire_rating', 'security_rating'];

    foreach ($attribute_keys as $key) {
        $function_name = $key === 'category'
            ? 'get_product_parent_terms'
            : 'get_product_attribute_' . $key;

        if (function_exists($function_name)) {
            $attributes[$key] = call_user_func($function_name, $post_id);
        }
    }

    return $attributes;
}

function get_formatted_data_attributes($post_id)
{
    $product_attributes = product_attributes($post_id);

    if (!is_array($product_attributes) || empty($product_attributes)) return null;

    $data_attributes = '';

    foreach ($product_attributes as $key => $attribute) {
        $attribute_value = $key === 'category'
            ? $attribute[0]->name
            : $attribute;

        $data_attributes .= 'data-' . $key . '="' . replace_space_with_underscore($attribute_value) . '" ';
    }

    return $data_attributes;
}

function output_products(array $safe_ids, bool $hidden = false)
{
    if (!is_array($safe_ids) || empty($safe_ids)) return null;

    $products = '';

    foreach ($safe_ids as $safe_id) {
        $parent_terms = get_product_parent_terms($safe_id);
        $parent_term = is_array($parent_terms) && !empty($parent_terms[0])
            ? remove_safes_from_string($parent_terms[0]->name)
            : null;

        $data_attributes = get_formatted_data_attributes($safe_id);
        $product_attributes = get_product_attributes($safe_id);
        $hidden = !$hidden
            ? ''
            : ' hidden';


        if ($product_attributes['brand']) {

            // Open + data attributes
            $products .= '<a '. $data_attributes . ' href="' . get_permalink($product_attributes['safe_id']) . '" class="relative group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white rounded-lg ring-1 shadow-sm hover:shadow-none ring-gray-200 hover:ring-gray-300 border-gray-200 group/card ' . $hidden . '">';
            $products .= '<div class="flex justify-center h-48 w-full overflow-hidden rounded-xl group-hover:opacity-75 lg:h-56 xl:h-64 px-4 pt-4 mx-auto">';
            // end Open + data attributes

            // $product_card .= '<span class="absolute z-20 top-0 end-0 rounded-se-lg rounded-es-lg text-xs font-medium bg-brand-350/10 text-brand-350 py-1.5 px-3 shadow-sm">';
            // $product_card .= 'Callout';
            // $product_card .= '</span>';


            if ($product_attributes['image_url']) {
                $products .= '<img class="!h-[90%] sm:!h-[95%] !w-auto max-w-full inline-block object-cover transition-transform duration-300 ease-in-out group-hover:scale-105" ';
                $products .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
                $products .= 'loading="lazy"';

                if ($product_attributes['image_srcset']) {
                    $products .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
                }

                if ($product_attributes['image_sizes']) {
                    $products .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
                }
            }
            $products .= '</div>';

            $products .= '<div class="bg-gray-50 sm:!bg-transparent opacity-100 sm:opacity-95 px-2 pt-5 pb-2 sm:px-3 lg:px-4 xl:px-6 h-full sm:h-auto sm:pb-6">';

            // Price / Discount
            // if (! empty($product_attributes['discount_price'])) {
            //     $price = safes_output_discount_tag($product_attributes['post_id'], false);
            // } else {            //     $price = 'Call for pricing';
            // }
            // end Price / Discount

            // $product_card .= '<div class="flex justify-center gap-x-2 items-center mb-3">' . $price . '</div>';

            // Title & category
            $products .= '<div class="p-2 flex flex-col justify-center">';
            $products .= '<h3 class="text-base md:text-base lg:text-lg xl:text-[1.35rem] font-bold antialiased tracking-tight sm:tracking-normal !leading-snug text-gray-900 text-center">';
            $products .= get_the_title($product_attributes['post_id']) . '</h3>';
            if (!empty($product_attributes['series'][0])) {
                $series = $product_attributes['series'][0] . ' Series';
                $products .= '<span class=" text-gray-400 tracking-wide inline-block w-full mx-auto text-center font-normal">';
                $products .= $series;

                if ($parent_term) {
                    $products .= ' ' . $parent_term . ' Safe';
                }

                $products .= '</span>';
            }
            $products .= '</div>';
            // end Title & category



            $products .= output_featured_attributes($product_attributes['post_id']);

            // Description
            $description = get_product_attribute_description_long($safe_id);
            if ($description && !empty($description)) {
                $products .= '<p class="mt-1 mb-6 text-gray-800 text-sm sm:text-base line-clamp-3 sm:line-clamp-2">';
                $products .= $description . '</p>';
            }
            // End Description

            if (is_sale_active()) {
                $products .= get_product_sale_callout($product_attributes['post_id'], 'grid');
            }

            $products .= '</div></a>';
        }
    }



    return $products;
}
