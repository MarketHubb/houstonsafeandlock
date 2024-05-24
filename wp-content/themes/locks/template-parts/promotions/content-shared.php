<?php $banner_image = get_field('hero_image')['url']; ?>

<header class="max-height-50 mh-50 tw-py-12" style="background-image: url(<?php echo $banner_image; ?>); background-position: center; background-size: contain; background-repeat: no-repeat;">
</header>

<div class="promotion-cards">

    <section class="tw-py-24">
        <div class="container">

            <div class="row justify-content-center pt-4 pb-5">
                <div class="col-md-8 col-lg-6 text-center">
                    <h2 class="mb-4">
                        <span class="text-blue anit d-md-block mb-1">Home, Office & Gun Safes</span>
                        <span class="fw-normal">At our lowest prices of the year</span>
                    </h2>
                    <p class="lead fw-normal mb-5">From now until <strong>May 31st</strong>, order any new safe and get an additional 15% off our lowest marked price + Free shipping + Free installation
                    </p>
                    <div class="my-3">
                        <a href="<?php echo get_permalink(3901); ?>" type="button" class="btn tw-text-white btn-primary bg-orange fw-600  text-white shadow-sm font-lg font-source">Shop Our Safes</a>
                    </div>
                </div>
            </div>

            <?php
            if (have_rows('cards')) :
                $card = '<div class="row">';
                while (have_rows('cards')) : the_row();
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

    <section class="py-5 bg-grey">
        <div class="container">

            <div class="row justify-content-center pt-4 pb-5">
                <div class="col-md-8 col-lg-6 text-center">
                    <h2 class="mb-4">
                        <span class="text-blue anit d-md-block mb-1">Access Control Systems</span>
                        <span class="fw-normal">Save on cameras, alarm and more</span>
                    </h2>

                    <p class="lead mb-5"><strong>From security cameras, to alarm systems we have the best security equipment and expert installers.</strong></p>
                    </p>
                    <div class="my-3">
                        <a href="<?php echo get_permalink(7728); ?>" type="button" class="btn tw-text-white btn-primary bg-orange fw-600  text-white shadow-sm font-lg font-source ">Shop Access Control</a>
                    </div>
                </div>
            </div>

            <?php
            if (have_rows('cards_2')) :
                $card = '<div class="row">';
                while (have_rows('cards_2')) : the_row();
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

    <section class="tw-py-24">
        <div class="container">

            <div class="row justify-content-center pt-4 pb-5">
                <div class="col-md-8 text-center">
                    <h2 class="">One company, two locations</h2>
                    <p class="lead">We're one company, with two locations to better serve the safe and security needs of our valued Houston customers.
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card h-100 shadow-sm"><img src="<?php echo home_url() . '/wp-content/uploads/2023/06/HSL-Storefront.jpg'; ?>" class="card-img-top" alt="...">
                        <div class="card-body bg-grey-light p-4">
                            <h3 class="card-title">Houston Safe & Lock - Westheimer</h3>
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
                        <div class="card-body bg-grey-light p-4">
                            <h3 class="card-title">Houston Safe & Lock - Memorial</h3>
                            <p class="card-text">
                                <strong> <a href="tel:713-465-0055">713-465-0055</a></strong><br>
                                8429 Katy Fwy<br>
                                Houston, Texas 77024<br>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>