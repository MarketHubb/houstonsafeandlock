<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package locks
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $bool_title=0;
    if(get_query_var( 'name' )=='blog' && get_query_var('page')=="")
    {
        $bool_title=1;
        $p_title='Blog';
    }
    else if(get_query_var('bname') && get_query_var('blog_id_1'))

//else if(get_query_var( 'name' )=='blogdetail')
    {
        $bool_title=1;
        $p_title='Blog';
    }
    else if(get_query_var('name')=='blog' && get_query_var('page'))
    {
        $bool_title=1;
        $p_title='Blog';
    }
    ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php
    if($bool_title==0){
        wp_head();
    }
    elseif($bool_title==1){

        ?>
        <title><?php echo $p_title; ?> - <?php echo get_bloginfo( 'name' ); ?></title>
        <?php wp_head();
    }
    ?>

    <!-- Start HSL Google Analytics -->
    <script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-78250454-1', 'auto');  ga('send', 'pageview');</script>
    <!-- End HSL Google Analytics -->

<!--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"-->
<!--          rel="stylesheet">-->

    <script type="text/javascript">
        (function($) {
            $.noConflict();
            $( document ).ready(function() {
                //Var Declaration
                var header = $('header.site-header'),
                    pageContainer = $('#primary'),
                    menuTrigger = $('button#menu-responsive-trigger'),
                    menuContainer = $('div#menu-responsive-container');

                //Set Nav Search Trigger
                setSearchTrigger($);
                //Is User Scrolling
                isUserScrolling($, header, pageContainer);
                //Responsive Menu
                responsiveMenu(menuTrigger, menuContainer);
                //Smooth Scroll
                smoothScrolling($);

                var mobilesearch = '<li id="mobile-search"></li>';

                $('#primary-menu').append(mobilesearch);

                var Sform='<form id="searchform" method="get" action="<?php bloginfo('url'); ?>/"><label for="s" class="search-field-row"><input type="text" class="search-field" placeholder="SEARCH" name="s" id="s" size="25" /><button id="searchsubmit" href="javascript:void(0)"><div id="searchIcon" class="search-icon"></div></button></label></form>';
                // Mobile dropdown navigation
                showSubMenu($);
                var default_city = $('.city-select').find('option:selected').val();
                showCityCrimeData($, default_city)
                $('.city-select').on('change', function() {
                    showCityCrimeData($, $(this).find('option:selected').val());
                });
                //Back to the top fuction
                backToTop($)
            });
        })(jQuery);
    </script>

</head>
<body <?php body_class(); ?>>
<?php $body_class =  sanitize_post ( get_queried_object() )->post_name ?: ''; ?>
<div id="page" class="site <?php echo $body_class; ?>">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'locks' ); ?></a>
    <header id="masthead" class="site-header" role="banner">

        <!-- LEGACY:: Gun Safes (Alert Bar) -->
        <?php //if (is_page(3857) || is_singular('product')) { ?>
            <!-- Section: Alert Bar -->
<!--            <div class="alert alert-primary text-center" role="alert">-->
<!--                <span class="safe-alert-message d-none d-lg-block">--><?php //echo get_field('field_5dea85d0f82c7', 'option'); ?><!--</span>-->
<!--                <span class="safe-alert-message d-lg-none">--><?php //echo get_field('field_5defc058afe02', 'option'); ?><!--</span>-->
<!--            </div>-->
        <?php //} ?>



        <div id="pre-nav" class="">
            <div class="container-fixed py-2">
                
                <p class="mb-0 pb-0 d-inline">
                    <img id="auto-key-icon" src="<?php echo home_url() . '/wp-content/uploads/2022/08/Car-Key.svg' ?>" alt="">
                    <a class="mb-0 pb-0 text-white text-decoration-underline" href="https://www.autofobs.com/?ref=44&locid=18451">Auto Remotes</a>
                </p>
                
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

                    <!-- LEGACY:: Gun Safes & Gun Single (Phone Lead)  -->
                    <?php //if ( is_page(3857) || is_singular('product') ) { ?>
                    <!-- <h3>Call for Safe Pricing</h3>-->
                    <?php //} else { ?>
                    <!-- <h3>Call Us for Services</h3>-->
                    <?php // } ?>

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

                <!-- LEGACY:: Safes & Single (custom phone button)  -->
                <?php // if (is_shop() || is_archive() || is_singular('product') || is_page(3857) || is_page(get_sem_locksmith_pages())) { ?>
                <!-- <div id="safes-phone-container">-->
                <!--<p><a href="tel:713-659-3951" class="btn-shadow"><i class="fas fa-phone"></i> (713) 659-3951</a></p>-->
                <!--</div>-->
                <?php // } ?>

                <div id="brand-phone">

                    <!-- LEGACY:: Safes (Dedicated call lead)fu  -->
                    <?php //if (is_shop() || is_archive() || is_singular('product') || is_page(3857)) { ?>
                    <!--<h3>Call for Safe Pricing</h3>-->
                    <!--<p><a href="tel:713-522-5555">713-522-5555</a></p>-->
                    <?php //} else { ?>
                    <?php // } ?>

                    <!-- CURRENT:: Global Call CTA ( pre scroll)  -->
                    <h3>Call Now</h3>
                    <p><a href="tel:713-522-5555">713-522-5555</a></p>

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
    <div id="content" class="site-content">

        <?php
        if(get_query_var( 'name' )=='blog' && get_query_var('page')=="0")
        {
            //$_REQUEST['Team']=get_query_var('Team');
            include('myblog.php'); exit;
        }
        else if(get_query_var('bname') && get_query_var('blog_id_1'))
//else if(get_query_var( 'name' )=='blogdetail')
        {
            $_REQUEST['blogdetail']=get_query_var('bname');
            include('blog_detail.php'); exit;
        }
        else if(get_query_var('name')=='blog' && get_query_var('page') && get_query_var('page')!="0")
        {
            $_REQUEST['paging']=get_query_var('page');
            include('myblog.php'); exit;
        }
        ?>