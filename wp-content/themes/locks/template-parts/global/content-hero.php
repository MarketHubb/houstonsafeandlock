<?php
$hero = get_field('page_banner_details');

if ($hero) :

    $heading = !empty($hero['page_banner_heading']) ? $hero['page_banner_heading'] : get_the_title();
    $bg_opacity = $hero['page_banner_image_opacity'] > 0 ? $hero['page_banner_image_opacity'] : .75;
    $linear_gradient = 'linear-gradient(to bottom, rgba(0,0,0,' .  $bg_opacity . ') 0%,rgba(0,0,0,' . $bg_opacity . ') 100%)';
    $text_align_class = $hero['page_banner_text_align'] = 'center' ? 'text-center' : '';
    $image_align_class = ($hero['page_banner_image_align']) ? 'bg-image-' . strtolower($hero['page_banner_image_align']) : '';

?>

<?php
    if (is_page(6110) || is_page(6121)) {
        $bg_align_class = 'bp-top';
    } else {
        $bg_align_class = '';
    }
?>

    <?php if (is_page(4149)) { ?>
    <div class="bg-orange">
        <div class="container-fluid">
            <div class="wrapper">
                <div class="row">
                    <div class="col text-center">
<!-- For immediate service or to schedule an appointment call-->
                        <p class="lead text-white hero-alert my-0 py-2">
                            <i class="fad fa-exclamation-triangle pr-2"></i>
                            Appointments still available today - Call Now!
                            <span class="hero-phone-alert-container"><a class="hero-phone hero-phone-alert font-weight-bold inverse-orange" href="tel:713-522-5555"> 713-522-5555</a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>
    <div class="jumbotron bg-cover text-white px-sm-2 <?php echo $bg_align_class; ?> <?php echo $image_align_class; ?>"
         style="background-image: <?php echo $linear_gradient; ?>,
         url(<?php echo $hero['page_banner_image']; ?>)">

        <div class="container-fluid <?php echo $text_align_class; ?> py-3">
            <?php
            if (is_page(4149)) { ?>
            <div class="wrapper">
                <div class="row justify-content-center py-md-1" id="locksmith-banner-icons">
                    <div class="col-4 col-md-3 text-center">
<!--                        <i class="fa fa-car fa-2x text-orange pb-2"></i>-->
                        <h2 class="text-white font-weight-bolder">Auto</h2>
                    </div>
                    <div class="col-4 col-md-3 text-center">
<!--                        <i class="fas fa-home-lg-alt fa-2x text-orange pb-2"></i>-->
                        <h2 class="text-white font-weight-bolder">Home</h2>
                    </div>
                    <div class="col-4 col-md-3 text-center">
<!--                        <i class="fas fa-building fa-2x text-orange pb-2"></i>-->
                        <h2 class="text-white font-weight-bolder">Commercial</h2>
                    </div>
                </div>

            <?php } ?>

            <?php if (is_page(4149)) { ?>
                <div class="row">
                    <div class="col-12 col-md-11">

                <h1 class="display-2 mb-3 mt-3">24/7 Houston Locksmiths</h1>
                <p class="lead text-white"><span class="">Licensed, bonded and insured locksmiths</span> serving all of Houston and surrounding communities 24-hours a day, 7-days a week.</p>

            <?php } else { ?>

                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="image-text-container d-inline-block p-4 p-md-5">

                            <h1 class="display-3 mb-0 mt-5 mt-lg-3"><?php echo $heading; ?></h1>

                            <?php if ($hero['page_banner_subheading']) { ?>
                                <p class="subheading mt-3 text-white fw-bold lh-1"><?php echo $hero['page_banner_subheading']; ?></p>
                            <?php } ?>

                            <p class="lead text-white"><?php echo $hero['page_banner_description']; ?></p>

                            <?php
                            if ($hero['page_banner_button_type'] === 'Custom') {
                                $button_url = $hero['page_banner_button_url'];
                            } else {
                                $button_url = $hero['page_banner_button_page_link'];
                            }
                            ?>

                            <?php if ($hero['page_banner_button_type'] !== 'None') { ?>
                                <a class="btn btn-primary btn-lg text-white px-5 bg-orange no-borders lead" href="<?php echo $button_url; ?>" role="button">
                                    <?php echo $hero['page_banner_button_text']; ?>
                                    <i class="fas fa-long-arrow-right ml-1"></i>
                                </a>
                            <?php } ?>

                    </div>
                </div>
            </div>

            <?php } ?>

            <?php if (is_page(4149)) { ?>
                    <button id="locksmith-btn" type="button" class="btn btn-primary inline-block"
                            data-bs-toggle="modal"
                            data-bs-target="#locksmithModal">
                        Schedule A Certified Houston Locksmith
                    </button>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

<?php endif; ?>

