<div class="mb-4">

    <div class="safe-price">
        <?php $price = get_price(get_field('post_product_gun_msrp'), 20); ?>
        <h3 class="fs-1 d-inline-block mb-0">$<?php echo $price['sale_price']; ?></h3>
        <h3 class="fs-3 text-secondary mb-0 d-inline-block text-decoration-line-through ps-3">$<?php echo $price['msrp']; ?></h3>
        <span class="badge bg-secondary sale ms-4">20% Off</span>
    </div>

    <div class="safe-cta my-4 py-3">
        <div class="button-container mb-4">
            <?php
            $rand_text = rand(0, 2);
            $cta_text_array = array(
                "Get Delivery Times",
                "Product Inquiry",
                "Delivery Times & Production Information"
            );
            $cta_text = !empty($cta_text_array[$rand_text]) ? $cta_text_array[$rand_text] : 'Product Inquiry';
            ?>
            <?php $btn_classes = "btn btn-primary bg-orange d-block border-1"; ?>
            <?php echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_classes); ?>
        </div>
        <ul class="list-group list-group-horizontal list-group-flush no-borders ms-0 lst-none bg-transparent cta-callouts">
            <li class="list-group-item bg-transparent lh-sm  no-border text-secondary ps-0">
                <i class="fa-solid fa-check me-1"></i>Delivery Times
            </li>
            <li class="list-group-item bg-transparent lh-sm  no-border text-secondary">
                <i class="fa-solid fa-check me-1"></i>Product Features
            </li>
            <li class="list-group-item bg-transparent lh-sm  no-border text-secondary">
                <i class="fa-solid fa-check me-1"></i>Chat with Experts
            </li>
        </ul>
    </div>

    <div class="warranty my-4">
        <p class="small fw-600 bg-grey border border-1 border rounded px-2 d-inline">Warranty</p>
        <ul class="list-group list-group-flush list-group-horizontal no-border ms-0 ps-0 mt-1">
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

