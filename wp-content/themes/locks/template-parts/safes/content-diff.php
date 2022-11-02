<div class="differentiators-container bg-blue text-white py-5 my-4">
    <div class="container">
        <div class="row">

            <?php
            if( have_rows('differentiators_single', 'option') ):
                $d = '';
//                $d = '<div class="d-flex flex-row">';
                while ( have_rows('differentiators_single', 'option') ) : the_row();
                    $d .= '<div class="col-md-3 px-4 px-5 text-center mb-5 mb-md-0">';
                    $d .= '<i class="' . get_sub_field('icon', 'option') . ' fa-xl"></i>';
                    $d .= '<h4 class="mt-3 mb-2 mb-md-0">' . get_sub_field('heading', 'option') . '</h4>';
                    $d .= '<p class="lead text-white text-uppercase">' . get_sub_field('subheading', 'option') . '</p>';
                    $d .= '<p class="mb-0 lh-sm text-white">' . get_sub_field('description', 'option') . '</p>';
                    $d .= '</div>';
                endwhile;
                $d .= '';
                echo $d;
            endif;
            ?>

        </div>
    </div>
</div>
