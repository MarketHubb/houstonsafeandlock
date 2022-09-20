<?php if (!is_shop()) { ?>

    <div class="container-fluid" id="breadcrumb-container">
        <div class="row justify-content-end w-100">
            <div class="col">
                <ol vocab="https://schema.org/" typeof="BreadcrumbList">


                <?php
                    $breadcrumb_start_organic = '<li class="px-0" property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"
                                    href="' . get_permalink(2320) . '">
                                    <span property="name me-1 px-0">Safes <span class="mx-1">›</span></span></a>
                                    <meta property="position" content="1">
                                    </li>';

                    $breadcrumb_start_category = '<li class="px-0" property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage"
                                    href="' . get_permalink(3857) . '">
                                    <span property="name me-1 px-0">Safes <span class="mx-1">›</span></span></a>
                                    <meta property="position" content="1">
                                    </li>';

                    $breadcrumbs = '';

                    $terms = get_the_terms( $post->ID, 'product_cat' );

                    $i = 0;

                    if (is_singular('product')) {

                        $title = get_the_title();

                        $request_referrer = $_SERVER['HTTP_REFERER'];

                        $pos = strpos($request_referrer, 'category-gun-safes');

//                        if ($pos === false) {

                            $breadcrumbs .= $breadcrumb_start_organic;

                            foreach (array_reverse($terms) as $term) {

                                $breadcrumbs .= '<li class="px-0" property="itemListElement" typeof="ListItem">';
                                $breadcrumbs .= '<a property="item" typeof="WebPage"';
                                $breadcrumbs .= 'href="' . get_term_link($term->term_id , 'product_cat' ) . '">';
                                $breadcrumbs .= '<span property="name me-1 px-0">' . $term->name . ' <span class="mx-1">›</span></span></a>';
                                $breadcrumbs .= '<meta property="position" content="' . ($i + 2) . '">';
                                $breadcrumbs .= '</li>';

                                $i++;


                            }

//                        }
//                    else {
//
//                            $breadcrumbs .= $breadcrumb_start_category;
//
//                        }


                    } else if (is_archive() && !is_shop()) {

                        $breadcrumbs .= $breadcrumb_start_organic;

                        $title = woocommerce_page_title( false );

                    }


                    $title_clean = trim(str_replace('AMSEC', '', $title));
                    $breadcrumbs .= '<li class="px-0" property="itemListElement" typeof="ListItem">
                                    <span property="name me-1 px-0">' . $title_clean . '</span>
                                    <meta property="position" content="' . ( count($terms) + 1) . '">
                                    </li>';

                echo $breadcrumbs;

                ?>

                </ol>
            </div>
        </div>
    </div>

<?php } ?>