<!-- Modal -->
<div class="modal fade" id="popupModal" tabindex="-1" aria-labelledby="popupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
                <button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            <div class="modal-body p-0">
                <img src="<?php echo get_field('popup_image', 'option')['url']; ?>" alt="">
                <a href="<?php echo get_field('sale_link_page', 'option'); ?>" type="button" class="btn btn-primary bg-orange fw-600 rounded-0 border-0 text-white shadow-sm font-lg font-source w-100">
                    <?php echo get_field('sale_link_copy', 'option'); ?>
                </a>
            </div>

        </div>
    </div>
</div>
