<div class="differentiators-container bg-grey py-5 my-4">
    <div class="container">
        <div class="row">

            <?php
            if( have_rows('differentiators_single', 'option') ):
                $d = '<div class="d-flex flex-row">';
                while ( have_rows('differentiators_single', 'option') ) : the_row();
                    $d .= '<div class="px-4 text-center">';
                    $d .= '<i class="' . get_sub_field('icon', 'option') . ' fa-xl"></i>';
                    $d .= '<h4 class="mt-3 mb-0">' . get_sub_field('heading', 'option') . '</h4>';
                    $d .= '<p class="lead text-secondary">' . get_sub_field('subheading', 'option') . '</p>';
                    $d .= '<p class="mb-0 lh-sm">' . get_sub_field('description', 'option') . '</p>';
                    $d .= '</div>';
                endwhile;
                $d .= '</div>';
                echo $d;
            endif;
            ?>

        </div>
    </div>
</div>
