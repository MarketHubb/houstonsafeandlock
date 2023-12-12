<?php

function safe_grid_item($post_id, $col_width = 4) {
    $columns = ($col_width) ? 'col-md-' .  $col_width : "";

    $safes  = '<div class="' . $columns . ' mb-3">';
    $safes .= '<div class="px-4 pt-3 pb-4 p-md-4 shadow-sm border rounded product">';
    $safes .= '<div class="text-center">';
    $safes .= '<img src="' . get_the_post_thumbnail_url($post_id) . '" class="product-grid-image pt-2 pb-4"/>';

    // Capacity for Gun Safes
    if (has_term(37, 'product_cat') && get_field('post_product_gun_capacity_total', $post_id)) {
        $safes .= '<p class="text-center mb-0 pb-0"><span class="d-none fw-light">Capacity:</span> ';
        $safes .= '<span class="fw-600 text-secondary">' . get_field('post_product_gun_capacity_total', $post_id) . ' Guns</span></p>';
    }

    $safes .= '<h4>' . get_the_title($post_id) . '</h4>';
    $safes .= '</div>';
    $safes .= '<p class="product-grid-description mb-4">' . get_field('post_product_gun_long_description', $post_id) . '</p>';

    $attributes=['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];
    $attribute_array = get_formatted_product_attributes($post_id, $attributes);

    if (is_array($attribute_array)) {
        $icon_path = get_home_url() . '/wp-content/uploads/';
        $safes .= '<ul class="list-group list-group-horizontal ps-0 ms-0">';
        $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
        $safes .= '<img src="' . $icon_path . '2022/11/hsl-weigh.svg"  class="product-grid-icon me-2" />';
        $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_weight', $post_id) . 'lbs</span>';
        $safes .= '</li>';
        $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
        $safes .= '<img src="' . $icon_path . '2022/11/sl-height.svg"  class="product-grid-icon me-2" />';
        $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_height', $post_id) . '"</span>';
        $safes .= '</li>';
        $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
        $safes .= '<img src="' . $icon_path . '2022/11/sl-width.svg"  class="product-grid-icon me-2" />';
        $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_width', $post_id) . '"</span>';
        $safes .= '</li>';
        $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
        $safes .= '<img src="' . $icon_path . '2022/11/sl-length.svg"  class="product-grid-icon me-2" />';
        $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_depth', $post_id) . '"</span>';
        $safes .= '</li>';
        $safes .= '</ul>';
    }

    $safes .= '<div class="d-flex row-cols-2 justify-content-between mt-4 pt-2 gap-2 grid-btn-container">';
    $safes .= '<div class="grid-btn-container">';
    $safes .= '<a class="btn px-3 py-1 w-100 small btn-outline-secondary" href="' . get_permalink($post_id) . '">View Details</a>';
    $safes .= '</div>';
    $safes .= '<div class="grid-btn-container text-end">';
    $safes .= get_product_inquiry_btn($post_id, "Get Sale Price", null, "btn px-3 py-1 w-100 small btn-outline-primary");
    $safes .= '</div>';
    $safes .= '</div>';
    $safes .= '</div></div>';

    return $safes ?: null;
}
