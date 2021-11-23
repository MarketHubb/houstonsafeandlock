<?php
    $image = get_home_url() . '/wp-content/uploads/2021/08/HSL-Banner-Main.jpg';
    $bg_opacity = $hero['page_banner_image_opacity'] > 0 ? $hero['page_banner_image_opacity'] : .01;
    $linear_gradient = 'linear-gradient(to bottom, rgba(0,0,0,' .  $bg_opacity . ') 0%,rgba(0,0,0,' . $bg_opacity . ') 100%)';
    $text_align_class = $hero['page_banner_text_align'] = 'center' ? 'text-center' : '';

    ?>

    <div id="hero-banner" class="jumbotron bg-cover text-white px-sm-2"
         style="background-image: <?php echo $linear_gradient; ?>,
                 url(<?php echo $image; ?>)">

        <div class="container-fluid  py-3">
            <div class="wrapper">
<!--                <div class="col-md-8  bg-white  px-5 pt-5 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded border shadow-lg">-->
<!--                    <span class="gold">Visit Our 5,000 sq ft showroom</span>-->
<!--                    <h1 class=" mb-3 mt-0 text-blue hero-headline text-uppercase">Houston Safe & Lock</h1>-->
<!--                    <p class="lead  hero-subheadline">The largest safe showroom in Houston with hundreds of high security safes + 24x7 licensed and  bonded emergency locksmiths</p>-->
<!--                </div>-->
                <div class="col-md-8  bg-white mb-5  px-5 pt-5 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded border shadow-lg">
                    <span class="gold">Visit our 5,000 Sq. Ft. Showroom Today</span>
                    <h1 class=" mb-3 mt-0 text-blue hero-headline text-uppercase">Houston Safe & Lock</h1>
                    <p class="lead  hero-subheadline mb-2"><strong>10218 F Westheimer Rd,  Houston, TX 77042</strong></p>
                    <p class="lead lead-small hero-subheadline">Houston's largest safe showroom with hundreds of American Security, Jewel and Original safes in stock. On-site 24/7 emergency locksmiths and dedicated safe moving specialists.</p>

                    <p class="lead lead-small">
                        <a href="<?php echo get_permalink(6158); ?>" class="btn btn-primary btn-lg text-white px-4 bg-orange no-borders lead">
                            Black Friday Sales Event
                            <i class="fas fa-long-arrow-right ml-1"></i>
                        </a>
                    </p>
                </div>
                <div class="row">
                </div>
            </div>
        </div>
    </div>




<!--<div id="home-hero" class="skew-bottom"-->
<!--     style="background-image: --><?php //echo $linear_gradient; ?><!--,-->
<!--             url(--><?php //echo $image; ?><!--)">-->
<!--    <div class="text-center h-100 align-items-center flex-row">-->
<!--        <h1 class="font-weight-bold display-1 text-white">Houston Safe & Lock</h1>-->
<!--        <div class="row justify-content-center">-->
<!--            <div class="col-md-8 text-center">-->
<!--                <ul class="list-group list-group-horizontal transparent no-borders">-->
<!--                    <li class="list-group-item flex-fill transparent no-borders">-->
<!--                        <i class="fal fa-door-closed fa-2x text-white"></i>-->
<!--                        <h3 class="text-white font-weight-bold">High Security Safes</h3>-->
<!--                    </li>-->
<!--                    <li class="list-group-item flex-fill transparent no-borders">-->
<!--                        <i class="fal fa-key fa-2x text-white"></i>-->
<!--                        <h3 class="text-white font-weight-bold">24/7 Emergency Locksmiths</h3>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->