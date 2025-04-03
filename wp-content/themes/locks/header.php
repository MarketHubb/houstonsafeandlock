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


        <!-- Manually Enqueue GF -->
        <?php
        // function gf_enqueue_required_files()
        // {
        //     gravity_form_enqueue_scripts(5, true); // Form ID 5 with ajax enabled.
        // }
        // add_action('get_header', 'gf_enqueue_required_files');
        ?>

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
</head>

<body <?php body_class(); ?>>

    <?php get_template_part('template-parts/tw-shared/content', 'header'); ?>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T9MW374" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <?php $data_type = (is_singular('product')) ? 'single-product' : ''; ?>

    <div id="page" class="site pt-[15px] md:pt-[102px]" data-pageid="<?php echo get_the_ID(); ?>" data-type="<?php echo $data_type; ?>">
        <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'locks'); ?></a>
        <!-- #masthead -->

        <div id="content" class="site-content pt-[81px] sm:pt-[7px] lg:pt-[11px] px-5 sm:px-0">

            <?php
            if (is_sale_enabled() && is_sale_active()) {
                $alert = get_alert_by_page(get_queried_object_id());

                if ($alert) echo $alert;
            }
