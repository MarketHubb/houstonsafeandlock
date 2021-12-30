<div class="container-fluid content-section">
    <div class="wrapper">
        <div class="row justify-content-center">

            <?php
            if( have_rows('panels') ):
                $p = '';
                while ( have_rows('panels') ) : the_row();
                    $p .= '<div class="col-md-4 mb-4 mb-md-3">';
                    $p .= '<div class="card bg-white shadow h-100">';
                    $p .= '<img src="' . get_sub_field('image') . '" alt="">';
                    $p .= '<div class="card-body px-5">';
                    $p .= '<h2 class="fs-2 fw-bold my-4 pb-2 border-bottom d-inline-block text-capitalize">' . get_sub_field('heading') . '</h2>';
                    $p .= '<p class="copy-large">';
                    if (get_sub_field('subheading')) {
                        $p .= '<strong class="mb-4 d-inline-block ">' . get_sub_field('subheading') . '</strong><br>';
                    }
                    $p .= get_sub_field('description');
                    $p .= '</p>';
                    $p .= '</div></div></div>';
                endwhile;
                echo $p;
            endif;
            ?>


        </div>
    </div>
</div>