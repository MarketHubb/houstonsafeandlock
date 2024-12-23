<?php
/* region Filters & Sorts */
function get_filter_slider_keys()
{
    return [
        'price',
        'weight',
        'width',
        'depth',
        'height'
    ];
}

function get_filter_checkbox_keys()
{
    return [
        'security_rating',
        'fire_rating',
        'category',
        'brand',
    ];
}

function get_sort_keys()
{
    return [
        'price',
        'weight',
        'width',
        'depth',
        'height'
    ];
}

function get_filter_slider($attributes)
{
    $sliders = [];

    foreach ($attributes as $slider_name => $slider_values) {
        $slider_name_formatted = strtolower(str_replace(' ', '_', $slider_name));
        $slider_name_label = ucfirst($slider_name);
        $start_value = (int)$slider_values[0];  // Cast to integer
        $middle_value = (int)round(count($slider_values) / 2);
        $end_value = (int)$slider_values[count($slider_values) - 1];
        
        // Create the JSON configuration separately
        $slider_config = json_encode([
            'start' => (int)$slider_values[$middle_value], // Cast to integer
            'connect' => 'lower',
            'range' => [
                'min' => $start_value,
                'max' => $end_value
            ],
            'tooltips' => true,
            'formatter' => 'integer',
            'step' => 1,
            'cssClasses' => [
                'target' => 'relative h-2 rounded-full bg-gray-100',
                'base' => 'w-full h-full relative z-1',
                'origin' => 'absolute top-0 end-0 w-full h-full origin-[0_0] rounded-full',
                'handle' => 'absolute !top-1/2 !end-0 !w-[1.125rem] !h-[1.125rem] bg-white border-4 border-blue-600 rounded-full cursor-pointer translate-x-2/4 -translate-y-2/4',
                'connects' => 'relative z-0 w-full h-full rounded-full overflow-hidden',
                'connect' => 'absolute top-0 end-0 z-1 w-full h-full bg-blue-600 origin-[0_0]',
                'touchArea' => 'absolute -top-1 -bottom-1 -start-1 -end-1',
                'tooltip' => 'bg-white border border-gray-200 text-sm text-gray-800 py-1 px-2 rounded-lg mb-3 absolute bottom-full start-2/4 -translate-x-2/4'
            ]
        ], JSON_NUMERIC_CHECK);  // Added JSON_NUMERIC_CHECK flag
        
        $slider_html = <<<STRING
        <label class="sr-only">{$slider_name}</label>
        <div 
            id="hs-pass-value-to-html-element" 
            class="relative h-2 rounded-full bg-gray-100 filter-range-slider" 
            data-type="{$slider_name}"
            data-hs-range-slider='{$slider_config}'
        >
        </div>
        <div class="font-semibold mt-5">{$slider_name_label}: <span id="hs-{$slider_name_formatted}-slider-target" class="text-blue-600">{$middle_value}</span></div>
        STRING;

        $sliders[$slider_name] = $slider_html;
    }

    return $sliders;
}

