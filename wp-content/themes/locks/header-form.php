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

    <?php get_template_part('template-parts/menu/content', 'navbar'); ?>

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