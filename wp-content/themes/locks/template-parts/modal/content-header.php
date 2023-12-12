<?php
$logo = get_home_url() . '/wp-content/uploads/2022/09/HSL-Logo-White.svg';
?>
<div class="modal-header bg-blue px-2 px-md-3">
    <div class="container-fluid">

        <div class="d-flex flex-row justify-content-between align-items-center">

            <div class="">
                <img src="<?php echo $logo; ?>" class="modal-logo" alt="">
            </div>

            <div class="modal-phone-container">
                <a class="text-white fw-bold anti" href="tel:713-955-9762"><i class="fa-solid fa-phone pe-2 small opacity-75"></i> 713-955-9762</a>
            </div>

        </div>

        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
</div>

