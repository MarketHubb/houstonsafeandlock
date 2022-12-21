<div class="mb-4">

    <div class="d-flex flex-row justify-content-between align-middle">

        <div class="button-container d-inline-block">
            <?php $price = get_price(get_field('post_product_gun_msrp'), 20); ?>
            <p class="lead fw-600 mb-4">
                Limited time offer - Save <?php echo formatMoney($price['discount_amount']); ?>
            </p>
            <?php
            $btn_text_options = array(
                "Get Pricing & Delivery Options",
                "Get Latest Sale Price",
            );
            $rand_text = rand(0, count($btn_text_options));
            $cta_text = !empty($btn_text_options[$rand_text]) ? $btn_text_options[$rand_text] : 'Get Pricing & Delivery Options';
            ?>
            <?php $btn_classes = "btn btn-primary bg-orange border-1 d-block"; ?>
            <?php echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_classes); ?>
        </div>

        <div class="safe-cta d-inline-block">
            <ul class="list-group list-group-flush no-borders ms-0 lst-none bg-transparent cta-callouts">
                <li class="list-group-item bg-transparent lh-sm  no-border text-secondary">
                    <i class="fa-solid fa-tags text-blue me-2 fa-fw"></i>Sale Price
                </li>
                <li class="list-group-item bg-transparent lh-sm  no-border text-secondary">
                    <i class="fa-solid fa-truck text-blue me-2 fa-fw"></i>Delivery Times
                </li>
                <li class="list-group-item bg-transparent lh-sm  no-border text-secondary">
                    <i class="fa-solid fa-person-dolly text-blue me-2 fa-fw"></i>Installation Options
                </li>
            </ul>
        </div>

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

