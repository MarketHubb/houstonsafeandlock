<?php $banner_image = get_home_url() . '/wp-content/uploads/2023/06/Banner-Popup-1.png'; ?>

<header
        class="max-height-50 mh-50 shadow-sm"
        style="background-image: url(<?php echo $banner_image; ?>); background-position: center; background-size: cover">
</header>

<div class="promotion-cards">

<section class="my-5">
    <div class="container">

        <div class="row justify-content-center my-5 pt-4">
            <div class="col-md-8 text-center">
                <h2 class="fs-1 text-blue">Our biggest safe sale, ever</h2>
                <p class="lead">From now until July 8th, order any new safe and get<br>
                    <strong>An additional 10% off our lowest marked price + Free shipping + Free installation</strong>
                </p>
                <a href="<?php echo get_permalink(3901); ?>" type="button" class="btn btn-primary bg-orange fw-600  text-white shadow-sm font-lg font-source">Shop Safes</a>
            </div>
        </div>

    <?php
    if( have_rows('cards') ):
        $card = '<div class="row">';
        while ( have_rows('cards') ) : the_row();
            $card .= '<div class="col-md-4">';
            $card .= '<div class="card h-100 shadow-sm">';
            $card .= '<img src="' . get_sub_field('image')['url'] . '" class="card-img-top" alt="...">';
            $card .= '<div class="card-body p-4">';
            $card .= '<h3 class="card-title">' . get_sub_field('heading') . '</h3>';
            $card .= '<p class="card-text">' . get_sub_field('description') . '</p>';
            $card .= '</div></div></div>';
        endwhile;
        echo $card;
    endif;
    ?>

    </div>
</section>

<section class="my-5 pt-4">
    <div class="container">

        <div class="row justify-content-center my-5">
            <div class="col-md-8 text-center">
                <h2 class="fs-1 text-blue">Save on Brivo Access Control</h2>
                <p class="lead">From now until July 8th, order any new safe and get<br>
                    <strong>From now until July 8th, save on Brivo - the best in access control systems.</strong>
                </p>
                <a href="<?php echo get_permalink(7728); ?>" type="button" class="btn btn-primary bg-orange fw-600  text-white shadow-sm font-lg font-source ">Shop Access Control</a>
            </div>
        </div>

    <?php
    if( have_rows('cards_2') ):
        $card = '<div class="row">';
        while ( have_rows('cards_2') ) : the_row();
            $card .= '<div class="col-md-4">';
            $card .= '<div class="card h-100 shadow-sm">';
            $card .= '<img src="' . get_sub_field('image')['url'] . '" class="card-img-top" alt="...">';
            $card .= '<div class="card-body bg-grey-light p-4">';
            $card .= '<h3 class="card-title">' . get_sub_field('heading') . '</h3>';
            $card .= '<p class="card-text">' . get_sub_field('description') . '</p>';
            $card .= '</div></div></div>';
        endwhile;
        echo $card;
    endif;
    ?>

    </div>
</section>

    <section class="my-5 py-4">
        <div class="container">

            <div class="row justify-content-center my-5">
                <div class="col-md-8 text-center">
                    <h2 class="fs-1 text-blue">One company, two locations</h2>
                    <p class="lead">We're one company, with two locations to better serve the safe and security needs of our valued Houston customers.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card h-100 shadow-sm"><img src="<?php echo home_url() . '/wp-content/uploads/2023/06/HSL-Storefront.jpg'; ?>" class="card-img-top" alt="...">
                        <div class="card-body bg-grey-light p-4"><h3 class="card-title">Houston Safe & Lock</h3>
                            <p class="card-text">
                                <strong> <a href="tel:713-522-5555">713-522-5555</a></strong><br>
                                10210 Westheimer Rd.<br>
                                Houston, Texas - 77042<br>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card h-100 shadow-sm"><img src="<?php echo home_url() . '/wp-content/uploads/2023/06/KSL-Showroom-4.jpg'; ?>" class="card-img-top" alt="...">
                        <div class="card-body bg-grey-light p-4"><h3 class="card-title">King Safe & Lock</h3>
                            <p class="card-text">
                                <strong> <a href="tel:713-465-0055">713-465-0055</a></strong><br>
                                8429 Katy Fwy<br>
                                Houston, Texas 77024<br>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div></section>

</div>