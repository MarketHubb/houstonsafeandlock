<div class="bg-gold-light mb-5">

    <div class="container-fluid content-section">
        <div class="wrapper">

            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="font-weight-bold">Featured Safes of the Week</h2>
                </div>
            </div>

            <div class="content-section">
                <div class="row">

                    <?php
                    $safes_array = [2306, 2295, 2176];
                    $featured = '';
                    $i = 1;

                    foreach ($safes_array as $safe) {

                        if ($i === 1 ) {
                            $type = "Gun Safe";
                        } elseif ($i === 2) {
                            $type = "Jewelry Safe";
                        } elseif ($i === 3) {
                            $type = "Commercial Safe";
                        }


                        $featured .= '<div class="col-md-4">';
                        $featured .= '<div class="card py-4 text-center rounded shadow">';
                        $featured .= '<h2 class="mb-0">' . get_the_title($safe) . '</h2>';
                        $featured .= '<span class="gold">' . $type . '</span>';
                        $featured .= '<p class="mt-3">' . get_field('post_product_gun_model_description', $safe) . '</p>';
                        $featured .= '<img src="' . get_the_post_thumbnail_url($safe) . '"/>';
                        $featured .= '<a href="' . get_permalink($safe) . '" class="stretched-link"></a>';
                        $featured .= '</div></div>';

                        $i ++;

                    }


                    echo $featured;
                    ?>

                </div>
            </div>

        </div>
    </div>

</div>