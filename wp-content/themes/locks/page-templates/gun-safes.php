<?php

/* Template Name: Category - Gun Safes */

get_header();

?>
<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

	<?php
	// Get post counts for filter categories (safe manufacturers)
	$amsec_query_args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'meta_key'		=> 'post_product_gun_in_stock',
		'meta_value'	=> true,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => array(51, 38, 39, 41)
			),
		),	
	);
	
	$amsec_query = new WP_Query($amsec_query_args);

	$original_query_args = array(
		'post_type' => 'product',
		'posts_per_page' => -1,
		'meta_key'		=> 'post_product_gun_in_stock',
		'meta_value'	=> true,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => 40
			),
		),	
	);
	
	$original_query = new WP_Query($original_query_args);

	 ?>

    <!-- Hero Banner -->
    <?php
    $hero_args = array('section_classes' => 'mb-0');

    if (get_field('page_include_banner')) {
        if (get_field('page_banner_style') === 'Split') {
            get_template_part('template-parts/global/content', 'hero-split', $hero_args);
        } else {
            get_template_part('template-parts/global/content', 'hero', $hero_args);
        }
    }
    ?>
	 
	 <div class="container d-none" id="custom-page-template-title" data-url="<?php echo get_home_url(); ?>">
	 	<div class="row">
	 		<div class="col-12 text-center">
