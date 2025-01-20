<?php
/* region Filters & Sorts */
function get_filter_slider_keys()
{
    return [
        'price',
        'weight',
        'width',
        'depth',
        'height',
    ];
}

function get_filter_checkbox_keys()
{
    return [
        'security_rating',
        'fire_rating',
        'terms',
        'category',
        'brand',
    ];
}

function get_sort_keys()
{
    return [
        'price',
    ];
}

function get_filter_slider($attributes)
{
    $sliders = [];

    foreach ($attributes as $slider_name => $slider_values) {
        $slider_name_formatted = strtolower(str_replace(' ', '_', $slider_name));
        $slider_name_label     = ucfirst($slider_name);
        $start_value           = (int) $slider_values[0]; // Cast to integer
        $middle_value          = (int) floor(count($slider_values) / 2);
        $end_value             = (int) $slider_values[count($slider_values) - 1];

        $output_append = '';

        if ($slider_name === 'width' || $slider_name === 'depth' || $slider_name === 'height') {
            $output_append = '"';
        } elseif ($slider_name === 'weight') {
            $output_append = 'lbs';
        }

        // Create the JSON configuration separately
        $slider_config = json_encode([
            'start'      => (int) $end_value, // Cast to integer
            'connect' => 'lower',
            'range'      => [
                'min' => $start_value,
                'max' => $end_value,
            ],
            'tooltips'   => true,
            'formatter'  => 'integer',
            'step'       => 1,
            'cssClasses' => [
                'target'    => 'relative h-2 rounded-full bg-gray-100',
                'base'      => 'w-full h-full relative z-1',
                'origin'    => 'absolute top-0 end-0 w-full h-full origin-[0_0] rounded-full',
                'handle'    => 'absolute before:hidden after:hidden !top-1/2 !end-0 !w-[1.125rem] !h-[1.125rem] bg-white border-4 border-blue-600 rounded-full cursor-pointer translate-x-2/4 -translate-y-[38%]',
                'connects'  => 'relative z-0 w-full h-full rounded-full overflow-hidden',
                'connect'   => 'absolute top-0 end-0 z-1 w-full h-full bg-blue-600 origin-[0_0]',
                'touchArea' => 'absolute -top-1 -bottom-1 -start-1 -end-1',
                'tooltip'   => 'hidden bg-white border border-gray-200 text-sm text-gray-800 py-1 px-2 rounded-lg mb-3 absolute bottom-full start-2/4 -translate-x-2/4',
            ],
        ], JSON_NUMERIC_CHECK); // Added JSON_NUMERIC_CHECK flag

        $slider_html = <<<STRING
        <div>
        <label for="min-and-max-range-slider-usage" class="font-semibold mb-2">{$slider_name_label}</label>
        <div
            id="hs-pass-value-to-html-element"
            class="relative h-2 rounded-full bg-gray-100 filter-range-slider"
            data-type="{$slider_name}"
            data-hs-range-slider='{$slider_config}'
        >
        </div>
        <div class="text-gray-500 mt-1"><span id="hs-{$slider_name_formatted}-slider-target" class="font-normal">{$middle_value}</span><span>{$output_append}</span></div>
        </div>
        STRING;

        $sliders[$slider_name] = $slider_html;
    }

    return $sliders;
}

function get_filter_checkbox($attributes)
{
    $filters = [];

    foreach ($attributes as $attribute_key => $attribute_values) {
        $name_formatted = strtolower(str_replace('_', '-', $attribute_key));
        $label          = ucfirst(str_replace('_', ' ', $attribute_key));

        if ($label === 'Terms') {
            $label = 'Categories';
        }

        // Initialize the container div for this attribute group
        $checkbox_group = <<<STRING
        <div>
        <div class="grid grid-cols-1 gap-y-2 filter-group" data-filter-group="{$name_formatted}">
            <label class="font-semibold">{$label}</label>
        STRING;

        foreach ($attribute_values as $value) {
            // Create unique ID for each checkbox
            $checkbox_id     = "checkbox-{$name_formatted}-" . sanitize_title($value);
            $value_formatted = str_replace('_', ' ', $value);

            $checkbox_group .= <<<STRING
            <div class="flex">
              <input
                type="checkbox"
                class="shrink-0 mt-0.5 border-gray-200 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                id="{$checkbox_id}"
                name="{$name_formatted}"
                value="{$value}"
                checked
              >
              <label for="{$checkbox_id}" class=" text-gray-500 ms-3">{$value_formatted}</label>
            </div>
            STRING;
        }

        // Close the container div
        $checkbox_group .= "\n</div></div>";

        $filters[$attribute_key] = $checkbox_group;
    }

    return $filters;
}

