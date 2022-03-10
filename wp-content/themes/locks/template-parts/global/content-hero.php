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
                        <p class="lead d-none d-md-block text-white hero-alert my-0 py-2">
                            <i class="fad fa-exclamation-triangle pr-2"></i>
                            Appointments still available today - Call Now!
                            <span class="hero-phone-alert-container">
                                <a class="hero-phone hero-phone-alert font-weight-bold inverse-orange" href="tel:713-522-5555">                                     713-522-5555
                                </a>
                            </span>
                        </p>
                        <p class="lead d-block d-md-none text-white hero-alert my-0 py-2">
                            <?php $openings = rand(2, 4); ?>
                            <span class="border-bottom border-2"><?php  echo $openings; ?> openings</span> still available today, book now!
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

                <div class="row justify-content-center mb-0 mb-md-4">
                    <div class="col-12 col-md-10 col-lg-8">
                        <ul class="list-group list-group-flush list-group-horizontal bg-none py-md-1">
                            <li class="list-group-item flex-fill bg-none text-center pb-0 border-0">
                                <p class="text-white font-weight-bolder border border-1 rounded-pill py-1 px-4 px-md-4 px-lg-5 mb-0 d-inline-block">Access</p>
                            </li>
                            <li class="list-group-item flex-fill bg-none text-center pb-0 border-0">
                                <p class="text-white font-weight-bolder border border-1 rounded-pill py-1 px-4 px-md-4 px-lg-5 mb-0 d-inline-block">Keys</p>
                            </li>
                            <li class="list-group-item flex-fill bg-none text-center pb-0 border-0">
                                <p class="text-white font-weight-bolder border border-1 rounded-pill py-1 px-4 px-md-4 px-lg-5 mb-0 d-inline-block">Locks</p>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php } ?>

            <?php if (is_page(4149)) { ?>
                <div class="row justify-content-center">
                    <div class="col-11 col-md-10 col-lg-9">
                        <h1 class="display-2 mb-3 mt-3">24/7 Houston Locksmiths</h1>
                        <p class="lead text-white d-block d-lg-none"><span class="">Licensed, bonded and insured locksmiths</span> serving all of Houston and surrounding communities 24-hours a day, 7-days a week.</p>
                        <p class="lead text-white d-none d-lg-block fs-3 fw-500"><span class="">Licensed, bonded and insured locksmiths</span> serving all of Houston and surrounding communities 24-hours a day, 7-days a week.</p>

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
<!--                    <button id="locksmith-btn" type="button" class="d-none d-md-inline-block btn btn-primary inline-block bg-orange border-0 shadow"-->
<!--                            data-bs-toggle="modal"-->
<!--                            data-bs-target="#locksmithModal">-->
<!--                        Schedule A Certified Houston Locksmith-->
<!--                    </button>-->
                    <button id="locksmith-btn" type="button"
                        class="my-4 btn btn-primary inline-block bg-orange border-0 shadow px-4 px-lg-5 fw-500"
                        data-bs-toggle="modal"
                        data-bs-target="#locksmithModal">
                        <span class="d-inline-block d-md-none">Schedule Service Now</span>
                        <span class="d-none d-md-inline-block fs-5">Schedule Service Now</span>
                </button>
                        <p class="text-center text-white fst-italic">Daily appointments available <br class="d-block d-lg-none"> or schedule future service</p>

                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

<?php endif; ?>

