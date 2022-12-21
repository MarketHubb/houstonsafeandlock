<?php get_header(); ?>

    <div class="custom-content" id="">

        <!-- Banner Transform (Empty) -->
        <div class="banner section-container transformed-bg blue py-0">
            <div class="container py-0">
                <div class="row align-items-center h-100 py-0">
                    <div class="col-md-12 py-0"></div>
                </div>
            </div>
        </div>


        <!-- Results Container -->
        <div class="container my-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="text-center mt-4 mb-3">
                            <h1 class="font-weight-bold"><?php echo $GLOBALS['wp_query']->found_posts; ?> Results found for</h1>
                            <h2 class="lead fs-2 font-weight-normal"><em>"<?php echo htmlspecialchars($_GET["s"]) ?>"</em></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php get_template_part('template-parts/search/content'); ?>



<?php get_footer(); ?>
