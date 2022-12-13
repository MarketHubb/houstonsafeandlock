<div class="cities-container py-5 my-4">
    <div class="container">
        <div class="row  justify-content-between">
            <div class="col-md-4">
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/houston-location-map.jpg'; ?>" alt="">
            </div>
            <div class="col-md-7">
                <h2>We deliver to more cities than anyone</h2>
                <p class="lead">Up to 100 miles from our location in Houston</p>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="list-group ms-0">
                            <li>Galveston</li>
                            <li>Southside Place</li>
                            <li>Museum District</li>
                            <li>Pasadena</li>
                            <li>Friendswood</li>
                            <li>Fresno</li>
                            <li>League City</li>
                            <li>Deer Park</li>
                            <li>South Houston</li>
                            <li>Clear Lake</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group ms-0">
                            <li>Bellaire</li>
                            <li>West University Place</li>
                            <li>Sugar Land</li>
                            <li>Missouri City</li>
                            <li>Pearland</li>
                            <li>Tomball, Tx</li>
                            <li>Spring, Tx</li>
                            <li>Magnolia, Tx</li>
                            <li>The Woodlands, Tx</li>
                            <li>Hockley, Tx</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group ms-0">
                            <li>Cypress, Tx</li>
                            <li>Houston, Tx</li>
                            <li>Humble, Tx</li>
                            <li>Pinehurst, Tx</li>
                            <li>Jersey Village, Tx</li>
                            <li>Atascosita</li>
                            <li>Conroe, Tx</li>
                            <li>Waller, Tx</li>
                            <li>Klein, Tx</li>
                            <li>Katy, Tx</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

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
