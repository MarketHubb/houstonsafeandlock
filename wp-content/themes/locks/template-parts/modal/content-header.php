<?php
$logo = get_home_url() . '/wp-content/uploads/2022/09/HSL-Logo-White.svg';
$heading = $args['heading'];
?>
<div class="modal-header bg-blue px-2 px-md-3">
    <div class="container-fluid">

        <div class="d-flex flex-row justify-content-between align-items-center">
            <div class="">
                <img src="<?php echo $logo; ?>" class="modal-logo" alt="">
            </div>
            <?php if ($heading) { ?>
                <div class="flex-grow-1 text-end">
                    <p class="text-white mb-0 pb-0 pe-3 me-1">
                        <?php echo $heading; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
</div>

