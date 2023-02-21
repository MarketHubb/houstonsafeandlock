<header id="masthead" class="site-header" role="banner">
    <div id="pre-nav" class="">
        <div class="container-fixed py-2">

<!--            <p class="mb-0 pb-0 d-inline">-->
<!--                <img id="auto-key-icon" src="--><?php //echo home_url() . '/wp-content/uploads/2022/08/Car-Key.svg' ?><!--" alt="">-->
<!--                <a class="mb-0 pb-0 text-white" href="https://www.autofobs.com/?ref=44&locid=18451">Auto Remotes</a>-->
<!--            </p>-->

            <?php if (!get_field('active', 'options')) { ?>

                <!-- Scroll logo (Text image) -->
                <div id="left-content">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo-header-collapsed.png" alt="Houston Safe And Lock">
                    </a>
                </div>
                <!-- CURRENT:: Pre Nav (social icons) -->
                <div id="right-content">
                    <?php get_search_form(); ?>
                </div>

            <?php } else { ?>

                <p class="px-4 text-center font-weight-bold mb-0 pb-0 lh-sm">
                    <a href="<?php echo get_field('alert_link', 'options'); ?>" class="text-white lh-sm">
                        <?php echo get_field('alert_message', 'options'); ?>
                        <i class="fas fa-long-arrow-right ml-1"></i>
                    </a>
                </p>


            <?php } ?>
        </div>

        <!-- CURRENT:: Fixed header (when scrolling) -->
        <div class="scrolling-brand-phone">
            <div class="brand-phone">
                <h3>Call Now</h3>
                <p><a href="tel:713-522-5555">713-522-5555</a></p>
            </div>
        </div>

    </div>

    <!-- CURRENT:: Logo & Phone (pre scroll) -->
    <div id="brand-info">
        <div class="container-fixed">
            <div id="brand-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/header/locks-logo.png" alt="Houston Safe And Lock Logo" />
                </a>
            </div>

            <div id="brand-phone">

                <!-- CURRENT:: Global Call CTA ( pre scroll)  -->
                <h3>Call Now</h3>
                <p><a class="text-orange" href="tel:713-522-5555">713-522-5555</a></p>

            </div>

            <div id="menu-responsive">
                <button id="menu-responsive-trigger">
                    <span class="closed-menu-text is-active">MENU</span>
                    <span class="opened-menu-text">CLOSE</span>
                    <div class="responsive-menu-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div id="menu-responsive-container">
                    <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu', 'before' => '<div class="arrow"></div>' ) ); ?>

                    <div class="menu-responsive-bottom-container">
                        <div class="lock-separator-container">
                            <hr class="separator">
                            <span class="lock">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header/key-icon.png" alt="key icon">
                            </span>
                            <hr class="separator">
                        </div>
                        <div class="menu-responsive-icons-container">
                            <a href="<?php the_field( 'facebook_url' );  ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header/fb-icon-responsive.png" alt="facebook icon">
                            </a>
                            <a href="<?php the_field( 'twitter_url' ); ?>">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/header/twitter-icon-responsive.png" alt="twitter icon">
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <nav id="site-navigation" class="main-navigation" role="navigation">
        <div class="container-fixed">
            <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
        </div>
    </nav>
</header><!-- #masthead -->