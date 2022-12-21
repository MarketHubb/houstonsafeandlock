<?php
$cat_id = $args['cat_id'];
$attributes = $args['attributes'];
$term_ids = is_array($cat_id) ? $cat_id : array($cat_id);
?>

<?php
// Get post counts for filter categories (safe manufacturers)
$safe_category_args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term_ids
        ),
    ),
);

$i = 1;
$safes  = '<div class="container products">';
$safes .= '<div class="row product-list-container">';

$safe_category_query = new WP_Query($safe_category_args);

if ($safe_category_query->have_posts()) :
    while ($safe_category_query->have_posts()) : $safe_category_query->the_post();
        // Product data
        $title = get_the_title();
        $safes .= '<div class="col-12 col-md-6 col-lg-4 product-list-item mix" ';
        $safes .= 'data-series="' . substr(get_the_title(), 0, 2) . '" ';

        $title_array = explode(' ', $title);
        $safes .= 'data-name="' . array_shift($title_array) .  '" ';

        $msrp = get_field('post_product_gun_msrp');
        $prices = get_price($msrp,20);

        $labels = '<ul class="product-details-list">';

        foreach ($attributes as $attribute) {
            $val = get_safe_attribute_values($post->ID, $attribute);
            $attr_clean = strtolower(str_replace(' ', '_', $attribute));

            $labels .= '<li class="' . $attr_clean . '">';
            $labels .= '<span class="badge text-secondary attribute-label ' . $attribute . '  w-50 text-right">';
            $labels .=  get_formatted_attributes($attribute)['name'] . ':</strong></span>';
            $labels .= '<span class="product-detail-value">';
            $labels .= $val['formatted'] . '</span>';

            if ($attr_clean === 'msrp') {
                $labels .= '<span class="badge bg-primary sale ms-4">20% Off</span>';
            }

            $labels .= '</li>';

            $safes .= 'data-' . $attribute . '="' . $val['clean'] . '" ';
        }
        $safes .= '>';
        $labels .= '</ul>';

        $safes .= '<div class="card h-100">';
        $safes .= '<div class="card-header d-flex flex-row align-items-center justify-content-between">';

        $logo = return_manufacturer_logo_for_safe(get_the_title($post->ID));
        $safes .= '<div class="d-inline-block">';
        $safes .= '<img src="' . get_home_url() . $logo;
        $safes .= '" class="manufacturer-logo" />';
        $safes .= '</div><div class="d-inline-block">';
        $safes .= '<span class="badge bg-blue float-right align-middle fw-500 fs-6">Save <span class="fw-600">' .  formatMoney($prices['discount_amount']) . '</span></span>';
        $safes .= '</h5></div>';

        $safes .= '</div>';
        $safes .= '<div class="card-body p-4 mb-3 d-flex flex-column">';

        $terms = get_the_terms($post->ID, 'product_cat');

        if (is_array($terms)) {
            foreach ($terms as $term) {
                if ($term->parent !== 0) {
                    $safes .= '<p class="text-secondary mb-1">' . $term->name . '</p>';
                }

            }
        }

        $safes .= '<h3 class="card-title">' .  get_the_title() . '</h3>';
        $safes .= '<div class="d-flex justify-content-center mt-4 img-container">';
        $safes .= '<img src="' . get_the_post_thumbnail_url() . '"/>';
        $safes .= '</div>';
        $safes .= '<hr/>';
        $safes .= $labels;

        // Button
        $safes .= '<div class="text-center inquiry-container pt-2 mt-auto">';

        $safes .= '<a href="' . get_permalink($post->ID) . '" ';
        $safes .= 'class="btn btn-primary bg-orange d-block d-md-inline-block border-0">';
        $safes .= 'View Product Details</a>';
        $safes .= '</div>';

        // Link (Stretched)
        $safes .= '<a href="' . get_permalink() . '" class="stretched-link"></a>';

        $safes .= '</div></div></div>';

        $i++;

    endwhile;

    $safes .= '</div>'; // End .product-list-container
    $safes .= '</div>'; // End .manufacturer-container

endif;

$safes .= '</div>'; // End .products

echo $safes;
?>
