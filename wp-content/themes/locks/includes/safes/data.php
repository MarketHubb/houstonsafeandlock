<?php
function product_attributes($post_id)
{
    $attributes     = [];
    $attribute_keys = ['series', 'post_id', 'weight', 'width', 'depth', 'height', 'category', 'fire_rating', 'security_rating'];

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

function safe_data_attributes(int $post_id, bool $featured)
{
    $product_attributes = product_attributes($post_id);

    if (! is_array($product_attributes) || empty($product_attributes)) {
        return null;
    }

    $featured_val = $featured ? 1 : 0;
    $product_attributes['featured'] = $featured_val;


    $data_attributes = '';

    foreach ($product_attributes as $key => $attribute) {
        $attribute_value = $key === 'category'
            ? $attribute[0]->name
            : $attribute;

        $data_attributes .= 'data-' . $key . '="' . data_attribute_input_value($attribute_value) . '" ';
    }

    return $data_attributes;
}

function get_product_description_long_array($product_attributes)
{
    $description = array_key_exists('description_long', $product_attributes) && !empty($product_attributes['description_long'])
        ? $product_attributes['description_long']
        : get_product_attribute_description_long($product_attributes['post_id']);

    if (empty($description)) return;

    $description = array_filter(explode('.', $description), 'strlen');
    $description = array_values($description);

    return is_array($description) && !empty($description)
        ? $description
        : null;
}

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
        $label          = ucfirst(str_replace('_', ' ', $attribute_key));

        if ($label === 'Terms') {
            $label = 'Categories';
            array_unshift($attribute_values, 'All Safes', 'Featured Safes');
        }

        $name_formatted = strtolower(str_replace('_', '-', $attribute_key));
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

function get_product_range_filter_data($attributes_collection)
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

function get_product_attribute_series($post_id)
{
    $series = get_field('post_product_gun_series', $post_id);

    if (is_array($series) && !empty($series)) {
        return $series[0] ?? null;
    }

    return null;
}

function get_product_attribute_brand($post_id)
{
    return get_field('post_product_manufacturer', $post_id) ?? null;
}

function get_product_attribute_model($post_id)
{
    if (empty($post_id)) return null;

    $title = get_the_title($post_id);
    $brand = get_product_attribute_brand($post_id) ?? null;

    if ($title && $brand) {
        $model = str_replace($brand, '', $title);

        if (str_contains($title, 'Second Amendment') && $brand === 'Blue Dot') {
            $brand = 'Second Amendment';
            $title = str_replace('Second Amendment', '', $title);
        } elseif ($brand === 'AMSEC') {
            $brand = !str_contains($brand, 'AMSEC') ? $brand : 'American Security';
        } elseif ($brand !== 'AMSEC') {
            $title = $model;
        }
    }

    return $model ?? null;
}

function get_product_attribute_terms_all($post_id)
{
    $terms = get_the_terms($post_id, 'product_cat');

    return !empty($terms)
        ? $terms
        : null;
}

function get_product_parent_terms($post_id)
{
    return  get_terms(array(
        'taxonomy'   => 'product_cat',
        'object_ids' => $post_id,
        'parent'     => 0,
        'exclude'    => array(75, 78),
    ));
}

function get_product_parent_tax_name(int $safe_id)
{
    $parent_terms = get_product_parent_terms($safe_id);

    return is_array($parent_terms) && ! empty($parent_terms[0])
        ? remove_safes_from_string($parent_terms[0]->name)
        : null;
}

function get_product_attribute_terms($post_id, $tax_page = true)
{
    $terms = get_the_terms($post_id, 'product_cat');

    if (empty($terms) || is_wp_error($terms)) {
        return [];
    }

    // Filter terms and extract names
    $post_terms = array_map(
        fn($term) => $term->name,
        array_filter($terms, function ($term) use ($tax_page) {
            return  ! in_array($term->term_id, [75, 78]) &&
                ($tax_page ? $term->parent :  ! $term->parent);
        })
    );

    return !empty($post_terms)
        ? array_merge($post_terms)
        : null;
}

// function get_product_attribute_list_price($post_id)
// {
//     return get_product_attribute_discount_price($post_id);
// }

// function get_product_attribute_price($post_id)
// {
//     return get_product_list_price($post_id) ?? null;
// }

function get_product_list_price($post_id)
{
    $list_price = get_pricing_source() === 'Shopify' ? get_product_attribute_price_shopify($post_id) : get_product_attribute_price_website($post_id);

    $list_price = $list_price ?? get_product_attribute_price_website($post_id);

    return $list_price ?? null;
}

function get_product_attribute_price_website($post_id)
{
    $price = get_field('post_product_gun_price', $post_id);

    return $price ?? null;
}


function get_product_attribute_price_shopify($post_id)
{
    $shopify_data = get_field('product_inventory', $post_id);

    if (isset($shopify_data) && ! empty($shopify_data[0]['price'])) {
        $price = $shopify_data[0]['price'];
    }

    return $price ?? null;
}

function get_product_discount_percentage()
{
    if (is_sale_enabled() && get_sale_discount() > 0) {
        return get_sale_discount();
    }

    return get_global_discount();
}

function get_product_attribute_discount_price($post_id)
{
    // Get the original list price
    $list_price = get_product_list_price($post_id);

    // Return early if no list price exists
    if (!$list_price) {
        return null;
    }

    // Get the discount percentage
    $discount_percentage = get_product_discount_percentage();

    // If no discount or zero discount, return the original price (properly formatted)
    if (!$discount_percentage || $discount_percentage === 0) {
        // Create a NumberFormatter object for currency
        $fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);
        return numfmt_format_currency($fmt, floatval($list_price), 'USD');
    }

    // Calculate the discounted price
    $discount_price = floatval($list_price) * (1 - $discount_percentage / 100.0);

    // Format the result as currency
    $fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);
    return numfmt_format_currency($fmt, $discount_price, 'USD');
}

