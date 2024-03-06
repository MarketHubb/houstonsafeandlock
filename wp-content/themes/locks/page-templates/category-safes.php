<?php

/* Template Name: Category - Safe */

get_header();
set_query_var('modal_headline', 'Product Inquiry');

?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <ul class="nav nav-pills d-none">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Dropdown</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                </ul>
            </li>
        </ul>

        <?php

        $attributes = ['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];

        $sorts  = '<div class="container" id="sort-filter-container">';
        $sorts .= '<ul id="sort-filter-nav" class="nav nav-pills">';
        $sorts .= '<li class="nav-item dropdown">';
        $sorts .= '<a class="nav-link dropdown-toggle filter-sort-type" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">';
        $sorts .= 'Sort By:</a>';
        $sorts .= '<div class="dropdown-menu">';

        $sort_types = ['asc', 'desc'];
        foreach ($attributes as $attribute) {
            foreach ($sort_types as $sort_type) {
                $sort_label = $sort_type === 'asc' ? ' (Asc)' : ' (Desc)';
                $sorts .= '<a class="dropdown-item" data-mixitup-control data-sort="';
                $sorts .= $attribute . ':' . $sort_type . '">';
                $sorts .= get_formatted_attributes($attribute)['name'] . ' ' . $sort_label . '</a>';
            }
        }

        $sorts .= '</div></li></ul></div>';
        echo $sorts;
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
                    'terms'    => array(27)
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

                $labels = '<ul class="product-details-list">';

                foreach ($attributes as $attribute) {

                    $labels .= '<li><span class="badge text-secondary ' . $attribute . '  w-50 text-right">';
                    $labels .=  get_formatted_attributes($attribute)['name'] . ':</strong></span>';
                    $labels .= '<span class="product-detail-value">';
                    $val     = get_field('post_product_gun_' . str_replace('-', '_', $attribute));
                    // $labels .= round($val,2) . get_formatted_attributes($attribute)['postfix'] . '</span></li>';
                    $labels .= $val . get_formatted_attributes($attribute)['postfix'] . '</span></li>';

                    $safes .= 'data-' . $attribute . '="' . $val . '" ';
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
                $safes .= '<span class="badge badge-primary float-right align-middle">In-stock</span>';
                $safes .= '</h5></div>';

                $safes .= '</div>';
                $safes .= '<div class="card-body p-4 mb-3">';

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
                $safes .= '<div class="text-center inquiry-container pt-2 mt-2 mt-md-4">';

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


    </main>
</div>


<?php get_footer(); ?>