<div class="container modal-callouts mt-2 mt-md-3 mb-3 mb-md-4">
    <div class="row">
        <?php 
        if( have_rows('callouts', 'option') ):
            $callouts = '';
            while ( have_rows('callouts', 'option') ) : the_row();
                $mobile_sub_field = get_sub_field('subheading_mobile', 'option');
                $mobile_head_field = get_sub_field('heading_mobile', 'option');
                $mobile_sub = !empty($mobile_sub_field) ? $mobile_sub_field : get_sub_field('subheading', 'option');
                $mobile_head = !empty($mobile_head_field) ? $mobile_head_field : get_sub_field('heading', 'option');
                $model_clean = !empty(get_model_name_clean(get_the_ID())) ? get_model_name_clean(get_the_ID()) : 'Model';
                $heading = get_sub_field('heading', 'option');
                $heading_model = strpos(get_sub_field('heading', 'option'), 'Model ');

                if ($heading_model !== false && $model_clean) {
                    $heading = str_replace('Model ', $model_clean . ' ', $heading);
                    $mobile_head = str_replace('Model ', $model_clean . ' ', $mobile_head);

                }

                $callouts .= '<div class="col-4 text-center">';
                $callouts .= '<div class="d-flex flex-column flex-md-row justify-content-center align-items-center">';
                $callouts .= '<div class="mb-2 mb-md-0 me-0 me-md-3">';
                $callouts .= '<i class="' . get_sub_field('icon', 'option') . ' fa-lg text-blue mb-2 mb-md-0"></i>';
                $callouts .= '</div><div class="text-md-start">';
                $callouts .= '<p class="mb-0 lh-1 d-block d-md-none"><small class="text-secondary">';
                $callouts .= $mobile_sub . '</small></p>';
                $callouts .= '<p class="mb-0 lh-1 d-none d-md-block"><small class="text-secondary">' . get_sub_field('subheading', 'option') . '</small></p>';
                $callouts .= '<p class="lh-1 mt-1 mb-0 text-body fw-600 d-block d-md-none">' . $mobile_head . '</p>';
                $callouts .= '<p class="lh-1 mt-1 mb-0 text-body fw-600 anti d-none d-md-block">' . $heading . '</p>';
                $callouts .= '</div></div></div>';
            endwhile;
            echo $callouts;
        endif;
        ?>
<!--        <div class="col-4 text-center">-->
<!--            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">-->
<!--                <div class="mb-2 mb-md-0 me-0 me-md-3">-->
<!--                    <i class="fa-solid fa-tags text-blue fa-lg"></i>-->
<!--                </div>-->
<!--                <div class="text-md-start">-->
<!--                    <p class="mb-0 lh-1"><small class="text-secondary">Get Daily</small></p>-->
<!--                    <p class="lh-1 mb-0 text-secondary fw-600">Specials</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-4 text-center">-->
<!--            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">-->
<!--                <div class="me-3">-->
<!--                    <i class="fa-solid fa-vault text-blue fa-lg"></i>-->
<!--                </div>-->
<!--                <div class="text-start">-->
<!--                    <p class="mb-0 lh-1"><small class="text-secondary">Discover Available</small></p>-->
<!--                    <p class="lh-1 mb-0  text-secondary fw-600">Customizations</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-4 text-center">-->
<!--            <div class="d-flex flex-column flex-md-row justify-content-center align-items-center">-->
<!--                <div class="mb-2 mb-md-0 me-0 me-md-3">-->
<!--                    <i class="fa-solid fa-map-pin text-blue fa-lg"></i>-->
<!--                </div>-->
<!--                <div class="text-md-start">-->
<!--                    <p class="mb-0 lh-1"><small class="text-secondary">Review Latest</small></p>-->
<!--                    <p class="lh-1 mb-0 text-secondary fw-600">Delivery Times</p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>

