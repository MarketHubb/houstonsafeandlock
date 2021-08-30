<?php /* Template Name: Test */
get_header(); ?>

<div class="container-fluid">
    <div class="wrapper">
        <div class="row">
            <div class="col text-center mt-5 mb-3 py-2 bb-grey">
                <h1 class="page-title">Test</h1>
                <?php gravity_form( 3, $display_title = false, $display_description = false, $ajax = false, $tabindex="10", $echo = true ); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
