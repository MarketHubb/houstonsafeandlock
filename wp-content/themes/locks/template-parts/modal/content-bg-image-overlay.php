<!-- Modal -->
<?php
$bg_image = get_field('popup_image', 'option')['url'] ?: '';
$mobile_bg_image = get_field('popup_image_mobile', 'option')['url'] ?: $bg_image;
?>
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="d-none d-md-grid modal-dialog modal-xl border border-4 border-white rounded modal-dialog-centered rounded shadow-lg tw-grid " style="background-image: url(<?php echo $bg_image; ?>); background-position: right; background-size: cover;">
        <div class="modal-content border-0 bg-transparent h-100">
            <div class="modal-header border-0">
                <div class="d-inline-block" style="background: rgba(255,255,255,.5);">
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0 tw-grid tw-grid-cols-12 tw-justify-center tw-items-end">
                <div class="tw-col-span-12 py-4 px-lg-5 px-md-4 popup_content" style="background: rgba(0,0,0,.85);">
                    <?php echo get_field('popup_heading', 'option'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-dialog dialog-mobile modal-xl border border-4 border-white rounded modal-dialog-centered rounded shadow-lg d-grid d-md-none " style="background-image: url(<?php echo $mobile_bg_image; ?>); background-position: center; background-size: cover;">
        <div class="modal-content border-0 bg-transparent h-100">
            <div class="modal-header border-0">
                <div class="d-inline-block rounded shadow-sm ms-auto bg-info">
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-0 tw-grid tw-grid-cols-12 tw-justify-center tw-items-end">
                <div class="tw-col-span-12 py-5 px-lg-5 px-4 popup_content" style="background: rgba(0,0,0,.85);">
                    <?php echo get_field('popup_heading', 'option'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>