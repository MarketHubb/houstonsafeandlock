<?php
// Region :: Inputs
function range_slider($data = [])
{
    if (empty($data)) return;

    $slider  = '<label for="min-and-max-range-slider-usage" class="sr-only">' . $data['label'] . '</label>';
    $slider .= '<input name="' . $data['name'] . '" id="' . $data['name'] . '" type="range" class="w-full bg-transparent cursor-pointer appearance-none disabled:opacity-50 disabled:pointer-events-none focus:outline-none';
    $slider .= '[&::-webkit-slider-thumb]:w-2.5';
    $slider .= '[&::-webkit-slider-thumb]:h-2.5';
    $slider .= '[&::-webkit-slider-thumb]:-mt-0.5';
    $slider .= '[&::-webkit-slider-thumb]:appearance-none';
    $slider .= '[&::-webkit-slider-thumb]:bg-white';
    $slider .= '[&::-webkit-slider-thumb]:shadow-[0_0_0_4px_rgba(37,99,235,1)]';
    $slider .= '[&::-webkit-slider-thumb]:rounded-full';
    $slider .= '[&::-webkit-slider-thumb]:transition-all';
    $slider .= '[&::-webkit-slider-thumb]:duration-150';
    $slider .= '[&::-webkit-slider-thumb]:ease-in-out';

    $slider .= '[&::-moz-range-thumb]:w-2.5';
    $slider .= '[&::-moz-range-thumb]:h-2.5';
    $slider .= '[&::-moz-range-thumb]:appearance-none';
    $slider .= '[&::-moz-range-thumb]:bg-white';
    $slider .= '[&::-moz-range-thumb]:border-4';
    $slider .= '[&::-moz-range-thumb]:border-blue-600';
    $slider .= '[&::-moz-range-thumb]:rounded-full';
    $slider .= '[&::-moz-range-thumb]:transition-all';
    $slider .= '[&::-moz-range-thumb]:duration-150';
    $slider .= '[&::-moz-range-thumb]:ease-in-out';

    $slider .= '[&::-webkit-slider-runnable-track]:w-full';
    $slider .= '[&::-webkit-slider-runnable-track]:h-2';
    $slider .= '[&::-webkit-slider-runnable-track]:bg-gray-100';
    $slider .= '[&::-webkit-slider-runnable-track]:rounded-full';

    $slider .= '[&::-moz-range-track]:w-full';
    $slider .= '[&::-moz-range-track]:h-2';
    $slider .= '[&::-moz-range-track]:bg-gray-100';
    $slider .= '[&::-moz-range-track]:rounded-full" id="min-and-max-range-slider-usage" aria-orientation="horizontal" min="' . $data['min'] . '" max="' . $data['max'] . '">';

    return $slider;
}

// Region :: Filters & Sorts
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

// Region :: Queries
function get_product_cat_child_terms($parent_term)
{
    return get_terms(array(
        'taxonomy' => 'product_cat',
        'parent' => $parent_term->term_id,
        'hide_empty' => true
    ));
}

function get_product_posts_by_tax($parent_tax_id = null)
{
    if (!$parent_tax_id) return;
    $output = '';
    $product_post_ids = [];
    $attributes_array = tw_safe_filters_array(); // Initialize with the filter structure

    // Fetch child categories of the current page
    $child_categories = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent' => $parent_tax_id,
        'hide_empty' => true
    ));

    // Populate the Category filter with child categories
    // if (!is_wp_error($child_categories) && !empty($child_categories)) {
    //     foreach ($child_categories as $category) {
    //         $attributes_array['Category']['values'][] = $category->name;
    //     }
    // }

    $child_terms = get_product_cat_child_terms(get_term($parent_tax_id, 'product_cat'));

    foreach ($child_terms as $term) {
        $term_posts = get_posts(array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $term->term_id
                ),
            ),
        ));

        if (!empty($term_posts)) {
            foreach ($term_posts as $term_post) {
                if (!in_array($term_post->ID, $product_post_ids)) {
                    $product_post_ids[] = $term_post->ID;

                    // Process each filter for the current post
                    foreach ($attributes_array as $filter_name => &$filter_data) {
                        if (isset($filter_data['field']) && $filter_name !== 'Category') {
                            $value = get_field($filter_data['field'], $term_post->ID);
                            if ($value && !in_array($value, $filter_data['values'])) {
                                $filter_data['values'][] = $value;
                            }
                        }
                    }

                    // You can still use safe_grid_item if needed for other purposes
                    $output .= safe_grid_item($term_post->ID);
                }
            }
        }
    }

    // Sort the values arrays
    foreach ($attributes_array as &$filter_data) {
        sort($filter_data['values']);
    }

    return [
        'output' => $output,
        'attributes' => $attributes_array
    ];
}

function get_safe_price($post_id)
{

    $shopify_data = get_pricing_data_for_safe($post_id);

    $price_field_val = (is_array($shopify_data) && !empty($shopify_data[0]['price']))
        ? $shopify_data[0]['price']
        : get_field('post_product_gun_price', $post_id);

    $price = !empty($price_field_val) ? intval($price_field_val) : 'Call for price';

    return $price ?: null;
}

