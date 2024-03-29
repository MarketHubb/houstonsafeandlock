<?php
$obj = get_queried_object();
$child_term = $args;
$safes = '<div class="row safes product-grid" data-bs-spy="scroll" data-bs-target="#navbar-product-cats" data-bs-offset="0" tabindex="0">';
$i = 1;

// Post query args
$query_args = [
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'terms'    => $child_term
        ),
    ),
];

$query = new WP_Query($query_args);

if ($query->have_posts()) :
    $cat_image = get_product_cat_image(get_term($child_term));

    if ($obj->parent === 0) {
        $safes .= '<div class="sub-category-container py-3 py-md-3 my-4" id="scrollspyHeading' . $i . '">';
        $safes .= '<div class="row sub-category-heading mb-3">';
        $safes .= '<div class="col-12 col-md-8">';
        $safes .= '<h2>' . get_term($child_term)->name . '</h2>';
        $safes .= '<p>' . get_term($child_term)->description . '</p>';
        $safes .= '</div><div class="col-4 d-none d-md-block text-center">';

        if ($cat_image) {
            $safes .= '<img src="' . $cat_image . '" class="sub-category-image"/>';
        }

        $safes .= '</div></div>';
    }



    // Terms query args
    $child_terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => $obj->parent
    ));

    if ($child_terms) {
        $safes .= get_sticky_sub_category_nav($child_terms, $obj->term_id, $obj->parent);
    }

    $safes .= '<div class="row sub-category-list">';

    while ($query->have_posts()) : $query->the_post();
        $safes .= '<div class="col-md-4 mb-3">';
        $safes .= '<div class="px-4 pt-3 pb-4 p-md-4 shadow-sm border rounded product">';

        $safes .= '<div class="text-center">';
        $safes .= '<img src="' . get_the_post_thumbnail_url() . '" class="product-grid-image pt-2 pb-4"/>';

        // Capacity for Gun Safes
        if (has_term(37, 'product_cat') && get_field('post_product_gun_capacity_total', $post->ID)) {
            $safes .= '<p class="text-center mb-0 pb-0"><span class="d-none fw-light">Capacity:</span> ';
            $safes .= '<span class="fw-600 text-secondary">' . get_field('post_product_gun_capacity_total') . ' Guns</span></p>';
        }

        $safes .= '<h4>' . get_the_title() . '</h4>';
        $safes .= '</div>';
        $safes .= '<p class="product-grid-description mb-4">' . get_field('post_product_gun_long_description') . '</p>';

        $attributes=['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];
        $attribute_array = get_formatted_product_attributes($post->ID, $attributes);

        if (is_array($attribute_array)) {
            $icon_path = get_home_url() . '/wp-content/uploads/';
            $safes .= '<ul class="list-group list-group-horizontal ps-0 ms-0">';
            $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
            $safes .= '<img src="' . $icon_path . '2022/11/hsl-weigh.svg"  class="product-grid-icon me-2" />';
            $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_weight') . 'lbs</span>';
            $safes .= '</li>';
            $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
            $safes .= '<img src="' . $icon_path . '2022/11/sl-height.svg"  class="product-grid-icon me-2" />';
            $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_height') . '"</span>';
            $safes .= '</li>';
            $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
            $safes .= '<img src="' . $icon_path . '2022/11/sl-width.svg"  class="product-grid-icon me-2" />';
            $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_width') . '"</span>';
            $safes .= '</li>';
            $safes .= '<li class="list-group-item flex-fill  text-center d-flex align-items-center justify-content-center no-border">';
            $safes .= '<img src="' . $icon_path . '2022/11/sl-length.svg"  class="product-grid-icon me-2" />';
            $safes .=  '<span class="fw-500  grid-attr-key">' . get_field('post_product_gun_exterior_depth') . '"</span>';
            $safes .= '</li>';
            $safes .= '</ul>';
        }

        $safes .= '<div class="d-flex row-cols-2 justify-content-between mt-4 pt-2 gap-2 grid-btn-container">';
        $safes .= '<div class="grid-btn-container">';
        $safes .= '<a class="btn px-3 py-1 w-100 small btn-outline-secondary" href="' . get_permalink() . '">View Details</a>';
        $safes .= '</div>';
        $safes .= '<div class="grid-btn-container text-end">';
//        $safes .= '<a class="btn px-3 py-1 w-100 small btn-outline-primary" href="' . get_permalink() . '">Get Sale Price</a>';
        $safes .= get_product_inquiry_btn($post->ID, "Request Pricing", $stretched=null, $custom_classes="btn px-3 py-1 w-100 small btn-outline-primary");
        $safes .= '</div>';
        $safes .= '</div>';

        // Link (Stretched)
//        $safes .= '<a href="' . get_permalink() . '" class="stretched-link"></a>';
        $safes .= '</div></div>';

    endwhile;
    $safes .= '</div>';
endif;
$safes .= '</div>';
$i++;


$safes .= '</div>';

echo $safes;
?>