function filter_sort($attributes)
{
    if (empty($attributes)) return;

    $filters = '';

    foreach ($attributes as $filter_name => $attribute) {
        $label = $filter_name;
        $name = strtolower(str_replace(' ', '', $label));
        $min = min($attribute['values']);
        $max = max($attribute['values']);

        $filters .= '<div class="py-3" data-slider="' . $name . '">';

        $filters .= <<<HTML
        <label for="min-and-max-range-slider-usage" class="font-bold antialiased">{$label}</label>
        <input name="{$name}" id="{$name}" type="range" value="{$max}" 
            class="w-full bg-transparent cursor-pointer appearance-none disabled:opacity-50 disabled:pointer-events-none focus:outline-none
            [&::-webkit-slider-thumb]:w-2.5
            [&::-webkit-slider-thumb]:h-2.5
            [&::-webkit-slider-thumb]:-mt-0.5
            [&::-webkit-slider-thumb]:appearance-none
            [&::-webkit-slider-thumb]:bg-white
            [&::-webkit-slider-thumb]:shadow-[0_0_0_4px_rgba(37,99,235,1)]
            [&::-webkit-slider-thumb]:rounded-full
            [&::-webkit-slider-thumb]:transition-all
            [&::-webkit-slider-thumb]:duration-150
            [&::-webkit-slider-thumb]:ease-in-out
            [&::-moz-range-thumb]:w-2.5
            [&::-moz-range-thumb]:h-2.5
            [&::-moz-range-thumb]:appearance-none
            [&::-moz-range-thumb]:bg-white
            [&::-moz-range-thumb]:border-4
            [&::-moz-range-thumb]:border-blue-600
            [&::-moz-range-thumb]:rounded-full
            [&::-moz-range-thumb]:transition-all
            [&::-moz-range-thumb]:duration-150
            [&::-moz-range-thumb]:ease-in-out
            [&::-webkit-slider-runnable-track]:w-full
            [&::-webkit-slider-runnable-track]:h-2
            [&::-webkit-slider-runnable-track]:bg-gray-100
            [&::-webkit-slider-runnable-track]:rounded-full
            [&::-moz-range-track]:w-full
            [&::-moz-range-track]:h-2
            [&::-moz-range-track]:bg-gray-100
            [&::-moz-range-track]:rounded-full" 
            id="min-and-max-range-slider-usage" 
            aria-orientation="horizontal" 
            min="{$min}" 
            max="{$max}">
        HTML;

        if ($attribute['pre']) {
            $filters .= '<span>' . $attribute['pre'] . '</span>';
        }

        $filters .= '<output for="' . $name . '" id="' . $name . 'Value">' . $max . '</output>';

        if ($attribute['post']) {
            $filters .= '<span>' . $attribute['post'] . '</span>';
        }


        $filters .= '</div>';
    }

    return $filters;
}

function get_product_filters_sorts($attributes_collection)
{
    $filter_slider_keys = get_filter_slider_keys();
    $filter_checkbox_keys = get_filter_checkbox_keys();
    $sort_keys = get_sort_keys();

    $result = [
        'sliders' => [],
        'filters' => [],
        'sorts' => []
    ];

    if (!isset($attributes_collection['attributes']) || !is_array($attributes_collection['attributes'])) {
        return $result;
    }

    $attributes = $attributes_collection['attributes'];

    // Custom sorting function
    $sortValues = function (&$array, $key) {
        if ($key === 'fire_rating') {
            $order = [
                '30 minute' => 1,
                '60 minute' => 2,
                '90 minute' => 3,
                '120 minute' => 4,
                'Not rated' => 5
            ];
            usort($array, function ($a, $b) use ($order) {
                return ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX);
            });
        } elseif ($key === 'security_rating') {
            $order = [
                'B-rated' => 1,
                'RSC-rated' => 2,
                'Not rated' => 3
            ];
            usort($array, function ($a, $b) use ($order) {
                return ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX);
            });
        } else {
            // For numeric values, convert to float for proper sorting
            if (is_numeric($array[0])) {
                usort($array, function ($a, $b) {
                    return (float)$a <=> (float)$b;
                });
            } else {
                // For strings, use regular sorting
                sort($array, SORT_STRING);
            }
        }
        return $array;
    };

    // Get and sort sliders
    $result['sliders'] = array_filter(
        $attributes,
        function ($key) use ($filter_slider_keys) {
            return in_array($key, $filter_slider_keys);
        },
        ARRAY_FILTER_USE_KEY
    );

    // Get and sort filters
    $result['filters'] = array_filter(
        $attributes,
        function ($key) use ($filter_checkbox_keys) {
            return in_array($key, $filter_checkbox_keys);
        },
        ARRAY_FILTER_USE_KEY
    );

    // Get and sort sorts
    $result['sorts'] = array_filter(
        $attributes,
        function ($key) use ($sort_keys) {
            return in_array($key, $sort_keys);
        },
        ARRAY_FILTER_USE_KEY
    );

    // Apply sorting to all arrays
    foreach ($result as &$category) {
        foreach ($category as $key => &$values) {
            $sortValues($values, $key);
        }
    }

    $filters_sorts = [];

    if (!empty($result['sliders'])) {
        $filters_sorts['sliders'] = get_filter_slider($result['sliders']);
    }

    // return $result;
    return $filters_sorts;
}

