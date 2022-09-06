<!--<div class="container-fluid content-section" id="used-safes">-->
<!--    <div class="wrapper">-->
<div class="container content-section" id="used-safes">
            <?php
            $query_args = array(
                'post_type' => 'used_safes',
                'posts_per_page' => -1
            );
            $query = new WP_Query($query_args);
            if ($query->have_posts()) :
                $u = '';
            	while ($query->have_posts()) : $query->the_post();
                
                    if (!get_field('sold')) {
                        $u .= '<div class="used-container border-bottom">';
                        $u .= '<div class="row align-items-center justify-content-between align-items-center py-2j">';
                        $u .= '<div class="col-md-4">';
                        $u .= '<div class="card no-borders h-100">';
                        $u .= '<div class="card-header bg-transparent align-items-center px-4">';
                        $u .= '<div class="d-flex flex-row justify-content-between align-items-center">';
                        $u .= '<div class="text-center"><h5 class="lh-base mb-0 pb-0 fw-light text-decoration-line-through">';
                        $u .= '$' . get_field('list_price');
                        $u .= '</h5></div>';
                        $u .= '<div class="text-center"><h5 class="fw-bold fw-bold text-danger mb-0 pb-0">';
                        $u .= return_discount(get_field('list_price'), get_field('sale_price')) . '% Off Sale';
                        $u .= '</h5></div>';
                        $u .= '<div class="text-center"><h5 class="lh-base mb-0 pb-0">';
                        $u .= '$' . get_field('sale_price');
                        $u .= '</h5></div>';
                        $u .= '</div></div>';
                        $u .= '<div class="card-body no-border p-4">';
                        $u .= '<h5 class="mb-2 fw-bold text-uppercase">' . get_field('brand') . '</h5>';
                        $u .= '<h2 class="card-title fw-bolder mb-4">' . get_the_title() . '</h2>';
                        $u .= '<p class="card-text">' . get_field('description') . '</p>';

                        $first_image_id = get_repeater_field_row('images', 1, 'image', get_the_ID());
                        $first_image = wp_get_attachment_image_src($first_image_id, 'full');

                        $u .= '<button id="" type="button"
                        class="my-4 btn btn-primary inline-block bg-orange border-0 shadow px-4 px-lg-5 fw-500"
                        data-bs-toggle="modal"
                        data-bs-target="#productModal"
                        data-safeformid="4"
                        data-safetype=""
                        data-safename="Used - ' . get_field('brand') . ' ' . get_the_title() . '"
                        data-safeimage="' . $first_image[0] . '"/>
                        <span class="d-inline-block">Product Inquiry</span>
                </button>';
                        $u .= '</div></div></div>';

                        $u .= '<div class="col-md-7">';
                        $u .= '<div class="row align-items-center justify-content-start px-4 px-lg-0 py-0">';

                        if (have_rows('images')):
                            $i = '';
                            while (have_rows('images')) : the_row();
                                $sizes = wp_get_registered_image_subsizes(get_sub_field('image'));
                                $thumb = wp_get_attachment_image(get_sub_field('image'), 'medium', false, ['class' => 'shadow-sm']);
                                $img_src = wp_get_attachment_image_src(get_sub_field('image'), 'full');
                                $i .= '<div class="col-4 mb-3 mb-md-0 text-center">';
                                $i .= '<a href="' . $img_src[0] . '"/>';
                                $i .= $thumb;
                                $i .= '</a></div>';
                            endwhile;
                        endif;

                        $u .= $i;

                        $u .= '</div></div></div></div>';
                    }
            	endwhile;
                echo $u;
            endif; wp_reset_postdata();
            ?>
        </div>
    </div>
</div>