<?php
$cat = $args;
$heading = (get_field('hero_heading', $cat)) ?: $cat->name;
$description = (get_field('hero_description', $cat)) ?: $cat->description;
$btn_copy = (get_field('hero_button_copy', $cat)) ?: null;
?>
    <div class="row justify-content-center align-items-center mt-4 mb-2 pt-4 my-md-4 py-md-3 cat-hero">
        <div class="col-md-12 text-center mb-1 mb-md-4 border-bottom">

            <div class="hero-copy-container mb-4 mb-lg-5">

                <?php if (get_field('hero_pre_heading', $cat)) { ?>
                    <p class="lead text-uppercase">
                        <?php echo get_field('hero_pre_heading', $cat) ?>
                    </p>
                <?php } ?>

                <h1>
                    <?php echo $heading; ?>
                </h1>

                <p class="mb-2 mb-md-4 pb-2 lead fw-500 cat-description">
                    <?php echo $description; ?>
                </p>

                <?php if ($btn_copy) { ?>
                    <a href="#scrollspyHeading1" type="button" class="btn btn-primary d-inline-block bg-orange fw-600 rounded-pill shadow-sm font-lg font-source border-1">
                        <?php echo $btn_copy; ?>
                    </a>
                <?php } ?>

            </div>

            <?php if( have_rows('callouts', $cat) ):
                $callout = '<div class="row cat-callouts">';
                while ( have_rows('callouts', $cat) ) : the_row();
                    $callout .= '<div class="col-4 text-center px-4 ">';
                    if (get_sub_field('heading')) {
                        $callout .= '<h4 class="fs-5  px-2 px-md-0 text-center">';

                        if (get_sub_field('icon')) {
                            $callout .= '<i class="' . get_sub_field('icon', $cat) . ' pe-2 d-block d-md-inline mb-2 mb-md-0 text-blue"></i>';
                        }

                        $callout .= get_sub_field('heading', $cat) . '</h4>';
                    }

                    if (get_sub_field('description')) {
                        $callout .= '<p class="text-secondary d-none d-md-block lh-base">' . get_sub_field('description', $cat) . '</p>';
                    }

                    $callout .= '</div>';
                endwhile;
                $callout .= '</div>';
                echo $callout;
            endif; ?>

        </div>
    </div>

