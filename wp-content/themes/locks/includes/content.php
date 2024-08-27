<?php
function remove_extra_parent_term_from_breadcrumbs($terms)
{
    // Count items with parent = 0
    $parentZeroCount = 0;
    $parentZeroIds = [];
    $childItem = null;
    $indexToRemove = null;

    foreach ($terms as $index => $item) {
        if (is_array($item) && isset($item['parent']) && $item['parent'] === 0) {
            $parentZeroCount++;
            $parentZeroIds[] = $item['id'];
        } elseif (is_array($item) && isset($item['parent']) && $item['parent'] !== 0) {
            $childItem = $item;
        }
    }

    // If there's more than one item with parent = 0 and a child item exists
    if ($parentZeroCount > 1 && $childItem !== null) {
        // Check if the child's parent matches one of the parent = 0 items
        if (in_array($childItem['parent'], $parentZeroIds)) {
            // Find the item to remove (the one that doesn't match)
            foreach ($terms as $index => $item) {
                if (is_array($item) && isset($item['parent']) && $item['parent'] === 0 && $item['id'] !== $childItem['parent']) {
                    $indexToRemove = $index;
                    break;
                }
            }

            // Remove the item if found
            if ($indexToRemove !== null) {
                unset($terms[$indexToRemove]);
            }
        }
    }

    // Re-index the array
    return array_values($terms);
}
function get_breadcrumbs_from_queried_object($queried_object)
{
    $terms = get_the_terms($queried_object, 'product_cat');
    $breadcrumbs = [];

    $breadcrumbs[] = [
        'page' => 'Safes',
        'url' => get_permalink(3901)
    ];

    if ($terms && !is_wp_error($terms)) {
        // Custom sorting function
        usort($terms, function ($a, $b) {
            // If 'a' has no parent, it should come first
            if ($a->parent == 0) return -1;
            // If 'b' has no parent, it should come first
            if ($b->parent == 0) return 1;
            // If both have parents, maintain original order or sort by term_order if needed
            return $a->term_order <=> $b->term_order;
        });

        $childTerm = $terms[count($terms) - 1];

        if ($childTerm->parent !== 0) {
            $child_term_parent_id = $childTerm->parent;
        }

        $parent_count = 0;
        // Now $terms is sorted with "no parent" term first
        foreach ($terms as $term) {

            if ($term->parent === 0) {
                $parent_count++;
            }

            $breadcrumbs[] = [
                'page' => $term->name,
                'url' => get_term_link($term),
                'id' => $term->term_id,
                'parent' => $term->parent
            ];
        }
    }

    $breadcrumbs = remove_extra_parent_term_from_breadcrumbs($breadcrumbs);

    return $breadcrumbs;
}

function output_breadcrumbs($queried_object)
{
    $breadcrumb_data = get_breadcrumbs_from_queried_object($queried_object);

    if (!empty($breadcrumb_data)) {
        $breadcrumbs = '<ol role="list" class="tw-flex tw-items-center tw-space-x-2 tw-pl-0 tw-ml-0 tw-list-none" vocab="https://schema.org/" typeof="BreadcrumbList" id="breadcrumbs">';

        foreach ($breadcrumb_data as $breadcrumb) {
            $link_text = str_replace('by AMSEC', '', $breadcrumb['page']);
            $breadcrumbs .= '<li property="iitemListElement" typeof="ListItem">';
            $breadcrumbs .= '<div class="tw-flex tw-items-center tw-text-sm">';
            $breadcrumbs .= '<a href="' . $breadcrumb['url'] . '" property="item" typeof="WebPage" class="tw-text-gray-500 tw-tracking-wide hover:tw-text-blue-600 hover:tw-underline">';
            $breadcrumbs .= $link_text . '</a>';
            $breadcrumbs .= '<svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="breadcrumb-divide tw-ml-2 tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-gray-300"><path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" /></svg>';
            $breadcrumbs .= '</div></li>';
        }

        $breadcrumbs .= '</ol>';
    }

    return $breadcrumbs;
}

