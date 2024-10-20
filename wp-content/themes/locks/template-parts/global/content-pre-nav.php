<div id="pre-nav" class="!tw-bg-[#7A193A] tw-mx-auto">
    <div class="d-flex flex-row justify-content-between tw-items-center py-2 tw-max-w-[1320px] tw-mx-auto">

        <div class="d-inline-block tw-h-fit">

            <p class="tw-font-normal mb-0  d-inline-block global-alert">
                <img src="<?php echo get_home_url() . '/wp-content/uploads/2024/09/noun-announce-6391379-1.svg' ?>" class="alert-icon tw-max-h-[30px] tw-w-auto icon-left filter-white">
                <a href="<?php echo get_permalink(8988); ?>" class="text-white lh-sm">
                    <span class="tw-font-semibold tw-border-b-1 tw-border-b-white">King Safe & Lock has merged with Houston Safe &amp; Lock!</span></a>
            </p>

        </div>

        <div class="d-inline-block">
            <form id="searchform" method="get" action="https://staging.kingsafeandlock.com/">
                <label for="s" class="search-field-row">
                    <input type="hidden" name="search" value="advanced">
                    <input type="text" class="search-field rounded-pill ps-3" name="s" id="s" size="25" placeholder="AMSEC BFX...">
                    <button id="searchsubmit" class="p-0" href="javascript:void(0)">
                        <i class="far fa-search text-white fa-lg fw-bold ms-1"></i>
                    </button>
                </label>
            </form>

        </div>

        <!-- Scroll logo (Text image) -->
        <!--        <div id="left-content">-->
        <!--            <a href="--><!--">-->
        <!--                <h4 class="text-white my-0"></h4>-->
        <!--            </a>-->
        <!--        </div>-->
        <!-- CURRENT:: Pre Nav (social icons) -->
        <!--        <div id="right-content">-->
        <!--            --> <!--        </div>-->

    </div>
</div>
<div id="pre-nav" class="!tw-bg-[#7A193A] !tw-hidden">
    <div class="container-fixed tw-mx-auto py-2">

        <?php if (!get_field('active', 'options')) { ?>

            <!--            <p class="mb-0 pb-0 d-inline">-->
            <!--                <img id="auto-key-icon" src="--><?php //echo home_url() . '/wp-content/uploads/2022/08/Car-Key.svg' 
                                                                ?><!--" alt="">-->
            <!--                <a class="mb-0 pb-0 text-white" href="https://www.autofobs.com/?ref=44&locid=18451">Auto Remotes</a>-->
            <!--            </p>-->

        <?php } else { ?>
            <div class="d-flex flex-row justify-content-between px-3 px-md-4 px-lg-5 py-2">
                <div class="d-inline-block">

                    <p class="tw-font-semibold mb-0 d-inline-block py-1 global-alert">
                        <img src="https://staging.kingsafeandlock.com/wp-content/uploads/2024/04/noun-announce-6391379.svg" class="alert-icon tw-max-h-[30px] tw-w-auto icon-left filter-white">
                        <a href="<?php echo get_permalink(8988); ?>" class="text-white lh-sm">
                            King Safe & Lock is merging with Houston Safe &amp; Lock</a>
                    </p>

                </div>

                <!-- <p class="font-weight-bold mb-0  d-inline-block py-1 global-alert">
                <a href="<?php echo get_field('alert_link', 'options'); ?>" class="text-white lh-sm">
                    <?php echo get_field('alert_message', 'options'); ?>
                </a>
            </p> -->

            <?php } ?>

            <!-- Scroll logo (Text image) -->
            <div id="left-content">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <h4 class="text-white anti my-0">Houston Safe & Lock</h4>
                </a>
            </div>
            <!-- CURRENT:: Pre Nav (social icons) -->
            <div id="right-content">
                <?php get_search_form(); ?>
            </div>

            </div>
    </div>
</div>