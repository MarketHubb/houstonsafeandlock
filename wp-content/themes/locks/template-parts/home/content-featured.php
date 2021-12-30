<div class="section-container bg-grey mb-5">

    <div class="container-fluid content-section">
        <div class="wrapper">

            <div class="row justify-content-center section-heading">
                <div class="col-md-10 text-center">
                    <h2 class="font-weight-bold text-center">Our Unmatched Selection of Safes</h2>
                    <p class="lead font-weight-normal mb-0">Our local Houston safe showroom is the largest safe showroom in Texas with 5,000 sq ft of space and offers the opportunity to view hundreds of models of gun safes, commercial safes, and home and office safes. Our knowledgeable sales staff is here to help educate you to find the perfect safe to fit your personal, business, or commercial security needs.</p>
                </div>
            </div>

            <div class="content-section">
                <div class="row justify-content-center">

                    <?php

                    $safe_cat_array = array(
                        '28' => '2154',
                        '37' => '2306',
                        '27' => '2288',
                        '42' => '2280',
//                        '33' => '2215',
                    );

                    $featured = '';

                    foreach ($safe_cat_array as $cat_id => $cat_img) {

                        if( $term = get_term_by( 'id', $cat_id, 'product_cat' ) ) {

                            $featured .= '<div class="col-md-3">';
                            $featured .= '<div class="card p-4 text-center rounded shadow h-100">';
                            $featured .= '<h2 class="mb-3 fs-2">' . $term->name . '</h2>';
//                            $featured .= '<span class="gold">' . $type . '</span>';
//                            $featured .= '<p class="mt-3">' . get_field('post_product_gun_model_description', $safe) . '</p>';
                            $featured .= '<div class="text-center">';
                            $featured .= '<img src="' . get_the_post_thumbnail_url($cat_img) . '" class="w-75"/>';
                            $featured .= '</div>';
                            $featured .= '<a href="' . get_term_link($cat_id, 'product_cat') . '" class="stretched-link"></a>';
                            $featured .= '</div></div>';

                        }

                    }

                    echo $featured;
                    ?>

                </div>
            </div>

        </div>
    </div>

</div>