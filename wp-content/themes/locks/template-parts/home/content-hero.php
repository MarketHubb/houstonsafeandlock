<?php
    $image = get_field('home_background_image', $post->ID);
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
                <div class="col-md-8 banner-text-container bg-white my-5 px-4 px-md-5 py-4 pt-lg-5 align-items-center rounded  shadow-lg">
                    <span class="d-inline-block gold mb-0 pb-1 pb-md-2"><?php the_field('home_subheading'); ?></span>
                    <h1 class="mb-3  mt-0 text-blue hero-headline text-uppercase"><?php the_field('home_heading'); ?></h1>
                    <p class="d-none d-md-block hero-subheadline mb-2 promotion"><strong><?php the_field('home_callout'); ?></strong></p>
                    <p class="lead description"><?php the_field('home_banner_description'); ?></p>

                    <?php
                    if( have_rows('home_banner_links') ):
                        $l = '<ul class="list-group list-group-horizontal-lg flush ms-0 d-flex align-items-center py-3">';
                        while ( have_rows('home_banner_links') ) : the_row();
                            $l .= '<li class="list-group-item no-border py-2 py-lg-1 ps-0 px-lg-5">';
                            $l .= '<a href="' . get_sub_field('page') . '" class="fw-bold fs-5">';
                            $l .= get_sub_field('link_text') . '<i class="fas fa-long-arrow-right ms-2"></i></a></li>';
                        endwhile;
                        echo $l;
                    endif;
                    ?>

                    <p class="lead lead-small">
                        <?php if (get_field('home_button_text') && get_field('home_button_link')) { ?>
<!--                            <a href="--><?php //echo get_field('home_button_link') ?><!--" class="btn btn-primary btn-lg text-white px-4 bg-orange no-borders lead">-->
<!--                                --><?php //the_field('home_button_text'); ?>
<!--                                <i class="fas fa-long-arrow-right ms-1"></i>-->
<!--                            </a>-->
                        <?php } ?>
                    </p>
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