function get_product_attribute_discount_amount(int $post_id = null)
{
    // Get the original price
    $price = get_product_list_price($post_id);

    // Return early if no price exists
    if (!$price) {
        return null;
    }

    // Determine the appropriate discount percentage (consolidated logic)
    $discount_percentage = 0;
    if (is_sale_enabled() && get_sale_discount() > 0) {
        $discount_percentage = get_sale_discount();
    } else {
        $discount_percentage = get_global_discount();
    }

    // Calculate the discount amount
    $discount_amount = floatval($price) * ($discount_percentage / 100.0);

    // Format the discount amount as currency
    $fmt = numfmt_create('en_US', NumberFormatter::CURRENCY);
    return numfmt_format_currency($fmt, $discount_amount, 'USD');
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
        'series',
        'model',
        'terms',
        // 'price',
        // 'list_price',
        // 'discount_price',
        // 'discount_amount',
        'fire_rating',
        'weight',
        'security_rating',
        'width',
        'depth',
        'height',
        'featured',
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
        // 'gun_capacity',
        // 'gun_capacity_total',
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

function tw_safe_filters_array()
{
    $filters = [
        "Brand" => [
            "type" => "filter",
            "input" => "checkbox",
            "field" => "post_product_manufacturer",
            "values" => [],
        ],
        "Category" => [
            "type" => "filter",
            "input" => "checkbox",
            "values" => [],
        ],
        "Price" => [
            "type" => "sort",
            "input" => "slider",
            "field" => "post_product_gun_price",
            'pre' => '$',
            "values" => [],
        ],
        "Weight" => [
            "type" => "sort",
            "input" => "slider",
            "field" => "post_product_gun_weight",
            'post' => 'lbs',
            "values" => [],
        ],
        "Fire Rating" => [
            "type" => "filter",
            "input" => "checkbox",
            "field" => "post_product_fire_rating",
            "values" => [],
        ],
        "Security Rating" => [
            "type" => "filter",
            "input" => "checkbox",
            "field" => "post_product_security_rating",
            "values" => [],
        ],
        "Width" => [
            "type" => "sort",
            "input" => "slider",
            "field" => "post_product_gun_exterior_width",
            'post' => '"',
            "values" => [],
        ],
        "Depth" => [
            "type" => "sort",
            "input" => "slider",
            "field" => "post_product_gun_exterior_depth",
            'post' => '"',
            "values" => [],
        ],
        "Height" => [
            "type" => "sort",
            "input" => "slider",
            "field" => "post_product_gun_exterior_height",
            'post' => '"',
            "values" => [],
        ],
    ];
    return $filters;
}
