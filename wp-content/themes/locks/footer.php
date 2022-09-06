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
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<div class="container-fixed">
				<div id="footer-cols">
					<?php
					if(is_active_sidebar( 'footer-menus' )){
						dynamic_sidebar( 'footer-menus' );
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
                            <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="" />
                            <!--						</a>-->
                        <?php } ?>
                    }
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
if (is_shop() || is_archive() || is_singular('product') || is_page(3857) || is_page(6287)) {
    get_template_part('template-parts/global/content', 'modal');
}
if (is_page(4149) || is_page_template('page-templates/full-width.php')) {
    get_template_part('template-parts/global/content', 'modal-locksmith');
}
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