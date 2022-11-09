<?php

/* Template Name: Veterans Day Sale  */

get_header();

?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">


            <!-- Hero Banner -->
            <?php
            $hero_args = array('section_classes' => 'mb-0');

            if (get_field('page_include_banner')) {
                if (get_field('page_banner_style') === 'Split') {
                    get_template_part('template-parts/global/content', 'hero-split', $hero_args);
                } else {
                    get_template_part('template-parts/global/content', 'hero', $hero_args);
                }
            }
            ?>

        </main>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-2 text-center">
                <img src="<?php echo get_home_url() . '/wp-content/uploads/2022/11/noun-free-4147206.svg'; ?>" alt="">
            </div>
            <div class="col-md-6">
                <h2>FREE Standard Delivery</h2>
                <p class="lead fw-normal">This week only, get free standard delivery on all new safe purchases. Including our top line 2022 American Security gun safes.</p>
                <ul class="list-group list-group-flush no-borders flush">
                    <li><p class="lead fw-600">BFX Series Gun Safes</p></li>
                    <li><p class="lead fw-600">NF Series Gun Safes</p></li>
                    <li><p class="lead fw-600">SF Series Gun Safes</p></li>
                    <li><p class="lead fw-600">TF Series Gun Safes</p></li>
                    <li><p class="lead fw-600">And much more!</p></li>

                </ul>

            </div>
        </div>
    </div>

    <div class="container-fluid my-5">
        <div class="wrapper">
           <div class="row py-5">

                <div class="col-md-4 ">
                    <div class="card bg-white shadow h-100">
                        <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/10/HSL-Shop-Safes-Row-2.jpg'; ?>" alt="">
                        <div class="card-body px-5">
                            <div class="icon-square flex-shrink-0 mr-3">
                            </div>
                            <div class="">
                                <h2 class="fs-2 my-4 pb-2 border-bottom d-inline-block text-capitalize">Huge Inventory</h2>
                                <p class="copy-large">
                                    <strong class="mb-4 d-inline-block ">Latest AMSEC models including BFX series gun safes</strong><br>
                                    We've over-stocked our showroom with <strong>hundreds of the latest models</strong> of gun, home/office, floor  and other high-security and fire-rated safes from American Security.
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

               <div class="col-md-4 ">
                    <div class="card bg-white shadow h-100">
                        <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/11/Logo-AMSEC.jpg'; ?>" alt="">
                        <div class="card-body px-5">
                            <div class="icon-square flex-shrink-0 mr-3">
                            </div>
                            <div class="">
                                <h2 class="fs-2  text-capitalize my-4 pb-2 border-bottom d-inline-block">AMSEC On-Site</h2>
                                <p class="copy-large">
                                    <strong class="mb-4 d-inline-block ">Chat directly with an AMSEC rep at our showroom</strong><br>
                                    Not sure what safe you need? Choosing between models? First time buyer? The safe experts at American Security will be
                                    <strong>on our showroom floor</strong> during the sale to help.

                                </p>

                            </div>
                        </div>
                    </div>
                </div>
<div class="col-md-4 ">
                    <div class="card bg-white shadow h-100">
                        <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/11/Safe-Interior.jpg'; ?>" alt="">
                        <div class="card-body px-5">
                            <div class="icon-square flex-shrink-0 mr-3">
                            </div>
                            <div class="">
                                <h2 class="fs-2 text-capitalize my-4 pb-2 border-bottom d-inline-block">Free Standard Shipping</h2>
                                <p class="copy-large">
                                    <strong class="mb-4 d-inline-block ">Buy a safe during the sale and we'll deliver it for FREE</strong><br>
                                    All safes purchased during our annual Veterans Day sale will come <strong>with
                                        standard delivery completely free</strong> of charge regardless of exterior dimensions or weight.

                                </p>

                            </div>
                        </div>
                    </div>
                </div>

           </div>
        </div>
    </div>


<?php get_footer(); ?>