function get_sorts_dropdown($attributes)
{
    $sort_options = array_keys($attributes);

    // Initialize the dropdown HTML
    $dropdown_html = <<<STRING
    <div class="m-1 hs-dropdown [--auto-close:inside] relative inline-flex" data-hs-dropdown-auto-close="inside">
    <button id="hs-dropdown-item-checkbox" type="button" class="hs-dropdown-toggle py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
        Sort
    <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
    </button>

    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:z-50 hs-dropdown-open:ml-12 hs-dropdown-open:mb-12 hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md ring-1 ring-gray-200 rounded-lg p-1 space-y-0.5 mt-2" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-item-checkbox">
    STRING;

    // Add menu items for each sort option
    foreach ($sort_options as $index => $option) {
        $label = ucfirst($option);
        $dropdown_html .= <<<STRING
        <div class="flex gap-x-2 py-2 px-3 rounded-lg hover:bg-gray-100">
            <input id="{$option}-asc" name="sort" type="radio" data-sort="{$option}" data-direction="asc" class="mt-0.5 shrink-0 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" aria-describedby="sort">
            <label for="{$option}-asc">
                <span class="block text-sm font-semibold text-gray-800">{$label}</span>
                <span id="{$option}-asc" class="block text-sm text-gray-600">Low to High</span>
            </label>
        </div>
        <div class="flex gap-x-2 py-2 px-3 rounded-lg hover:bg-gray-100">
            <input id="{$option}-desc" name="sort" type="radio" data-sort="{$option}" data-direction="desc" class="mt-0.5 shrink-0 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" aria-describedby="sort">
            <label for="{$option}-desc">
                <span class="block text-sm font-semibold text-gray-800">{$label}</span>
                <span id="{$option}-desc" class="block text-sm text-gray-600">High to Low</span>
            </label>
        </div>
        STRING;
    }

    $dropdown_html .= <<<STRING
    </div></div>
    STRING;

    return $dropdown_html;
}

