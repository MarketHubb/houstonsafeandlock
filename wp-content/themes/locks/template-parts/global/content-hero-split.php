<?php
$hero = get_field('page_banner_details');

if ($hero) : ?>

    <div class="container-fluid hero-banner content-section" id="banner-split">
        <div class="row justify-content-end align-items-center row-eq-height">
            <!-- Content (left) -->
            <div class="col-md-5 h-100">

                <h1 class=""><?php echo $hero['page_banner_heading']; ?><br>
                <span class="font-weight-lighter"><?php echo $hero['page_banner_subheading']; ?></span></h1>
                <p class="pr-md-3 pr-lg-5"><?php echo $hero['page_banner_description']; ?></p>

                <?php
                if ($hero['page_banner_button_type'] === 'Custom') {
                    $button_url = $hero['page_banner_button_url'];
                } else {
                    $button_url = $hero['page_banner_button_page_link'];
                }
                ?>

                <?php if ($hero['page_banner_button_type'] !== 'None') { ?>
                    <a class="btn btn-primary btn-lg" href="<?php echo $button_url; ?>" role="button"><?php echo $hero['page_banner_button_text']; ?></a>
                <?php } ?>

            </div>

            <!-- Image (right) -->
            <div class="col-md-5 h-100">
                <div class=""><img
                            src="<?php echo $hero['page_banner_image']; ?>"
                            alt="">
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>