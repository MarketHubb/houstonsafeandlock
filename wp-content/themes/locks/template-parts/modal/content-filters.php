<!-- Scrollable modal -->
<div class="modal" tabindex="-1" id="modal-safe-filters">
   <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Apply filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body pt-0">
            <?php echo output_safe_filters(); ?>
         </div>
         <div class="modal-footer d-grid grid-cols-2">
            <button type="button" class="btn btn-outline-secondary px-4" id="modal-reset">Reset</button>
            <button type="button" class="btn px-4 btn-primary" id="modal-apply" data-bs-dismiss="modal">Apply Filters</button>
         </div>
      </div>
   </div>
</div>