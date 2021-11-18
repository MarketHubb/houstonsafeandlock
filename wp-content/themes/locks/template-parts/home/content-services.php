<div class="container-fluid content-section mb-5 pb-5">
    <div class="wrapper">
        <div class="content-section">
            <div class="row">

                <?php
                if( have_rows('services') ):
                    $s = '';
                    while ( have_rows('services') ) : the_row();
                        $s .= '<div class="col-md-4">';
                        $s .= '<div class="card h-100 shadow">';
                        $s .= '<img src="' . get_sub_field('image') . '" class="card-img-top" />';
                        $s .= '<div class="card-body d-flex flex-column px-3 px-md-4 px-lg-5 pt-5">';
                        $s .= '<h4 class="card-title font-weight-bolder">' . get_sub_field('heading') . '</h4>';
                        $s .= '<p class="card-text">' . get_sub_field('description') . '</p>';
                        $s .= '<div class="mt-auto">';
                        $s .= '<a href="' . get_sub_field('link') . '" class="btn-link mt-auto">';
                        $s .= get_sub_field('link_text') . '<i class="fas fa-arrow-right ml-3"></i></a>';
                        $s .= '<p class="font-italic mb-0 text-secondary mt-2">' . get_sub_field('link_sub') . '</p>';
                        $s .= '</div></div></div></div>';
                    endwhile;
                    echo $s;
                endif;
                ?>
            </div>
        </div>

    </div>
</div>
