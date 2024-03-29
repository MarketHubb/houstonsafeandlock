<?php $form_id = get_query_var('form_id') ?: 1; ?>
<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-9 justify-content-start">
                            <h2 class="modal-title font-weight-bold" id="exampleModalLabel">Houston Safe & Lock</h2>
                            <p class="mb-0 small"><em>Proudly serving Houston & surrounding communities since 1923</em></p>
                        </div>
                    </div>
                </div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p class="lead d-inline-block my-3 font-weight-bold modal-subtitle lh-base fs-4 border-bottom"></p>
                        </div>
                    </div>
                    <div class="row align-items-center w-100">
                        <div class="col-md-7">
                            <?php gravity_form( $form_id, $display_title = false, $display_description = false, $ajax = false, $tabindex="10", $echo = true ); ?>
                        </div>
                        <div class="col-md-5 mx-auto text-center">
                            <img src="" class="modal-image shadow" alt="" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <p class="mb-0"><strong>Bonded and Insured For Your Protection! License #B19935701</strong></p>
                <p><small>Copyright © 2021 | HoustonSafeandLock.net All Rights Reserved. | <a href="<?php echo get_home_url() . '/privacy-policy/'; ?>">Privacy
                            Policy</a> | <a href="<?php echo get_home_url() . '/terms-and-conditions/'; ?>">Terms & Conditions</a></small></p>
            </div>
        </div>
    </div>
</div>