function get_product_filters_sorts_legacy($attributes_collection)
{
    if (empty($attributes_collection)) {
        return;
    }

    $filters = '<form class="mt-4 border-t border-gray-200" id="filters">';

    $slider_filters = array_filter($attributes_collection, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'slider';
    });

    if (! empty($slider_filters)) {
        $filters .= output_filter_slider($slider_filters);
    }

    $checkbox_filters = array_filter($attributes_collection, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'checkbox';
    });

    if (! empty($checkbox_filters)) {
        $filters .= output_filter_checkbox($checkbox_filters);
    }

    $filters .= '</form>';

    return $filters;
}

function get_product_sorts_by_tax() {}

function set_product_filter_array() {}

/* endregion */

/* region Attributes */
function get_product_attribute_post_id($post_id)
{
    return $post_id ?? null;
}

function get_product_attribute_image_url($post_id)
{
    return get_the_post_thumbnail_url($post_id, 'medium') ?? null;
}

function get_product_attribute_image_srcset($post_id)
{
    return wp_get_attachment_image_srcset(get_post_thumbnail_id($post_id), 'medium') ?? null;
}

function get_product_attribute_image_sizes($post_id)
{
    return wp_get_attachment_image_sizes(get_post_thumbnail_id($post_id), 'medium') ?? null;
}

function get_product_attribute_description_long($post_id)
{
    return get_field("post_product_gun_long_description", $post_id) ?? null;
}

function get_product_attribute_brand($post_id)
{
    return get_field('post_product_manufacturer', $post_id) ?? null;
}

function get_product_attribute_terms($post_id)
{
    $terms = get_the_terms($post_id, 'product_cat');

    if (! empty($terms)) {
        $attribute_terms = [];

        foreach ($terms as $term) {
            $attribute_terms[] = $term->name;
        }
    }

    return $attribute_terms;
}

function get_product_attribute_list_price($post_id)
{
    return get_product_attribute_discount_price($post_id);
}

function get_product_attribute_price($post_id)
{
    return get_product_list_price($post_id) ?? null;
}

function get_product_attribute_discount_price($post_id)
{
    return get_product_discount_price($post_id) ?? null;
}

function get_product_attribute_discount_amount($post_id)
{
    return get_product_discount_amount($post_id) ?? null;
}

function get_product_attribute_fire_rating($post_id)
{
    return get_field('post_product_fire_rating', $post_id) ?? null;
}

function get_product_attribute_weight($post_id)
{
    return get_field('post_product_gun_weight', $post_id) ?? null;
}

function get_product_attribute_security_rating($post_id)
{
    return get_field('post_product_security_rating', $post_id) ?? null;
}

function get_product_attribute_width($post_id)
{
    return get_field('post_product_gun_exterior_width', $post_id) ?? null;
}

function get_product_attribute_depth($post_id)
{
    return get_field('post_product_gun_exterior_depth', $post_id) ?? null;
}

function get_product_attribute_height($post_id)
{
    return get_field('post_product_gun_exterior_height', $post_id) ?? null;
}

function get_product_attribute_keys_filters()
{
    return [
        'brand',
        'terms',
        'price',
        'list_price',
        'discount_price',
        'discount_amount',
        'fire_rating',
        'weight',
        'security_rating',
        'width',
        'depth',
        'height',
    ];
}

function get_product_attribute_keys_post()
{
    return [
        'post_id',
        'image_url',
        'image_srcset',
        'image_sizes',
        'description_long',
    ];
}

function get_product_attributes($post_id)
{
    $attributes             = [];
    $attribute_keys_filters = get_product_attribute_keys_filters();
    $attribute_keys_post    = get_product_attribute_keys_post();
    $product_attributes     = array_merge($attribute_keys_filters, $attribute_keys_post);

    foreach ($product_attributes as $key) {
        $function_name = 'get_product_attribute_' . $key;

        if (function_exists($function_name)) {
            $attributes[$key] = call_user_func($function_name, $post_id);
        } else {
            $attributes[$key] = null;
        }
    }

    return $attributes;
}

