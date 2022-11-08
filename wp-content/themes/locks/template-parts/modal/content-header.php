<?php
$logo = get_home_url() . '/wp-content/uploads/2022/09/HSL-Logo-White.svg';
$heading = $args['heading'] ?: 'Inquiry';
$mobile_heading = $args['mobile_heading'] ?: 'Inquiry';
?>
<div class="modal-header bg-blue px-2 px-md-3">
    <div class="container-fluid">

        <div class="d-flex flex-row justify-content-between align-items-center pe-5">

            <div class="">
                <img src="<?php echo $logo; ?>" class="modal-logo" alt="">
            </div>

            <div class="">
                <p class="text-white d-block d-md-none mb-0 pb-0 pe-3 me-1 fw-600"><?php echo $mobile_heading; ?></p>
                <p class="text-white d-none d-md-block mb-0 pb-0 pe-3 me-1 fw-600"><?php echo $heading; ?></p>
            </div>

        </div>

        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
</div>

