<?php
$form_id = get_query_var('form_id') ?: 1;
$form_heading = get_query_var('modal_heading') ?: 'Inquiry';
$form_mobile_heading = get_query_var('modal_mobile_heading') ?: 'Inquiry';
$callout_prefix = get_query_var('modal_callouts') ?: '';
?>


<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-new">
        <div class="modal-content">

            <?php $heading_args = ['heading' => $form_heading, 'mobile_heading' => $form_mobile_heading]; ?>
            <?php get_template_part('template-parts/modal/content', 'header', $heading_args); ?>

            <div class="modal-body">

                <?php get_template_part('template-parts/modal/content', 'callouts', ['prefix' => $callout_prefix]); ?>

                <div class="container-fluid">
                    <div class="row d-none">
                        <div class="col-md-12 text-center">
                            <p class="lead d-inline-block my-3 font-weight-bold modal-subtitle lh-base fs-4 border-bottom"></p>
                        </div>
                    </div>

                    <!-- Form Title -->
                    <div class="row justify-content-center pt-md-4">
                        <div class="col-12 col-md-8 col-lg-7">
                            <?php if ($form_id === 1) { ?>
                                <div class="mt-3 mb-4 text-center">
                                    <h4 class="text-blue fw-bold">Product Inquiry - <?php echo get_the_title(); ?> </h4>
                                    <p class="text-secondary mb-4 pb-3 lh-sm">Get our weekly sale pricing, delivery + installation options and more</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="row align-items-center justify-content-center px-sm-0">
                        <div class="col-12 col-md-11">


<!--                            <script data-b24-form="inline/15/9jyzqr" data-skip-moving="true">(function(w,d,u){var s=d.createElement('script');s.async=true;s.src=u+'?'+(Date.now()/180000|0);var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})(window,document,'https://cdn.bitrix24.com/b24117867/crm/form/loader_15.js');</script>-->


                            <?php gravity_form( $form_id, $display_title = false, $display_description = false, $ajax = false, $tabindex="10", $echo = true ); ?>
                        </div>
                        <div class="col-md-5 mx-auto text-center">
                            <img src="" class="modal-image" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="mb-0"><strong>Bonded and Insured For Your Protection! License #B19935701</strong></p>
                <p><small>Copyright © <?php echo date("Y"); ?> | HoustonSafeandLock.net All Rights Reserved. | <a href="<?php echo get_home_url() . '/privacy-policy/'; ?>">Privacy
                            Policy</a> | <a href="<?php echo get_home_url() . '/terms-and-conditions/'; ?>">Terms & Conditions</a></small></p>
            </div>
        </div>
    </div>
</div>