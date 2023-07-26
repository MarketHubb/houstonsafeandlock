<?php if (get_field('content_below', get_queried_object())) { ?>

    <div class="row">
        <div class="col-md-12">
            <?php echo get_field('content_below', get_queried_object()); ?>
        </div>
    </div>

<?php } ?>
