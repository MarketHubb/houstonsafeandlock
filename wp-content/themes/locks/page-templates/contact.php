<?php /* Template Name: Contact */

get_header(); ?>

<?php get_template_part('template-parts/global/content', 'hero-simple'); ?>

<div class="container-fluid px-4 py-5" id="hanging-icons">
    <div class="wrapper">
        <div class="row g-4 py-5 row">

            <div class="col-md-4 ">
                <div class="card bg-white shadow h-100">
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/10/HSL-Shop-Keys.jpg'; ?>" alt="">
                    <div class="card-body px-5">
                        <div class="icon-square  text-dark flex-shrink-0 mr-3">
                            <i class="fas fa-map-pin text-orange"></i>
                        </div>
                        <div class="">
                            <h2 class="mb-4 pb-2 border-bottom d-inline-block">Address</h2>
                            <div itemscope itemtype="http://schema.org/LocalBusiness">
                                <div class="schema" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <span itemprop="streetAddress">10218 F, Westheimer Rd.</span><br>
                                    <span itemprop="addressLocality">Houston</span>,
                                    <span itemprop="addressRegion">Texas</span> -
                                    <span itemprop="postalCode">77042</span><br>
                                </div>
                            </div>

                            <p class="copy-large mb-2 mt-4 pt-2">
                                <em>From W. Sam Houston:</em></p>
                            <ul class="bullets-large">
                                <li>Take  Westheimer exit</li>
                                <li>Head Eastbound</li>
                                <li>Make U-Turn at Seagler Rd.</li>
                                <li>Turn immediately into the convenient center</li>
                            </ul>

<!--                            <a class="get-directions open-modal"-->
<!--                               href="https://www.google.com/maps/place/Houston+Safe+and+Lock/@29.7374624,-95.5541948,15z/data=!4m5!3m4!1s0x0:0xbe498a15d66fc53c!8m2!3d29.7374624!4d-95.5541948"-->
<!--                               target="_blank">Google Maps Directions</a>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="card bg-white shadow h-100">
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/10/HSL-Shop-Safes-Row-2.jpg'; ?>" alt="">
                    <div class="card-body px-5">
                        <div class="icon-square flex-shrink-0 mr-3">
                            <i class="fas fa-phone text-orange"></i>
                        </div>
                        <div class="">
                            <h2 class="mb-4 pb-2 border-bottom d-inline-block">Contact</h2>
                            <p class="copy-large">
                                <strong class="mb-2 d-inline-block ">Call:</strong><br>
                                <a href="tel:713-820-6934">713-820-6934</a>
                            </p>
                            <p class="copy-large">
                                <strong class="mb-2 d-inline-block ">Email:</strong><br>
                                <a href="mailto:">info@houstonsafeandlock.com</a>
                            </p>
                            <p class="copy-large">
                                <strong class="mb-2 d-inline-block ">Fax:</strong><br>
                                <a href="tel:713-975-7534">713-975-7534</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-white shadow h-100">
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/10/HSL-Shop-Locks.jpg'; ?>" alt="">
                    <div class="card-body px-5">
                        <div class="icon-square flex-shrink-0 mr-3">
                            <i class="fas fa-clock text-orange"></i>
                        </div>
                        <div class="">
                            <h2 class="mb-4 pb-2 border-bottom d-inline-block">Store Hours</h2>
                            <p class="copy-large">
                                <strong class="mb-2 d-block">Monday-Friday</strong>
                                8:00am - 5:00pm
                            </p>
                            <p class="copy-large">
                                <strong class="mb-2 d-block">Saturday</strong>
                                9:00am - 4:00pm
                            </p>
                            <p class="copy-large">
                                <strong class="mb-2 d-block">Sunday</strong>
                                Closed
                        </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="gmap">

    <?php echo get_field( 'map_box' ); ?>

</div>


<?php get_footer(); ?>