function get_product_filters_sorts($attributes_collection)
{
    $filter_slider_keys   = get_filter_slider_keys();
    $filter_checkbox_keys = get_filter_checkbox_keys();
    $sort_keys            = get_sort_keys();

    $result = [
        'sliders' => [],
        'filters' => [],
        'sorts'   => [],
    ];

    if (! isset($attributes_collection['attributes']) || ! is_array($attributes_collection['attributes'])) {
        return $result;
    }

    $attributes = $attributes_collection['attributes'];

    // Custom sorting function
    $sortValues = function (&$array, $key) {
        if ($key === 'fire_rating') {
            $order = [
                '30 minute'  => 1,
                '60 minute'  => 2,
                '90 minute'  => 3,
                '120 minute' => 4,
                'Not rated'  => 5,
            ];
            usort($array, function ($a, $b) use ($order) {
                return ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX);
            });
        } elseif ($key === 'security_rating') {
            $order = [
                'B-rated'   => 1,
                'RSC-rated' => 2,
                'Not rated' => 3,
            ];
            usort($array, function ($a, $b) use ($order) {
                return ($order[$a] ?? PHP_INT_MAX) <=> ($order[$b] ?? PHP_INT_MAX);
            });
        } else {
            // For numeric values, convert to float for proper sorting
            if (is_numeric($array[0])) {
                usort($array, function ($a, $b) {
                    return (float) $a <=> (float) $b;
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

    if (! empty($result['sliders'])) {
        $filters_sorts['sliders'] = get_filter_slider($result['sliders']);
    }

    if (! empty($result['filters'])) {
        $filters_sorts['filters'] = get_filter_checkbox($result['filters']);
    }

    if (! empty($result['sorts'])) {
        $filters_sorts['sorts'] = get_sorts_dropdown($result['sorts']);
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

function get_product_attribute_table($post_id)
{
    return get_the_content(null, false, $post_id) ?? null;
}

function get_product_attribute_callouts($post_id)
{
    return get_the_excerpt($post_id) ?? null;
}

function get_product_attribute_gun_capacity($post_id)
{
    return get_field('post_product_gun_gun_capacity', $post_id) ?? null;
}

function get_product_attribute_gun_capacity_total($post_id)
{
    return get_field('post_product_gun_capacity_total', $post_id) ?? null;
}

function get_product_attribute_brand($post_id)
{
    return get_field('post_product_manufacturer', $post_id) ?? null;
}

function get_product_attribute_terms_all($post_id)
{
    $terms = get_the_terms($post_id, 'product_cat');

    return !empty($terms)
        ? $terms
        : null;
}
function get_product_attribute_terms($post_id, $tax_page = true)
{
    $terms = get_the_terms($post_id, 'product_cat');
    if (empty($terms) || is_wp_error($terms)) {
        return [];
    }

    // Filter terms and extract names
    return array_map(
        fn($term) => $term->name,
        array_filter($terms, function ($term) use ($tax_page) {
            return  ! in_array($term->term_id, [75, 78]) &&
                ($tax_page ? $term->parent :  ! $term->parent);
        })
    );
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

function get_product_attribute_filter_keys()
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

function get_product_attribute_post_keys()
{
    return [
        'post_id',
        'image_url',
        'image_srcset',
        'image_sizes',
        'description_long',
        'table',
        'callouts',
        'gun_capacity',
        'gun_capacity_total',
    ];
}

function get_product_attributes($post_id, $tax_page = true)
{
    $attributes             = [];
    $attribute_keys_filters = get_product_attribute_filter_keys();
    $attribute_keys_post    = get_product_attribute_post_keys();
    $product_attributes     = array_merge($attribute_keys_filters, $attribute_keys_post);

    foreach ($product_attributes as $key) {
        $function_name = 'get_product_attribute_' . $key;

        if (function_exists($function_name)) {
            if ($key !== 'terms') {
                $attributes[$key] = call_user_func($function_name, $post_id);
            } else {
                $attributes[$key] = call_user_func($function_name, $post_id, $tax_page);
            }
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
function get_product_collection($terms, $tax_page = true)
{
    $attribute_keys        = get_product_attribute_filter_keys();
    $attributes_collection = array_combine($attribute_keys, array_fill(0, count($attribute_keys), []));
    $products_collection   = [];
    $products_data         = [];

    foreach ($terms as $term) {
        $product_posts_by_term = query_products_by_tax_term($term);

        if (! empty($product_posts_by_term)) {
            foreach ($product_posts_by_term as $product_post) {
                $product_attributes    = get_product_attributes($product_post->ID, $tax_page);
                $products_data[]       = $product_attributes;
                $products_collection[] = get_product_grid_item($product_attributes);
                $attributes_collection = set_attributes_collection($attributes_collection, $product_attributes);
            }
        }
    }
    return [
        'data'       => $products_data,
        'products'   => $products_collection,
        'attributes' => $attributes_collection,
    ];
}

function get_products_by_tax($queried_object)
{
    $tax_page = true;

    if ($queried_object->term_id) {
        $terms = get_product_cat_child_terms($queried_object);
    } else {
        $terms    = get_product_cat_tax_terms(false);
        $tax_page = false;
    }

    if (! empty($terms)) {
        return get_product_collection($terms, $tax_page);
    }
}

function sort_products_by_price($data, $direction = 'asc')
{
    usort($data, function ($a, $b) use ($direction) {
        // If both items have no price, maintain original order
        if (! $a['price'] && ! $b['price']) {
            return 0;
        }

        // If only one item has no price, move it to the end
        if (! $a['price']) {
            return 1;
        }

        if (! $b['price']) {
            return -1;
        }

        // Both items have prices, compare them
        $comparison = floatval($a['price']) - floatval($b['price']);

        // Return based on direction
        return $direction === 'asc' ? $comparison : -$comparison;
    });

    return $data;
}

function get_product_post_data_attributes($data_attributes, $product_attributes, $filter)
{
    $values = '';

    if ($product_attributes[$filter]) {

        if (is_array($product_attributes[$filter])) {

            foreach ($product_attributes[$filter] as $value) {
                $values = implode(',', $product_attributes[$filter]);
            }
        } else {
            $values = $product_attributes[$filter];
        }
    }

    return $data_attributes .= ' data-' . sanitize_title(str_replace('_', '-', $filter)) . '="' . esc_attr($values) . '"';
}

function get_product_sale_callout(int $post_id, string $location)
{
    $discount = get_product_discount_amount($post_id);

    if (!isset($post_id) || !isset($location) || !$discount) return;

    $callout = '';

    if ($location === 'grid') {
        $callout .= '<p class="text-red-500 text-xs sm:text-base sm:text-center leading-tight font-semibold antialiased px-1">';
        $callout .= 'Save <strong class="!font-bolder border-b border-red-500 underline-offset-2">$' . remove_cents_from_currency($discount) . '</strong> ';
        $callout .= 'during our <span class="font-semibold">' . get_sale_title() . '</span> sale';
    }

    return $callout;
}

function product_grid_item($product_attributes)
{

    $product_card = '<a ' . $product_attributes['data_attributes'] . ' href="' . get_permalink($product_attributes['post_id']) . '" class="group product-item text-center md:text-left h-full sm:h-auto flex flex-col bg-white rounded ring-1 shadow-sm ring-gray-200 border-gray-200 group/card">';
    $product_card .= '<div class="flex justify-center h-48 w-full overflow-hidden rounded-md group-hover:opacity-75 lg:h-56 xl:h-64 p-4 mx-auto">';

    if ($product_attributes['image_url']) {
        $product_card .= '<img class="!h-[90%] sm:!h-[95%] !w-auto max-w-full inline-block object-cover transition-transform duration-300 ease-in-out group-hover:scale-105" ';
        $product_card .= ' src="' . esc_url($product_attributes['image_url']) . '" ';
        $product_card .= 'loading="lazy"';

        if ($product_attributes['image_srcset']) {
            $product_card .= 'srcset=" ' . $product_attributes['image_srcset'] . '" ';
        }

        if ($product_attributes['image_sizes']) {
            $product_card .= 'sizes="' . $product_attributes['image_sizes'] . '" />';
        }
    }

    $product_card .= '</div>';
    $product_card .= '<div class="bg-gray-50 sm:!bg-transparent opacity-100 sm:opacity-95 px-2 pt-5 pb-2 sm:px-3 lg:px-4 xl:px-6 h-full sm:h-auto sm:pb-6">';

    if (! empty($product_attributes['discount_price'])) {
        $price = get_product_price_format($product_attributes['discount_price']);
        // $price = get_product_price_format($product_attributes);
        // $price_split = split_price($product_attributes['discount_price']);
        // $price  = '<div class="inline-flex justify-center items-center sm:items-start text-gray-800">';
        // $price .= '<span class="text-xs sm:text-base font-bold antialiased tracking-tight !leading-none font-system">$</span>';
        // $price .= '<span class="text-base sm:text-[1.4rem] font-semibold tracking-normal align-middle !leading-none pl-[1px] font-system relative sm:bottom-[2px]">' . $price_split['dollars'] . '</span>';
        // $price .= '<span class=" inline-flex font-system pl-[.02rem]">';
        // $price .= '<span class="inline-flex text-xs sm:text-base font-semibold tracking-tight align-start !leading-none relative font-system">.' . $price_split['cents'] . '</span>';
        // $price .= '</span>';
        // $price .= '</div>';

        if (!empty($product_attributes['price'])) {
            $price .= '<div class="inline-block"><span class="text-gray-600 sm:text-gray-500 line-through text-sm sm:text-base">$';
            $price .= remove_cents_from_currency($product_attributes['price']) . '</span></div>';
        }
    } else {
        $price = 'Call for pricing';
    }
    $product_card .= '<div class="flex justify-center gap-x-2 items-center mb-3">' . $price . '</div>';

    $product_card .= '<h3 class="text-base md:text-base lg:text-lg xl:text-xl font-bold antialiased tracking-tight sm:tracking-normal !leading-snug text-gray-900 mb-4 text-center">';
    $product_card .= get_the_title($product_attributes['post_id']) . '</h3>';

    $product_card .= output_featured_attributes($product_attributes['post_id']);

    $product_card .= '<p class="mt-1 mb-6 text-gray-800 text-sm sm:text-base line-clamp-3 sm:line-clamp-2">' . $product_attributes['description_long'] . '</p>';

    if (is_sale_active()) {
        $product_card .= get_product_sale_callout($product_attributes['post_id'], 'grid');
    }

    $product_card .= '</div></a>';

    return $product_card;
}

function get_product_grid_item($product_attributes)
{
    $data_attributes        = '';
    $attribute_keys_filters = get_product_attribute_filter_keys();

    foreach ($attribute_keys_filters as $filter) {
        $data_attributes = get_product_post_data_attributes($data_attributes, $product_attributes, $filter);
    }

    $product_attributes['data_attributes'] = $data_attributes;

    return product_grid_item($product_attributes);
}
