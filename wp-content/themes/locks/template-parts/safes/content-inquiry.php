<div class="mb-4">

    <div class="safe-price">
        <?php $price = get_price(get_field('post_product_gun_msrp'), 20); ?>
        <h3 class="fs-1 d-inline-block mb-0">$<?php echo $price['sale_price']; ?></h3>
        <h3 class="fs-3 text-secondary mb-0 d-inline-block text-decoration-line-through ps-3">$<?php echo $price['msrp']; ?></h3>
        <span class="badge bg-secondary sale ms-4">20% Off</span>
    </div>

    <div class="safe-cta my-4 py-3">
        <?php echo get_product_inquiry_btn($post->ID, 'Get Delivery Times'); ?>
    </div>

    <div class="warranty my-4">
        <p class="small fw-600 bg-grey border border-1 border rounded px-2 d-inline">Warranty</p>
        <ul class="list-group list-group-flush list-group-horizontal no-border ms-0 ps-0">
            <?php $warranty_items = get_warranty_information(get_the_ID()); ?>
            <?php foreach ($warranty_items as $key => $val) { ?>
                <li class="list-group-item flex-fill no-border ps-0 py-0 bg-transparent">
                    <p class="small fw-600 d-inline"><?php echo $key; ?>:</p>
                    <p class="small d-block d-md-inline"><?php echo $val; ?></p>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