// Region :: Content 
function output_featured_attributes($post_id)
{
    $featured_attributes = [
        'weight' => [
            'image' => '/2024/10/sl-height-2.svg',
            'field' => 'post_product_gun_weight',
            'post' => 'lbs'
        ],
        'height' => [
            'image' => '2022/11/sl-height.svg',
            'field' => 'post_product_gun_exterior_height',
            'post' => '"'
        ],
        'width' => [
            'image' => '2022/11/sl-width.svg',
            'field' => 'post_product_gun_exterior_width',
            'post' => '"'
        ],
        'depth' => [
            'image' => '2022/11/sl-length.svg',
            'field' => 'post_product_gun_exterior_depth',
            'post' => '"'
        ],
    ];

    $attributes = '<ul class="flex flex-none my-3 ps-0 ms-0 featured-attributes">';
    $icon_path = get_home_url() . '/wp-content/uploads/';

    foreach ($featured_attributes as $attribute => $values) {
        $value = get_field($values['field'], $post_id) . $values['post'];
        $attributes .= '<li class="block md:flex list-group-item flex-fill p-0  d-flex align-items-center no-border">';
        $attributes .= '<img src="' . $icon_path . $values['image'] . '" class="!max-w-[17px] h-auto opacity-80 me-2" />';
        $attributes .= '<span class="text-base" data-sort-type="' . strtolower($attribute) . '">' . $value . '</span>';
        $attributes .= '</li>';
    }

    $attributes .= '</ul>';

    return $attributes;
}

function output_filter_checkbox($attributes = [])
{
    $filters = '';
    $section_index = 0;

    foreach (array_reverse($attributes) as $filter_name => $filter_data) {

        $filters .= '<div class="filter-container border-t border-gray-200 py-6">';
        $filters .= '<h3 class="-mx-2 -my-3 flow-root">';
        $filters .= '<button type="button" class="flex w-full items-center justify-between bg-white !px-0 !py-3 !text-base text-gray-400 hover:text-gray-500" aria-controls="filter-section-' . $section_index . '" aria-expanded="false">';
        $filters .= '<span class="font-medium text-gray-900">' . esc_html($filter_name) . '</span>';
        $filters .= '<span class="ml-6 flex items-center">';
        $filters .= '<!-- Expand icon, show/hide based on section open state. -->';
        $filters .= '<svg class="expand-icon h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
        $filters .= '<path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />';
        $filters .= '</svg>';
        $filters .= '<!-- Collapse icon, show/hide based on section open state. -->';
        $filters .= '<svg class="collapse-icon h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">';
        $filters .= '<path fill-rule="evenodd" d="M4 10a.75.75 0 01.75-.75h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 10z" clip-rule="evenodd" />';
        $filters .= '</svg>';
        $filters .= '</span>';
        $filters .= '</button>';
        $filters .= '</h3>';
        $filters .= '<!-- Filter section, show/hide based on section state. -->';
        $filters .= '<div class="pt-6 hidden" id="filter-section-' . $section_index . '">';
        $filters .= '<div class="space-y-6">';

        foreach ($filter_data['values'] as $index => $value) {
            $item_id = sanitize_title($filter_name . '-' . $index);
            $display_value = is_array($value) ? implode(', ', $value) : $value;

            if (isset($filter_data['pre'])) {
                $display_value = $filter_data['pre'] . $display_value;
            }
            if (isset($filter_data['post'])) {
                $display_value .= $filter_data['post'];
            }

            $filters .= '<div class="flex items-center">';
            $filters .= '<input id="filter-' . $item_id . '" name="' . sanitize_title($filter_name) . '" value="' . esc_attr($value) . '" type="checkbox" class="h-4 w-4 rounded border border-gray-300 text-indigo-600 focus:ring-indigo-500" checked>';
            $filters .= '<label for="filter-' . $item_id . '" class="ml-3 min-w-0 flex-1 text-gray-500">' . esc_html($display_value) . '</label>';
            $filters .= '</div>';
        }

        $filters .= '</div>';
        $filters .= '</div>';
        $filters .= '</div>';

        $section_index++;
    }

    return $filters;
}

function output_filter_slider($attributes = [])
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

function output_filters_safes($attributes)
{
    if (empty($attributes)) return;

    $filters = '<form class="mt-4 border-t border-gray-200" id="filters">';

    $slider_filters = array_filter($attributes, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'slider';
    });

    if (!empty($slider_filters)) {
        $filters .= output_filter_slider($slider_filters);
    }

    $checkbox_filters = array_filter($attributes, function ($attribute) {
        return isset($attribute['input']) && $attribute['input'] === 'checkbox';
    });

    if (!empty($checkbox_filters)) {
        $filters .= output_filter_checkbox($checkbox_filters);
    }

    $filters .= '</form>';

    return $filters;
}
