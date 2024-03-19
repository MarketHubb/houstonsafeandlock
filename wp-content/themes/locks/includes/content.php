<?php
function safe_attribute_array()
{
    return [
        [
            'label' => 'Price',
            'field' => 'post_product_gun_price',
            'pre' => '$',
            'type' => 'sort',
            'icon' => 'price.svg'
        ],
        [
            'label' => 'Weight',
            'field' => 'post_product_gun_weight',
            'post' => 'lbs',
            'type' => 'sort',
            'icon' => 'weight.svg'
        ],
        [
            'label' => 'Brand',
            'field' => 'post_product_manufacturer',
            'global_field' => 'filter_brand',
            'type' => 'filter',
        ],
        [
            'label' => 'Fire Rating',
            'field' => 'post_product_fire_rating',
            'global_field' => 'filter_fire_ratings',
            'type' => 'filter',
        ],
        [
            'label' => 'Security Rating',
            'field' => 'post_product_security_rating',
            'global_field' => 'filter_security_ratings',
            'type' => 'filter',
        ],
        [
            'label' => 'Type',
            'field' => 'post_product_gun_type',
            'global_field' => 'filter_type',
            'taxonomy' => 'safe_type',
            'type' => 'filter',
        ],
        [
            'label' => 'Width',
            'field' => 'post_product_gun_exterior_width',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'width.svg'
        ],
        [
            'label' => 'Depth',
            'field' => 'post_product_gun_exterior_depth',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'depth.svg'
        ],
        [
            'label' => 'Height',
            'field' => 'post_product_gun_exterior_height',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'height.svg'
        ]
    ];
}
function safe_grid_attributes($post_id)
{
    $safe_attributes = safe_attribute_array();

    foreach ($safe_attributes as $key => &$safe_attribute) {
        $field_value = get_field($safe_attribute['field'], $post_id);

        // Field value is an array
        if (is_array($field_value)) {
            $concat_value = '';
            $seperator = (empty($concat_value)) ? '' : '/';

            // Taxonomy
            if ($safe_attribute['taxonomy']) {
                $field_terms = get_terms(array(
                    'taxonomy' => $safe_attribute['taxonomy'],
                    'include' => array_values($field_value)
                ));

                foreach ($field_terms as $field_term) {
                    $seperator = (empty($concat_value)) ? '' : '/';
                    $concat_value .= $seperator . $field_term->name;
                }
            }
            // Non taxonomy
            else {
                foreach ($field_value as $value) {
                    $seperator = (empty($concat_value)) ? '' : '/';
                    $concat_value .= $seperator . $value;
                }
            }

            $field_value = $concat_value;
        }

        $safe_attribute['value'] = ($safe_attribute['label'] === 'Security Rating' && $field_value === 'Not rated') ? 'B-rated' : $field_value;
    }

    return $safe_attributes;
}

function sanitize_attribute_value($string)
{
    return trim(strtolower(str_replace(' ', '-', $string)));
}

function safe_type_badge($type)
{
    $output = '';

    if (str_contains($type, '/')) {
        $type = explode('/', $type);
        $type = array_map('trim', $type);

        foreach ($type as $badge) {
            $output .= '<span class="tw-badge">' . $badge . '</span>';
        }
    } else {
        $output .= '<span class="tw-badge">' . $type . '</span>';
    }

    return $output ?: null;
}

function format_attribute_class_name($safe_attribute)
{
    $class_name = '';
    $sanitized_val = sanitize_attribute_value($safe_attribute['value']);
    $class_prefix = trim(strtolower(str_replace(' ', '-', $safe_attribute['label']))) . '--';

    if (str_contains($sanitized_val, '/')) {
        $sanitized_val = explode('/', $sanitized_val);
        $sanitized_val = array_map('trim', $sanitized_val);

        foreach ($sanitized_val as $value) {
            $class_name .= $class_prefix . $value . ' ';
        }
    } else {
        $class_name .= $class_prefix . $sanitized_val . ' ';
    }

    return $class_name;
}