function get_product_featured_image_id($product_id)
{
    $product = wc_get_product($product_id);

    if (!$product) {
        return null;
    }

    return $product->get_image_id();
}

function custom_product_image_gallery($post_id)
{
    $product = wc_get_product($post_id);

    if (!$product) {
        return;
    }

    $attachment_ids = $product->get_gallery_image_ids();
    $main_image_id = $product->get_image_id();

    if ($main_image_id) {
        array_unshift($attachment_ids, $main_image_id);
    }

    if ($attachment_ids) {
        echo '<div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">';
        echo '<div class="woocommerce-product-gallery__wrapper">';

        foreach ($attachment_ids as $attachment_id) {
            $image_url = wp_get_attachment_image_url($attachment_id, 'full');
            $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title($attachment_id);

            echo '<div class="woocommerce-product-gallery__image">';
            echo '<a href="' . esc_url($image_url) . '">';
            echo wp_get_attachment_image($attachment_id, 'woocommerce_single', false, array(
                'class' => 'wp-post-image',
                'alt' => $image_alt,
                'title' => $image_title,
                'data-src' => $image_url,
                'data-large_image' => $image_url,
                'data-large_image_width' => wp_get_attachment_image_src($attachment_id, 'full')[1],
                'data-large_image_height' => wp_get_attachment_image_src($attachment_id, 'full')[2],
            ));
            echo '</a>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
    }
}

function safe_attribute_array()
{
    return [
        [
            'label' => 'Price',
            'field' => 'post_product_gun_price',
            'pre' => '$',
            'type' => 'sort',
            'icon' => 'price.svg',
            'attribute' => 'detail'
        ],
        [
            'label' => 'Weight',
            'field' => 'post_product_gun_weight',
            'post' => 'lbs',
            'type' => 'sort',
            'icon' => 'weight.svg',
            'attribute' => 'size'
        ],
        [
            'label' => 'Brand',
            'field' => 'post_product_manufacturer',
            'global_field' => 'filter_brand',
            'type' => 'filter',
            'attribute' => 'detail'
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
            'attribute' => 'rating'
        ],
        [
            'label' => 'Type',
            'field' => 'post_product_gun_type',
            'global_field' => 'filter_type',
            'taxonomy' => 'safe_type',
            'type' => 'filter',
            'attribute' => 'detail'
        ],
        [
            'label' => 'Width',
            'field' => 'post_product_gun_exterior_width',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'width.svg',
            'attribute' => 'size'
        ],
        [
            'label' => 'Depth',
            'field' => 'post_product_gun_exterior_depth',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'depth.svg',
            'attribute' => 'size'
        ],
        [
            'label' => 'Height',
            'field' => 'post_product_gun_exterior_height',
            'post' => '"',
            'type' => 'sort',
            'icon' => 'height.svg',
            'attribute' => 'size'
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

function get_safe_price_from_attributes($attributes)
{
    foreach ($attributes as $attribute) {
        if (
            isset($attribute['label'], $attribute['value']) &&
            $attribute['label'] === 'Price' &&
            !empty($attribute['value']) &&
            $attribute['value'] != 0
        ) {
            return $attribute['value'];
        }
    }
    return null;
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
    $safes .= '<div class="product h-100 bg-white">';


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


    // Price
    // $safe_price = get_safe_price_from_attributes($safe_attributes);
    $safe_price = get_product_pricing($post_id); 
    if (!empty($safe_price)) {
        // $safes .= '<p class="fs-5 tracking-wide">$' . $safe_price . '</p>';
        $safes .= '<p class="safe-price fs-5 inline tracking-wide">$' . $safe_price['discounted_price'] . '</p>';
    }

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
    $safes .= '<p class="product-grid-description mb-0 ' . $description_classes . '">' . get_field('post_product_gun_long_description', $post_id) . '</p>';
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
        $safes .= '<button class="fw-600 anti bg-transparent accordion-button py-0 text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product_' . $post_id . '" aria-expanded="false" aria-controls="product_' . $post_id . '">';
        $safes .= 'Product details';
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
