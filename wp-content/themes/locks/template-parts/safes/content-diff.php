
<div class="differentiators-container py-5 my-4">
    <div class="container">
        <div class="row">

            <?php
            if( have_rows('differentiators_single', 'option') ):
                $d = '';
//                $d = '<div class="d-flex flex-row">';
                while ( have_rows('differentiators_single', 'option') ) : the_row();
                    $d .= '<div class="col-md-3 px-4 px-5 text-center mb-5 mb-md-0">';
                    $d .= '<i class="' . get_sub_field('icon', 'option') . ' fa-xl text-orange"></i>';
                    $d .= '<h3 class="mt-3 mb-2 mb-md-0 text-capitalize text-blue">' . get_sub_field('heading', 'option') . '</h3>';
                    $d .= '<p class="lead  text-uppercase">' . get_sub_field('subheading', 'option') . '</p>';
                    $d .= '<p class="mb-0 lh-sm ">' . get_sub_field('description', 'option') . '</p>';
                    $d .= '</div>';
                endwhile;
                $d .= '';
                echo $d;
            endif;
            ?>

        </div>
    </div>
</div>
