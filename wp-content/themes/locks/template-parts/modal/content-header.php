<?php
$logo = get_home_url() . '/wp-content/uploads/2022/09/HSL-Logo-White.svg';
$heading = $args['heading'];
?>
<div class="modal-header bg-blue px-2 px-md-3">
    <div class="container-fluid">

        <div class="row justify-content-between align-items-center">
            <div class="col-8">
                <img src="<?php echo $logo; ?>" class="modal-logo" alt="">
            </div>
            <?php if ($heading) { ?>
<!--                <div class="col-6 text-end">-->
<!--                    <h4 class="fw-bold text-white mb-0 pb-0">-->
<!--                        --><?php //echo $heading; ?>
<!--                    </h4>-->
<!--                </div>-->
            <?php } ?>
        </div>

        <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
</div>

