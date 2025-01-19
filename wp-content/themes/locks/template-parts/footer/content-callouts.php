<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="site-info">
        <div class="container mx-auto px-4">
            <div id="footer-cols">
                <?php
                if (is_active_sidebar('footer-menus')) {
                    // dynamic_sidebar('footer-menus');
                }
                ?>
            </div>

            <img class="mx-auto w-[300px] h-[75px]"
                src="http://www.houstonsafeandlock.net/wp-content/uploads/2016/11/creditCards.png"
                alt="Credit cards that we accept" />

            <div id="footer-disclaimer">
                <p class="text-lg font-bold mb-4">Bonded and Insured For Your Protection! License #B19935701</p>
            </div>

            <div class="flex justify-center">
                <div class="w-10/12 md:w-2/12">
                    <img src="<?php echo get_home_url() . '/wp-content/uploads/2022/06/HSL-Phone.png'; ?>"
                        alt="Phone" />
                </div>
            </div>
        </div>
    </div>
</footer>