function safe_sort_badges($safe_attribute)
{
    if ($safe_attribute['value']) {
        $pre_attribute = (isset($safe_attribute['pre'])) ? $safe_attribute['pre'] : '';
        $post_attribute = (isset($safe_attribute['post'])) ? $safe_attribute['post'] : '';
        $attribute_value = $pre_attribute . $safe_attribute['value'] . $post_attribute;

        $sort_badge  = '<span class="tw-badge d-none ' . sanitize_attribute_value($safe_attribute['label']) . '">';
        $sort_badge .= '<img class="d-inline filter-badge safe-sort-icon" src="' . get_template_directory_uri() . '/images/' . $safe_attribute['icon'] . '" />';
        $sort_badge .= $attribute_value;
        $sort_badge .= '</span>';

        return $sort_badge;
    }
}

function safe_filter_badge($safe_attribute)
{
    if ($safe_attribute['value']) {
        $pre_attribute = (isset($safe_attribute['pre'])) ? $safe_attribute['pre'] : '';
        $post_attribute = (isset($safe_attribute['post'])) ? $safe_attribute['post'] : '';
        $attribute_value = $pre_attribute . $safe_attribute['value'] . $post_attribute;

        $filter_badge  = '<span class="tw-badge badge-filter d-none ' . sanitize_attribute_value($safe_attribute['label']) . '">';
        // $sort_badge .= '<img class="d-inline filter-badge safe-sort-icon" src="' . get_template_directory_uri() . '/images/' . $safe_attribute['icon'] . '" />';
        $filter_badge .= $attribute_value;
        $filter_badge .= '</span>';

        return $filter_badge;
    }
}

