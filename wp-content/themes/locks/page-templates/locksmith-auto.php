<?php /* Template Name: Auto Locksmith */
get_header(); ?>

<div class="custom-template">

    <?php
    // Banner
    $hero_args = array('section_classes' => 'mb-0');

    if (get_field('page_include_banner')) {
        if (get_field('page_banner_style') === 'Split') {
            get_template_part('template-parts/global/content', 'hero-split', $hero_args);
        } else {
            get_template_part('template-parts/global/content', 'hero', $hero_args);
        }
    }
    ?>

    <!-- Content -->

    <div class="container-fluid content-section" id="locksmith-page">
        <div class="wrapper">

            <!-- Intro-->
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="font-weight-bolder">Houston's Trusted Locksmiths Since 1923</h2>
                    <p class="lead">Houston Safe and Lock offers complete locksmith services, including lock repair and lock replacement options.  Our 24-Hour Emergency Locksmith Services are standing by ready to assist you.  Whether you need a residential lock repaired or replaced, a commercial access control service, or a master key for your business, our licensed, bonded, and insured Houston locksmith professionals are ready to help you.</p>
                </div>

                <?php
                if( have_rows('accreditations', 'option') ):
                    $c = '';
                    while ( have_rows('accreditations', 'option') ) : the_row();
                        $c .= '<div class="col-md-4 text-center">';
                        $c .= '<img src="' . get_sub_field('accreditation_logo', 'option') . '" class="accreditation-img"/>';
                        $c .= '<p class="lead font-weight-bold">' . get_sub_field('accreditation_name', 'option') . '</p>';
                        $c .= '</div>';
                    endwhile;
                    echo $c;
                endif;

                ?>

            </div>

            <!-- Services (Auto) -->
            <div class="row align-items-center">
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <h2>Houston's Auto Locksmiths</h2>
                    <p class="lead">Our dedicated team of expert automobile locksmith is available 24/7 and can make keys on-site so you never need a tow.</p>
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/02/auto-locksmith-sized.jpg' ?>" alt="">
                </div>
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <ul class="list-group list-group-flush ml-0">
                        <li class="list-group-item lead font-weight-bold">24/7 automobile locksmith services</li>
                        <li class="list-group-item lead font-weight-bold">On-site key and fob duplication (Don't pay to be towed!)</li>
                        <li class="list-group-item lead font-weight-bold">Unlock car to gain access to working keys locked in car</li>
                        <li class="list-group-item lead font-weight-bold">New car keys in case of loss or damage to key</li>
                        <li class="list-group-item lead font-weight-bold">Broken key removal from lock or ignition</li>
                    </ul>
                </div>
            </div>

            <!-- Services (General) -->
            <div class="row align-items-center">
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5 order-md-last">
                    <h2>Our Locksmith Services</h2>
                    <p class="lead">Houston Safe and Lock is Houston's trusted provider for all of your auto, residential and commercial locksmith needs.</p>
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/02/locksmith.jpg' ?>" alt="">
                </div>
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <ul class="list-group list-group-flush ml-0">
                        <li class="list-group-item lead font-weight-bold">Commercial & Residential Lockouts</li>
                        <li class="list-group-item lead font-weight-bold">Repair, Replace, & Install New Locks</li>
                        <li class="list-group-item lead font-weight-bold">Repair, Replace, & Install New Deadbolts</li>
                        <li class="list-group-item lead font-weight-bold">Re-keying</li>
                        <li class="list-group-item lead font-weight-bold">Duplicate Key Cutting</li>
                        <li class="list-group-item lead font-weight-bold">Panic Devices</li>
                        <li class="list-group-item lead font-weight-bold">Access Control Systems</li>
                        <li class="list-group-item lead font-weight-bold">Key Control Devices</li>
                    </ul>
                </div>
            </div>

            <!-- Services (Rekeying) -->
            <div class="row align-items-center">
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <h2>Rekeying</h2>
                    <p class="lead">We offer rekeying as a locksmith service which is important for several reasons:</p>
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/02/Rekey-2.jpg' ?>" alt="">
                </div>
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <ul class="list-group list-group-flush ml-0">
                        <li class="list-group-item lead font-weight-bold">If you have lost your house keys.</li>
                        <li class="list-group-item lead font-weight-bold">If your car keys have gone missing.</li>
                        <li class="list-group-item lead font-weight-bold">You are worried about a former employee.</li>
                        <li class="list-group-item lead font-weight-bold">You have moved into a new home or apartment.</li>
                        <li class="list-group-item lead font-weight-bold">You have had a personal breakup.</li>
                    </ul>
                </div>
            </div>

            <!-- Services (High Security Locks) -->
            <div class="row align-items-center">
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5 order-md-last">
                    <h2>High Security Lock Installation</h2>
                    <p class="lead">Key duplication and lock bumping can give unwanted people access to your home. Protect yourself with high-security locks.</p>
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2021/02/High-Security-copy.jpg' ?>" alt="">

                </div>
                <div class="col-md-6 h-100 px-sm-2 px-md-4 px-lg-5">
                    <ul class="list-group list-group-flush ml-0">
                        <li class="list-group-item lead font-weight-bold">Proudly carry top brands: Medeco, Mul-T-Lock and Tuff Strike </li>
                        <li class="list-group-item lead font-weight-bold">Pick proof, drill proof & bump proof</li>
                        <li class="list-group-item lead font-weight-bold">Key control and access systems for business</li>
                        <li class="list-group-item lead font-weight-bold">Used by the Houston Police Dept and Fortune 500 Companies</li>
                        <li class="list-group-item lead font-weight-bold">Professionally installed by our licensed locksmiths</li>
                    </ul>
                </div>
            </div>


        </div>
    </div>

<!-- Testimonials -->
<?php get_template_part('template-parts/global/content', 'testimonials'); ?>

</div>

<?php get_footer(); ?>
