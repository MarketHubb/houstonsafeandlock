<!-- Safe Categories -->
<div class="container-fluid py-0 py-md-5 mb-md-5">

    <?php
    $parent_product_cats = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'orderby' => 'meta_value_num',
        'meta_key' => 'output_order',
        'parent' => 0
    ));

    ?>


    <div class="row justify-content-center safe-categories-container">

        <?php
        $cats = '';

        foreach ($parent_product_cats as $parent_product_cat) {
            $term_meta = get_term_meta($parent_product_cat->term_id);
            $term_img = wp_get_attachment_url($term_meta['thumbnail_id'][0]);

            $cats .= '<div class="col-12 col-md-4 col-lg-3 col-xl-2 safe-categories">';
            $cats .= '<div class="safe-cat my-1 my-md-3">';
            $cats .= '<div class="card h-100 border-0 p-3">';
            $cats .= '<div class="p-4 text-center">';
            $cats .= '<img src="' . $term_img . '" class="card-img-top">';
            $cats .= '</div>';
            $cats .= '<div class="card-body">';
            $cats .= '<p><span class="badge bg-secondary">' . $parent_product_cat->count . ' models</span></p>';
            $cats .= '<h4 class="fw-bold">' . $parent_product_cat->name . '</h4>';
            $cats .= '<p class="product-grid-description">' . $parent_product_cat->description . '</p>';

            $child_product_cats = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'parent' => $parent_product_cat->term_id,
//                'orderby' => 'meta_value_num',
//                'meta_key' => 'output_order',
            ));


            $button_text = str_replace("Safes", "", $parent_product_cat->name);

            $mobile_cats  = '<p class="d-block d-md-none"><a class="small fw-bold" href="' . get_term_link($parent_product_cat) . '">View All ' . $parent_product_cat->name . '<i class="fa-solid fa-arrow-right ps-1"></i></a></p>';
            $mobile_cats .= '<div class="d-inline-block d-md-none dropdown">'; // start mobile dropdown
            $mobile_cats .= '<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">';
            $mobile_cats .= 'Jump to ' . $button_text . ' Category' . '</a>';
            $mobile_cats .= '<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">';


            $desktop_cats  = '<ul class="d-none d-md-block list-group list-group-flush ms-0">'; // start desktop category list
            $desktop_cats .= '<li class="list-group-item ps-0"><a href="' . get_term_link($parent_product_cat) .  '" class="small fw-bold">';
            $desktop_cats .= 'View All ' .  $parent_product_cat->name . '<i class="fa-solid fa-arrow-right ps-2"></i></a></li>';

            $price_array = [];
            $msrp_array = [];
            
            foreach ($child_product_cats as $child_product_cat) {
                
                $child_cat_posts = get_posts(array(
                    'post_type' => 'product',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $child_product_cat->term_id
                        ),
                    ),     
                ));
                
                foreach ($child_cat_posts as $child_cat_post) {
                    $number = returnIntegerFromString(get_field('post_product_gun_msrp', $child_cat_post->ID));
                    $price_array[$child_product_cat->term_id][] = $number;
                }
                
                $mobile_cats .= '<li><a class="dropdown-item" href="' . get_term_link($child_product_cat) . '">' . $child_product_cat->name . '</a></li>';
                $desktop_cats .= '<li class="list-group-item ps-0 lh-sm"><a class="small" href="' . get_term_link($child_product_cat->term_id) . '">';
                $desktop_cats .= $child_product_cat->name;
                $desktop_cats .= '<span class="d-block text-secondary">Starting at $' .  min($price_array[$child_product_cat->term_id]) . '</span>';
                $desktop_cats .= '</a></li>';
            }
/*            highlight_string("<?php\n\$price_array =\n" . var_export($price_array, true) . ";\n?>");*/
/*            highlight_string("<?php\n\$msrp_array =\n" . var_export($msrp_array, true) . ";\n?>");*/
            
            





            $desktop_cats .= '</ul>'; // end desktop category list

            $mobile_cats .= '</ul></div>'; //end mobile dropdown

            $cats .= $desktop_cats . $mobile_cats;

            $cats .= '</div></div></div></div>';
        }

        echo $cats;

        ?>

    </div>
</div>


<div class="container-fluid d-none">
    <div class="wrapper">

        <?php
            $product_cats = [37, 27, 28, 33, 42];
            $terms = get_terms( array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true,
                'include' => $product_cats,
                'orderby' => 'include'
            ));

            $i = 1;
            $cats = '';


            foreach ($terms as $term) {
                if ($term->parent === 0) {
                    $heading_order_class = ($i % 2 == 0) ? 'order-md-last' : '';
                    $cats .= '<div class="row align-items-center justify-content-end py-3 my-3 safe-categories">';
                    $cats .= '<div class="col-md-8 h-100 ' . $heading_order_class . '">';
                    $cats .= '<div class="card">';
                    $cats .= '<div class="card-body">';

                    // Medium and up
                    $cats .= '<h2 class="font-weight-bold">' . $term->name . '</h2>';
                    $cats .= '<div class="d-none d-md-block">';
                    $cats .= '<p class="lead d-none d-md-block">' . trim($term->description) . '</p>';
                    $cats .= '<a href="' . get_term_link($term) . '" class="lead font-weight-bold">';
                    $cats .= 'View All ' . $term->name . ' <i class="fas fa-long-arrow-right"></i></a>';
                    $cats .= '<p class="font-italic">' . $term->count . ' models in stock</p>';
                    $cats .= '</div></div></div></div>';

                    // Image
                    $cats .= '<div class="col-md-4 h-100 text-center">';
                    $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    $image = wp_get_attachment_url( $thumbnail_id );
                    $cats.= '<img src="' . $image . '" alt="' . $term->name . '" class="safe-cat-images" />';

                    // Small
                    $cats .= '<div class="d-md-none d-lg-none d-xl-none">';
                    $cats .= '<a href="' . get_term_link($term) . '" class="stretched-link lead font-weight-bold">';
                    $cats .= 'View All ' . $term->name . ' <i class="fas fa-long-arrow-right"></i></a>';
                    $cats .= '<p class="font-italic">' . $term->count . ' models in stock</p>';
                    $cats .= '</div>';

                    $cats .= '</div></div>';

                    $i++;
                }
            }
           // echo $cats;
            ?>
    </div>
</div>