<!--	 			<h1 id="category-page-heading">--><?php //the_field('page_category_gun_headline'); ?><!--</h1>-->
<!--                <p id="category-page-subheading">--><?php //echo get_field('page_category_gun_subheadline'); ?><!--</p>-->
                <?php
                if( have_rows('page_category_gun_benefits') ):
                    $benefits = '<div class="row d-md-block features-benefits">';
                    while ( have_rows('page_category_gun_benefits') ) : the_row();
                        $benefits .= '<div class="col-4 text-center p-2 p-md-5 p-lg-5">';
                        $benefits .= '<i class="' . get_sub_field('page_category_gun_benefits_icon') . ' fa-2x" style="--fa-primary-color: #cce5ff;"></i>';
                        $benefits .= '<h5>' . get_sub_field('page_category_gun_benefits_benefit') . '</h5>';
                        $benefits .= '<p class="d-none d-lg-block">' . get_sub_field('page_category_gun_benefits_description') . '</p>';
                        $benefits .= '</div>';
                    endwhile;
                endif;
                $benefits .= '</div>';
                echo $benefits;
                ?>
	 		</div>
	 	</div>
	 </div>

	<div class="container" id="sort-filter-container">
		<ul id="sort-filter-nav" class="nav nav-pills justify-content-start">
			<!-- Sort: All devices -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle filter-sort-type" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Sort By:</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" data-mixitup-control data-sort="capacity:desc">Gun Capacity</a>
					<a class="dropdown-item" data-mixitup-control data-sort="rating:desc">Fire Rating</a>
					<a class="dropdown-item" data-mixitup-control data-sort="weight:desc">Weight</a>
				</div>
			</li>
		</ul>
	</div>

	<?php

    /*
     * 38 = FV (Legacy)
     * 51 = BF (Legacy)
     * 68 = BFX
     * 69 = NF
     * 39 = SF
     * 41 = TF
     *
     * */

	$safes_by_manufacturer = array(
		'AMSEC' => array(68, 69, 39, 41),
		'Original' => array(40)
	);

	$i = 1;
	$safes = '<div class="container products">';

	foreach ($safes_by_manufacturer as $key => $val) {
		
		$query_args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $val
				),
			),	
		);
		
		$safes .= '<div class="container manufacturer-container">';
		
		// ** Causing grid layout issues on sort **
		
		// $safes .= '<div class="row mix manufacturer-' . $key . '">';
		// $safes .= '<div class="col-12"><h2>' . $key . '</h2></div>';
		// $safes .= '</div>';
		
		$safes .= '<div class="row product-list-container">';
		
		$query = new WP_Query($query_args);
		
		while ($query->have_posts()) : $query->the_post();
			
			if (get_field('post_product_gun_in_stock')) {
				
				// Product data
                $title = get_the_title();
                $current_discount = get_field('global_safes_discount_percentage', 'option');
                $msrp = get_field('post_product_gun_msrp');
                $msrp_clean = str_replace(',', '', $msrp);
                $msrp_num = round(intval($msrp_clean), 0);
                $amount_off = floor(($current_discount * .01) * $msrp_num);
				$weight = get_field('post_product_gun_weight');
				$fire_rating = get_field('post_product_gun_fire_rating');

				$gun_capacity = get_field('post_product_gun_capacity_total') ?: get_field('post_product_gun_gun_capacity');
				
				$interior_depth = round(get_field('post_product_gun_interior_depth'));
				$interior_width = round(get_field('post_product_gun_interior_width'));
				$interior_height = round(get_field('post_product_gun_interior_height'));
				$interior_dimensions = $interior_height . '" H <span class="dimension-separator">x</span> ' . $interior_width . '" W <span class="dimension-separator">x</span> ' . $interior_depth . '" D';
				
				$exterior_depth = round(get_field('post_product_gun_exterior_depth'));
				$exterior_width = round(get_field('post_product_gun_exterior_width'));
				$exterior_height = round(get_field('post_product_gun_exterior_height'));
				$exterior_dimensions = $exterior_height . '" H <span class="dimension-separator">x</span> ' . $exterior_width . '" W <span class="dimension-separator">x</span> ' . $exterior_depth . '" D';
				
				$safes .= '<div class="col-12 col-md-6 col-lg-4 product-list-item mix manufacturer-' . $key . '" ';
				$safes .= 'data-series="' . substr(get_the_title(), 0, 2) . '" ';

                $title_array = explode(' ', $title);
				$safes .= 'data-name="' . array_shift($title_array) .  '" ';

                if ($msrp && is_numeric($msrp)) {
				    $safes .= 'data-msrp="' . round($msrp, 0) . '" ';
                }

				$safes .= 'data-weight="' . $weight . '" ';
				$safes .= 'data-capacity="' . $gun_capacity . '" ';
				$safes .= 'data-rating="' . $fire_rating . '" ';
				$safes .= 'data-interior-depth="' . $interior_depth. '" ';
				$safes .= 'data-interior-width="' . $interior_width. '" ';
				$safes .= 'data-interior-height="' . $interior_height. '" ';
				$safes .= 'data-exterior-depth="' . $exterior_depth. '" ';
				$safes .= 'data-exterior-width="' . $exterior_width. '" ';
				$safes .= 'data-exterior-height="' . $exterior_height. '">';
				$safes .= '<div class="card h-100">';
				$safes .= '<div class="card-header align-items-center">';
				// $safes .= '<h5>' . $key. '<span class="badge badge-primary float-right">In-stock</span></h5>';
				
				if ($key == 'AMSEC') {
					$safes .= '<img src="' . get_home_url() . '/wp-content/uploads/2019/11/2015-AMSEC-Logo-Stacked-CMYK-1.png' . '" class="manufacturer-logo" />' . '<span class="badge badge-primary float-right align-middle">In-stock</span></h5>';
				} else if ($key == 'Original') {
					$safes .= '<img src="' . get_home_url() . '/wp-content/uploads/2019/11/ORIGINAL-LOGO-black_highres-1.png' . '" class="manufacturer-logo" />' . '<span class="badge badge-primary float-right align-middle">In-stock</span></h5>';
				}
				
				
				$safes .= '</div>';
				$safes .= '<div class="card-body p-4 mb-3">';
				$safes .= '<h3 class="card-title">' .  get_the_title() . '</h3>';
                $safes .= '<div class="d-flex justify-content-center mt-4 img-container">';
				$safes .= '<img src="' . get_the_post_thumbnail_url() . '"/>';
                $safes .= '</div>';
				$safes .= '<hr/>';
				
				// Product details
				$safes .= '<ul class="product-details-list">';
				$safes .= '<li><span class="badge text-secondary capacity">Capacity:</strong></span><span class="product-detail-value">' . $gun_capacity . ' guns</span>';
				$safes .= '<li><span class="badge text-secondary weight">Weight:</strong></span><span class="product-detail-value">' . $weight . ' lbs</span>';
				$safes .= '<li><span class="badge text-secondary rating">Fire Rating:</strong></span><span class="product-detail-value">' . $fire_rating . ' minute</span>';
				$safes .= '<li><span class="badge text-secondary exterior-height exterior-depth exterior-width">Dimensions:</strong></span><span class="product-detail-value">' . $exterior_dimensions . '' . '</span>';
				$safes .= '</ul>';
				
				// Button
				$safes .= '<div class="text-center inquiry-container pt-2 mt-2 mt-md-4">';

                $safes .= '<a href="' . get_permalink($post->ID) . '" ';
                $safes .= 'class="btn btn-primary bg-orange d-block d-md-inline-block border-0">';
                $safes .= 'View Product Details</a>';

//                $safes .= get_product_inquiry_btn($post->ID, "Get Pricing & Availability");
				$safes .= '</div>';

                // Link (Stretched)
                $safes .= '<a href="' . get_permalink() . '" class="stretched-link"></a>';
				
				$safes .= '</div></div></div>';
				
				$i++;
				
			}
			
		endwhile;
		
		$safes .= '</div>'; // End .product-list-container
		$safes .= '</div>'; // End .manufacturer-container
		
	}

	$safes .= '</div>'; // End .products

	echo $safes;


		// $terms = get_terms();
		// echo '<pre>'; print_r($terms); echo '</pre>';

	?>

	</main>
</div>


<?php get_footer(); ?>