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
                <div class="col-md-7 pt-5">
                    <h1 class="display-3 mb-3 mt-3 text-blue hero-headline">Houston Safe & Lock</h1>
                    <p class="lead text-blue hero-subheadline">Houston's largest selection of high security safes + 24/7 emergency locksmiths that are licensed, bonded and insured</p>
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