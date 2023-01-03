<div class="inquiry">

<!--<div class="d-flex justify-content-center flex-row">-->

    <?php
    $price = get_price(get_field('post_product_gun_msrp'), 20);
    $price_formatted = formatMoney($price['discount_amount']);
    $month = date('F');

    if (isset($price_formatted) && $price_formatted !== "$0") {
        $lead = 'Save up to ' . $price_formatted . ' during our huge ' . $month .  ' safe sale!';
    } else {
        $lead = 'Save hundreds during our HUGE ' . $month . ' safe sale!';
    }

    $btn_text_options = array(
        "Get Pricing & Delivery Options",
        "Get Latest Sale Price",
    );
    $rand_text = rand(0, count($btn_text_options));
    $cta_text = !empty($btn_text_options[$rand_text]) ? $btn_text_options[$rand_text] : 'Get Pricing & Delivery Options';
    $btn_classes = "btn btn-primary bg-orange fw-700 text-uppercase border-1 d-block";
    ?>

    <div class="alert alert-primary rounded w-100 py-2" role="alert">
        <p class="font-source text-blue fw-600 fw-normal mb-0 text-center">
            <?php echo $lead; ?>
        </p>
    </div>

    <div class="row align-items-center justify-content-between mt-4 mb-5">

        <div class="col-md-5">
            <ul class="list-group list-group-flush  no-borders ms-0 lst-none bg-transparent cta-callouts d-none d-md-block">
                <li class="list-group-item bg-transparent py-1 no-border text-secondary">
                    <i class="fa-solid fa-tags text-blue me-2 fa-fw"></i>Lowest Prices
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary">
                    <i class="fa-solid fa-truck text-blue me-2 fa-fw"></i>Delivery Times
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary">
                    <i class="fa-solid fa-person-dolly text-blue me-2 fa-fw"></i>Installation Options
                </li>
            </ul>
            <ul class="list-group list-group-horizontal list-group-flush  no-borders ms-0 lst-none bg-transparent cta-callouts d-md-none mb-3">
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-tags text-blue text-center fa-fw"></i>
                    <p class="mb-0 text-secondary">Prices</p>
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-truck text-blue text-center fa-fw"></i>
                    <p class="mb-0 text-secondary">Delivery</p>
                </li>
                <li class="list-group-item bg-transparent py-1 no-border text-secondary text-center flex-fill">
                    <i class="fa-solid fa-person-dolly text-blue text-center fa-fw"></i>
                    <p class="mb-0 text-secondary">Installation</p>
                </li>
            </ul>
        </div>

        <div class="col-md-7">
            <?php echo get_product_inquiry_btn($post->ID, $cta_text, null, $btn_classes); ?>
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