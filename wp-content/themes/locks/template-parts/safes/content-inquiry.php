<div class="inquiry">

<!--<div class="d-flex justify-content-center flex-row">-->

    <?php
    $sale_copy = get_sale_copy_clean($post->ID);

    $btn_text_options = array(
        "Get Pricing & Delivery Options",
        "Get Current Sale Price",
    );
    $rand_text = rand(0, count($btn_text_options));
    $cta_text = !empty($btn_text_options[$rand_text]) ? $btn_text_options[$rand_text] : 'Get Pricing & Delivery Options';
    $btn_classes = "d-none d-md-block btn btn-primary bg-orange fw-600 rounded-pill shadow font-lg font-source border-1 w-100";
    $btn_mobile_classes = "d-block d-md-none w-100 btn btn-primary bg-orange fw-600 rounded-pill  border-1 d-block font-source";
    ?>

    <div class="alert alert-primary rounded w-100 py-2" role="alert">
        <p class="font-source text-blue fw-600 fw-normal mb-0 text-center">
            <?php echo $sale_copy; ?>
        </p>
    </div>

    <div class="row align-items-center justify-content-between mt-4 mb-5">

        <div class="col-lg-5 d-none d-lg-block">
            <ul class="list-group list-group-flush no-borders ms-0 my-3 lst-none bg-transparent cta-callouts">
                <li class="list-group-item bg-transparent py-1  no-border ps-0 text-secondary">
                    <i class="fa-solid fa-tags text-blue me-3  fa-fw"></i>Latest Sale Price
                </li>
                <li class="list-group-item bg-transparent py-1  no-border ps-0 text-secondary">
                    <i class="fa-solid fa-truck text-blue me-3  fa-fw"></i>Delivery Times
                </li>
                <li class="list-group-item bg-transparent py-1  no-border ps-0 text-secondary">
                    <i class="fa-solid fa-person-dolly text-blue me-3  fa-fw"></i>Installation Options
                </li>
            </ul>
            <ul class="list-group list-group-horizontal list-group-flush  no-borders ms-0 lst-none bg-transparent cta-callouts d-md-none mb-3">
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-truck text-blue text-center fa-fw"></i>
                    <p class="lh-1 mb-0">DELIVERY</p>
                    <p class="mb-0 text-secondary">Times</p>
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-tags text-blue text-center fa-fw"></i>
                    <p class="lh-1 mb-0">SALE</p>
                    <p class="mb-0 text-secondary">Prices</p>
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-person-dolly text-blue text-center fa-fw"></i>
                    <p class="lh-1 mb-0">SETUP</p>
                    <p class="mb-0 text-secondary">Options</p>
                </li>
            </ul>
        </div>

        <div class="col-md-12 col-lg-7">
            <?php echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_classes); ?>
            <?php echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_mobile_classes); ?>
        </div>



    </div>

<!--            <div class="col-md-7 button-container d-inline-block d-none">-->
<!--                --><?php //$price = get_price(get_field('post_product_gun_msrp'), 20); ?>
<!--                <p class="lead fw-600 mb-4">-->
<!--                    Limited time offer - Save --><?php //echo formatMoney($price['discount_amount']); ?>
<!--                </p>-->
<!--                --><?php //echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_classes); ?>
<!---->
<!--            </div>-->

<!--            <div class="col-md-5 safe-cta d-inline-block">-->
<!--                <ul class="list-group list-group-flush no-borders ms-0 lst-none bg-transparent cta-callouts">-->
<!--                    <li class="list-group-item bg-transparent py-1 no-border text-secondary">-->
<!--                        <i class="fa-solid fa-tags text-blue me-2 fa-fw"></i>Sale Price-->
<!--                    </li>-->
<!--                    <li class="list-group-item bg-transparent py-1 no-border text-secondary">-->
<!--                        <i class="fa-solid fa-truck text-blue me-2 fa-fw"></i>Delivery Times-->
<!--                    </li>-->
<!--                    <li class="list-group-item bg-transparent py-1 no-border text-secondary">-->
<!--                        <i class="fa-solid fa-person-dolly text-blue me-2 fa-fw"></i>Installation Options-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
</div>