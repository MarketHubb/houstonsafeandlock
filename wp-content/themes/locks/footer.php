<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package locks
 */
?>
	</div><!-- #content -->

<div class="footer-container bg-blue text-white py-5">
    <div class="container py-4 my-2">
        <div class="row">

                <?php
                $top_pages = [
                    'Locksmith Services' => [
                        'icon' => 'fa-solid fa-key',
                        'page_ids' => [6624, 6839, 6448] 
                     ],
                    'Safes for Sale' => [
                        'icon' => 'fa-solid fa-vault',
                        'page_ids' => [37,27,28,42,33]
                     ],
                    'Top Pages' => [
                        'icon' => 'fa-solid fa-square-up-right',
                        'page_ids' => [266, 66, 4, 68]
                     ],

                ];

                $page_links = '';
                foreach ($top_pages as $key => $val) {
                    $page_links .= '<div class="col-md-3 pe-md-4 mb-5 mb-md-0 ps-4 ps-md-0">';
//                    $page_links .= '<i class="' . $val['icon'] . ' fa-sm mb-3 d-inline d-md-block text-secondary"></i>';
                    $page_links .= '<h5 class="fw-bold mb-3 mb-md-4">';
                    $page_links .= '<i class="' . $val['icon'] . ' pe-2 pe-md-0 me-1 me-md-0 mb-3 d-inline d-md-block text-secondary"></i>';
                    $page_links .= $key . '</h5>';
                    $page_links .= '<ul class="list-group list-group-flush ps-0 ms-0">';

                    foreach ($val['page_ids'] as $page_id) {
                        $page_links .= '<li class="list-group-item ps-4 ms-2 ms-md-0 ps-md-0 border-0 py-1 bg-transparent">';

                        if ($key === 'Safes for Sale') {
                            $cat = get_term($page_id, 'product_cat');
                            $link_text = $cat->name;
                            $link = get_category_link($page_id);
                        } else {
                            $link_text = get_the_title($page_id);
                            $link = get_permalink($page_id);
                        }

                        $page_links .= '<a href="' . $link . '" class="">';
                        $page_links .= $link_text;
                        $page_links .= '</a></li>';
                    }

                    if ($key === 'Locksmith Services') {
                        $page_links .= '<li class="list-group-item ps-4 ms-2 ms-md-0 ps-md-0 border-0 bg-transparent">';
                        $page_links .= '<a href="https://www.autofobs.com/?ref=44&locid=18451" class="">';
                        $page_links .= 'Auto Fob Duplication';
                        $page_links .= '</a></li>';
                    }

                    $page_links .= '</ul></div>';
                }

                echo $page_links;
                ?>

            <div class="col-md-3 footer-schema mb-md-0 ps-4 ps-md-0" id="">
                <h5 class="fw-bold mb-3 mb-md-4"><i class="fa-solid fa-location-dot pe-2 pe-md-0 me-1 me-md-0 mb-3 d-inline d-md-block text-secondary"></i>Call or Visit</h5>
                <!-- Generated using https://microdatagenerator.org/localbusiness-microdata-generator/ -->
                <div itemscope itemtype="https://schema.org/LocalBusiness" class="ps-4 ms-2 ms-md-0 ps-md-0">
                    <div itemprop="name" class="fw-bold mt-1 mb-2">Houston Safe & Lock</div>
                    <div>Email: <span itemprop="email"><a href='mailto:sales@houstonsafeandlock.com'>sales@houstonsafeandlock.com</a></span></div>
                    <div>Phone: <a href="tel:713-522-5555"><span itemprop="telephone">713-522-5555</span></a></div>

                    <div itemprop="paymentAccepted"  style='display: none' >cash, check, credit card</div>
                    <meta itemprop="openingHours"  style='display: none'  datetime="Mo,Tu,We,Th,Fr,Sa 08:00-05:00" />
                    <hr class="my-3">
                    <div itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
                        <div itemprop="streetAddress">10218 F, Westheimer Rd.</div>
                        <div><span itemprop="addressLocality">Houston</span>, <span itemprop="addressRegion">TX</span> <span itemprop="postalCode">77042</span></div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<div class="container-fixed">
				<div id="footer-cols">
					<?php
					if(is_active_sidebar( 'footer-menus' )){
//						dynamic_sidebar( 'footer-menus' );
					}
					?>
				</div>
<img class="size-full wp-image-1720 aligncenter" src="http://www.houstonsafeandlock.net/wp-content/uploads/2016/11/creditCards.png" alt="Credit cards that we accept" width="300" height="75" />
				<div id="footer-logos">
					<?php
					$images = get_field( 'footer_images', 'option' );
                    if ($images) {
                        foreach ( $images as $image ) { ?>
                            <!--						<a href="--><?php //echo $image['url']; ?><!--">-->
<!--                            <img src="--><?php //echo $image['sizes']['thumbnail']; ?><!--" alt="" />-->
                            <!--						</a>-->
                        <?php }
                    }
                ?>
				</div>
				<div id="footer-disclaimer">
					<?php //the_field( 'footer_disclaimer', 'option' ); ?>
                    <p class="lead fw-bold mb-4">Bonded and Insured For Your Protection! License #B19935701</p>
				</div>
                <div class="row justify-content-center">
                    <div class="col-10 col-md-2">
                        <img class="" src="<?php echo get_home_url() . '/wp-content/uploads/2022/06/HSL-Phone.png'; ?>" />
                    </div>
                </div>
            </div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php
if (is_shop() || is_archive() || is_singular('product') || is_page(3857) || is_page(6287) || is_page([6448, 6624, 6839, 7276])) {
//    get_template_part('template-parts/global/content', 'modal');
    get_template_part('template-parts/modal/content', 'modal');
}
//if (is_page(4149) || is_page_template('page-templates/full-width.php')) {
//    get_template_part('template-parts/global/content', 'modal-locksmith');
//}
?>

<?php wp_footer(); ?>

<!-- Google Code for Remarketing Tag -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1026494785;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1026494785/?guid=ON&amp;script=0"/>
</div>
</noscript>
<script type="text/javascript" src="//cdn.callrail.com/companies/327335430/7f0018b85cb8e567f0f9/12/swap.js"></script>
</body>
</html>