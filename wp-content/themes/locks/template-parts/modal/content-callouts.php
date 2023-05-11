<?php
$prefix = $args['prefix'];
$field = $prefix . 'callouts';
?>
<div class="container modal-callouts mt-3 mt-md-4 mb-4">
    <div class="row">
        <?php
        if( have_rows($field, 'option') ):
            $callouts = '';
            while ( have_rows($field, 'option') ) : the_row();
                $mobile_sub_field = get_sub_field($prefix . 'subheading_mobile', 'option');
                $mobile_head_field = get_sub_field($prefix . 'heading_mobile', 'option');
                $mobile_sub = !empty($mobile_sub_field) ? $mobile_sub_field : get_sub_field($prefix . 'subheading', 'option');
                $mobile_head = !empty($mobile_head_field) ? $mobile_head_field : get_sub_field($prefix . 'heading', 'option');

                if ($prefix !== 'locksmith_') {
                    $model_clean = !empty(get_model_name_clean(get_the_ID())) ? get_model_name_clean(get_the_ID()) : 'Model';
                    $heading = get_sub_field('heading', 'option');
                    $heading_model = strpos(get_sub_field('heading', 'option'), 'Model ');

                    if ($heading_model !== false && $model_clean) {
                        $heading = str_replace('Model ', $model_clean . ' ', $heading);
                        $mobile_head = str_replace('Model ', $model_clean . ' ', $mobile_head);

                    }

                } else {
                    $heading = get_sub_field($prefix . 'heading', 'option');
                }

                $callouts .= '<div class="col-4 text-center">';
                $callouts .= '<div class="d-flex flex-column flex-md-row justify-content-center align-items-center">';
                $callouts .= '<div class="mb-2 mb-md-0 me-0 me-md-3">';
                $callouts .= '<i class="' . get_sub_field($prefix . 'icon', 'option') . ' fa-lg text-blue mb-2 mb-md-0"></i>';
                $callouts .= '</div><div class="text-md-start">';
                $callouts .= '<p class="mb-0 lh-1 d-block d-md-none"><small class="text-secondary fw-light">';
                $callouts .= $mobile_sub . '</small></p>';
                $callouts .= '<p class="mb-0 lh-1 d-none d-md-block"><small class="text-secondary fw-light">' . get_sub_field($prefix . 'subheading', 'option') . '</small></p>';
                $callouts .= '<p class="lh-1  mb-0 text-body fw-600 d-block d-md-none">' . $mobile_head . '</p>';
                $callouts .= '<p class="lh-1 mb-0 text-body d-none d-md-block"><small class="text-uppercase">' . $heading . '</small></p>';
                $callouts .= '</div></div></div>';
            endwhile;
            echo $callouts;
        endif;
        ?>
    </div>
</div>