function set_attributes_collection($attributes_collection, $post_attributes)
{
    foreach ($post_attributes as $key => $value) {

        if (! isset($attributes_collection[$key]) || ! $post_attributes[$key]) {
            continue;
        }

        if ($key === 'terms' && is_array($value)) {
            foreach ($value as $term) {
                if (! in_array($term, $attributes_collection['terms'])) {
                    $attributes_collection[$key][] = $term;
                }
            }
            continue;
        }

        if (! in_array($value, $attributes_collection[$key])) {
            $attributes_collection[$key][] = $value;
        }
    }

    return $attributes_collection;
}
/* endregion */

/* region Products */
function get_products_by_tax($queried_object)
{
    $term_id = $queried_object->term_id ?? null;

    if (! $term_id) {
        return;
    }

    $child_terms    = get_product_cat_child_terms($queried_object);
    $attribute_keys = get_product_attribute_keys_filters();
    $post_ids = [];
    $attributes_collection = array_combine($attribute_keys, array_fill(0, count($attribute_keys), []));
    $products_collection   = [];

    foreach ($child_terms as $child_term) {
        $product_posts_by_child_term = query_products_by_tax_term($child_term);

        if (! empty($product_posts_by_child_term)) {
            foreach ($product_posts_by_child_term as $product_post) {
                $product_attributes    = get_product_attributes($product_post->ID);
                $products_collection[] = get_product_grid_item($product_attributes);
                $attributes_collection = set_attributes_collection($attributes_collection, $product_attributes);
            }
        }
    }
    return [
        'products'   => $products_collection,
        'attributes' => $attributes_collection,
    ];
}

function get_product_post_data_attributes($data_attributes, $product_attributes, $filter)
{
    if (! $product_attributes[$filter]) {
        return $data_attributes;
    }

    if (is_array($product_attributes[$filter])) {
        $values = '';

        foreach ($product_attributes[$filter] as $value) {
            $values = implode(',', $product_attributes[$filter]);
        }

        return $data_attributes .= ' data-' . sanitize_title(str_replace('_', '-', $filter)) . '="' . $values . '"';
    }

    return $data_attributes .= ' data-' . sanitize_title(str_replace('_', '-', $filter)) . '="' . esc_attr($product_attributes[$filter]) . '"';
}

function product_grid_item($product_attributes)
{

    $product_card = '<a ' . $product_attributes['data_attributes'] . ' href="' . get_permalink($product_attributes['post_id']) . '" class="group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white border-gray-200 rounded-xl group/card">';
    $product_card .= '<div class="overflow-hidden h-48 w-full mx-auto">';

    if ($product_attributes['image_url']) {
        $product_card .= '<img class="!h-full w-auto  object-cover object-center rounded-t-xl transition-transform duration-300 ease-in-out group-hover:scale-105" ';
        $product_card .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
        $product_card .= 'loading="lazy "';

        if ($product_attributes['image_srcset']) {
            $product_card .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
        }

        if ($product_attributes['image_sizes']) {
            $product_card .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
        }
    }

    $product_card .= '</div>';
    $product_card .= '<div class="p-4 md:p-5">';

    $price = $product_attributes['discount_price'] ?? 'Call for pricing';
    $product_card .= '<p class="text-base font-medium">$ ' . $price . '</p>';

    $product_card .= '<h3 class="text-lg font-bold text-gray-800">';
    $product_card .= get_the_title($product_attributes['post_id']) . '</h3>';

    $product_card .= output_featured_attributes($product_attributes['post_id']);

    $product_card .= '<p class="mt-1 mb-6 text-gray-500 text-base line-clamp-2">';
    $product_card .= $product_attributes['description_long'];
    $product_card .= '</p></div></a>';

    return $product_card;
}
function get_product_grid_item($product_attributes)
{
    $data_attributes        = '';
    $attribute_keys_filters = get_product_attribute_keys_filters();

    foreach ($attribute_keys_filters as $filter) {
        $data_attributes = get_product_post_data_attributes($data_attributes, $product_attributes, $filter);
    }

    $product_attributes['data_attributes'] = $data_attributes;

    return product_grid_item($product_attributes);
}
