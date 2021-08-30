<?php if (!is_shop()) { ?>

    <div class="container-fluid" id="breadcrumb-container">
        <div class="row">
            <div class="col">
                <ol vocab="https://schema.org/" typeof="BreadcrumbList">


                <?php
                    $breadcrumb_start_organic = '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"
                                    href="' . get_permalink(2320) . '">
                                    <span property="name">All Safes</span></a>
                                    <meta property="position" content="1">
                                    </li> ›';

                    $breadcrumb_start_category = '<li property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"
                                    href="' . get_permalink(3857) . '">
                                    <span property="name">All Safes</span></a>
                                    <meta property="position" content="1">
                                    </li> ›';

                    $breadcrumbs = '';

                    $terms = get_the_terms( $post->ID, 'product_cat' );

                    $i = 0;

                    if (is_singular('product')) {

                        $title = get_the_title();

                        $request_referrer = $_SERVER['HTTP_REFERER'];

                        $pos = strpos($request_referrer, 'category-gun-safes');

                        if ($pos === false) {

                            $breadcrumbs .= $breadcrumb_start_organic;

                            foreach (array_reverse($terms) as $term) {

                                $breadcrumbs .= '<li property="itemListElement" typeof="ListItem">';
                                $breadcrumbs .= '<a property="item" typeof="WebPage"';
                                $breadcrumbs .= 'href="' . get_term_link($term->term_id , 'product_cat' ) . '">';
                                $breadcrumbs .= '<span property="name">' . $term->name . '</span></a>';
                                $breadcrumbs .= '<meta property="position" content="' . ($i + 2) . '">';
                                $breadcrumbs .= '</li>';
                                $breadcrumbs .= '›';

                                $i++;


                            }

                        } else {

                            $breadcrumbs .= $breadcrumb_start_category;

                        }


                    } else if (is_archive() && !is_shop()) {

                        $breadcrumbs .= $breadcrumb_start_organic;

                        $title = woocommerce_page_title( false );

                    }


                    $breadcrumbs .= '<li property="itemListElement" typeof="ListItem">
                                    <span property="name">' . $title . '</span>
                                    <meta property="position" content="' . ( count($terms) + 1) . '">
                                    </li>';

                echo $breadcrumbs;

                ?>

                </ol>
            </div>
        </div>
    </div>

<?php } ?>