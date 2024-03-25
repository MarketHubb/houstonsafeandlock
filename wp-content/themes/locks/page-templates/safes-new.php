<?php

/* Template Name: All Safes (New) */

get_header();

?>
<div id="primary" class="content-area" data-url="<?php echo home_url(); ?>">
    <main id="main" class="site-main" role="main">

        <!-- Container -->
        <div class="container-xxl">

            <!-- Hero -->
            <div class="row py-5 mt-5">
                <h1>Safes for Sale</h1>
                <p class="hero-sub text-sm">
                    We carry the largest selection of in-stock, ready-to-ship safes in Houston.<br>
                    Have questions? Our team of safe & security experts can help.
                </p>
            </div>

            <div class="row justify-content-end align-items-center" id="sort-container">

                <!-- Mobile -->
                <div class="col-4 col-md-6 d-block d-md-none">
                    <!-- Button trigger modal -->
                    <p class="fw-600 mb-0 text-normal ps-2" data-bs-toggle="modal" data-bs-target="#modal-safe-filters">
                        Filters <i class="fa-solid fa-up-right-from-square fa-sm opacity-80 ps-1"></i>
                    </p>
                </div>
                <div class="col-8 col-md-6 text-end" id="sort-filter-container">
                    <!-- Sorts -->
                    <?php echo output_safe_sorts(); ?>
                </div>
            </div>

            <div class="row gx-5 bg-gray-50 p4-5">

                <!-- Desktop -->
                <!-- <div class="col-md-4 col-lg-3 d-none d-md-block" id="safe-filters"> -->
                <div class="col-12 col-md-4 col-lg-3" id="safe-filters">

                    <div class="d-none d-md-block">
                        <p class="fw-bold">Filter safes:</p>
                        
                        <!-- Default (Reset) -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="reset" id="reset">
                            <label class="form-check-label" for="reset">
                                Reset filters
                            </label>
                        </div>
                        
                        <hr>
                    </div>
                    <?php echo output_safe_filters(); ?>

                </div>

                <!-- Product Grid -->
                <div class="col-md-8 col-lg-9" id="safe-products">

                    <?php
                    // $output  = '<div class="container">';
                    $output = '<div class="row" id="#filter-container">';
                    $safes = all_safes();

                    // $test = safe_grid_attributes(8821);

                    $safe_grid_classes = [
                        'image' => 'product-img',
                        'description' => 'clamp-3 text-sm lh-base',
                    ];

                    foreach ($safes as $safe) {
                        $output .= safe_grid_item($safe->ID, '4', $safe_grid_classes);
                    }

                    $output .= '</div>';

                    echo $output;

                    ?>

                </div>
            </div>
        </div>
    </main>
</div>

<?php get_footer(); ?>