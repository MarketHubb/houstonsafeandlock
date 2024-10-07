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
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    $bool_title = 0;
    if (get_query_var('name') == 'blog' && get_query_var('page') == "") {
        $bool_title = 1;
        $p_title = 'Blog';
    } else if (get_query_var('bname') && get_query_var('blog_id_1'))

    //else if(get_query_var( 'name' )=='blogdetail')
    {
        $bool_title = 1;
        $p_title = 'Blog';
    } else if (get_query_var('name') == 'blog' && get_query_var('page')) {
        $bool_title = 1;
        $p_title = 'Blog';
    }
    ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php
    if ($bool_title == 0) {
        wp_head();
    } elseif ($bool_title == 1) {

    ?>
        <title><?php echo $p_title; ?> - <?php echo get_bloginfo('name'); ?></title>
    <?php wp_head();
    }
    ?>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-T9MW374');
    </script>
    <!-- End Google Tag Manager -->


    <script type="text/javascript">
        (function($) {
            $.noConflict();
            $(document).ready(function() {
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

                var Sform = '<form id="searchform" method="get" action="<?php bloginfo('url'); ?>/"><label for="s" class="search-field-row"><input type="text" class="search-field" placeholder="SEARCH" name="s" id="s" size="25" /><button id="searchsubmit" href="javascript:void(0)"><div id="searchIcon" class="search-icon"></div></button></label></form>';
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

    <?php get_template_part('template-parts/tw-shared/content', 'header'); ?>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9MW374" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php $body_class =  sanitize_post(get_queried_object())->post_name ?: ''; ?>

    <?php $data_type = (is_singular('product')) ? 'single-product' : ''; ?>

    <div id="page" class="site md:pt-[67.5px] <?php echo $body_class; ?>" data-pageid="<?php echo get_the_ID(); ?>" data-type="<?php echo $data_type; ?>">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'locks'); ?></a>
        <!-- #masthead -->

        <div id="content" class="site-content">

            <?php
            if (get_query_var('name') == 'blog' && get_query_var('page') == "0") {
                //$_REQUEST['Team']=get_query_var('Team');
                include('myblog.php');
                exit;
            } else if (get_query_var('bname') && get_query_var('blog_id_1'))
            //else if(get_query_var( 'name' )=='blogdetail')
            {
                $_REQUEST['blogdetail'] = get_query_var('bname');
                include('blog_detail.php');
                exit;
            } else if (get_query_var('name') == 'blog' && get_query_var('page') && get_query_var('page') != "0") {
                $_REQUEST['paging'] = get_query_var('page');
                include('myblog.php');
                exit;
            }
            ?>