function safe_grid_item($post_id, $col_width = 4, $classes = null)
{
    $columns = ($col_width) ? 'col-md-' .  $col_width : "";

    // ## CONTAINER ##
    $safes  = '<div class="mix ' . $columns . ' mb-3 ';

    // Data-attributes
    $safe_attributes = safe_grid_attributes($post_id);

    if (!empty($safe_attributes)) {
        $class_names = '';
        $sort_badges = '';
        $filter_badges = '';
        $attribute_list = '';
        $attribute_output = '';

        foreach ($safe_attributes as $safe_attribute) {
            $sanitized_val = sanitize_attribute_value($safe_attribute['value']);

            // Class list
            if ($safe_attribute['type'] === 'filter') {
                $class_names .= format_attribute_class_name($safe_attribute);
                $filter_badges .= safe_filter_badge($safe_attribute);
            }

            // Sort badgets
            if ($safe_attribute['type'] === 'sort') {
                $sort_badges .= safe_sort_badges($safe_attribute);
            }

            // Date attributes
            if ($safe_attribute['type'] === 'sort') {
                $attribute_list .= 'data-' . sanitize_attribute_value($safe_attribute['label']) . '="' . sanitize_attribute_value($safe_attribute['value']) . '" ';
            }

            if ($safe_attribute['label'] === 'Brand') {
                $type_badge = safe_type_badge($safe_attribute['value']);
            }

            // Attribute grid & badge (output)
            if (!empty($safe_attribute['value'])) {
                $attribute_output .= '<div class="col-span-6">';
                $attribute_output .= '<p class="text-xs mb-0 text-capitalize fw-600">' . $safe_attribute['label'] . '</p>';
                $attribute_output .= '</div>';
                $attribute_output .= '<div class="col-span-6">';

                $pre_attribute = (isset($safe_attribute['pre'])) ? $safe_attribute['pre'] : '';
                $post_attribute = (isset($safe_attribute['post'])) ? $safe_attribute['post'] : '';
                $attribute_value = $pre_attribute . $safe_attribute['value'] . $post_attribute;

                $attribute_output .= '<p class="text-xs mb-0">' . $attribute_value . '</p>';
                $attribute_output .= '</div>';
            }
        }

        $safes .= $class_names . '" ';
        $safes .= $attribute_list;
    }

    $safes .= '>';
    $safes .= '<div class="product bg-white">';


    // ## IMAGE ##
    $safes .= '<div class="text-center p-4 pb-0 product-img-container">';
    $image_classes = $classes['image'] ?: '';
    $safes .= '<img src="' . get_the_post_thumbnail_url($post_id) . '" class="product-grid-image pb-4 ' . $image_classes . '"/>';
    $safes .= '</div>';

    // ## CONTENT ##
    $safes .= '<div class="px-4 pb-4-5 product-text-container">';

    // Capacity for Gun Safes
    if (has_term(37, 'product_cat') && get_field('post_product_gun_capacity_total', $post_id)) {
        $safes .= '<p class="text-center mb-0 pb-0"><span class="d-none fw-light">Capacity:</span> ';
        $safes .= '<span class="fw-600 text-secondary">' . get_field('post_product_gun_capacity_total', $post_id) . ' Guns</span></p>';
    }

    $safes .= '<div class="text-center">';

    // Sort Badges
    if (!empty($sort_badges)) {
        $safes .= '<div class="d-flex flex-wrap justify-content-center gap-x-6 mb-4" id="sort-badges">';
        $safes .= $sort_badges;
        $safes .= '</div>';
    }

    // Product name
    $safes .= '<h4>' . get_the_title($post_id) . '</h4>';

    // Description
    $description_classes = $classes['description'] ?: '';
    $safes .= '<p class="product-grid-description mb-4 ' . $description_classes . '">' . get_field('post_product_gun_long_description', $post_id) . '</p>';
    $safes .= '</div>';

    // Filter badges
    if (!empty($filter_badges)) {
        $safes .= '<div class="d-flex flex-wrap justify-content-center badge-gap my-3 filter-badges" id="">';
        $safes .= $filter_badges;
        $safes .= '</div>';
    }

    $attributes = ['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];

    // All attributes (new)
    if (isset($attribute_output)) {
        $safes .= '<div class="accordion accordion-flush" id="productAttributeAccordion">';
        $safes .= '<div class="accordion-item bg-transparent">';
        $safes .= '<h2 class="accordion-header" id="flush-headingOne">';
        $safes .= '<button class="fw-600 anti bg-transparent accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product_' . $post_id . '" aria-expanded="false" aria-controls="product_' . $post_id . '">';
        $safes .= 'Product attributes';
        $safes .= '</button>';
        $safes .= '</h2>';
        $safes .= '<div id="product_' . $post_id . '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#productAttributeAccordion">';
        $safes .= '<div class="accordion-body px-0">';
        $safes .= '<div class="grid grid-cols-12 gap-x-2 divide-y">';
        $safes .= $attribute_output;
        $safes .= '</div></div></div></div></div>';
    }
    // Dimension attributes (legacy)
    else {
        $attribute_array = get_formatted_product_attributes($post_id, $attributes);

        $safe_attributes = [
            ['2022/11/hsl-weigh.svg', 'post_product_gun_weight', 'lbs'],
            ['2022/11/sl-height.svg', 'post_product_gun_exterior_height', '"'],
            ['2022/11/sl-width.svg', 'post_product_gun_exterior_width', '"'],
            ['2022/11/sl-length.svg', 'post_product_gun_exterior_depth', '"'],
        ];

        if (is_array($attribute_array)) {

            $icon_path = get_home_url() . '/wp-content/uploads/';
            $safes .= '<ul class="list-group list-group-horizontal ps-0 ms-0">';

            foreach ($safe_attributes as $safe_attribute) {
                $safes .= '<li class="list-group-item flex-fill  text-center d-flex flex-column align-items-center justify-content-center no-border">'; // code...
                $safes .= '<img src="' . $icon_path . $safe_attribute['0'] . '"  class="product-grid-icon mb-1" />';
                $attribute_value = (float)get_field($safe_attribute[1], $post_id);
                $safes .=  '<span class="fw-600 grid-attr-key">' . round($attribute_value, 2) . $safe_attribute[2] . '</span>';
                $safes .= '</li>';
            }

            $safes .= '</ul>';
        }
    }



    $safes .= '<div class="d-flex row-cols-2 justify-content-between mt-4 pt-2 gap-2 grid-btn-container">';
    $safes .= '<div class="grid-btn-container">';
    $safes .= '<a class="btn px-3 py-1 w-100 small btn-outline-secondary" href="' . get_permalink($post_id) . '">View</a>';
    $safes .= '</div>';
    $safes .= '<div class="grid-btn-container text-end">';
    $safes .= get_product_inquiry_btn($post_id, "Inquiry", null, "btn px-2 py-1 w-100 small btn-outline-primary");
    $safes .= '</div>';
    $safes .= '</div>';
    $safes .= '</div></div></div>';

    return $safes ?: null;
}
