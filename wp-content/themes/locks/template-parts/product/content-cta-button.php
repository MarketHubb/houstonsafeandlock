<?php if (! isset($args)) return; ?>

<?php
$product = wc_get_product(get_the_ID())->get_gallery_image_ids() ?? null;
$image_src = $product
    ? wp_get_attachment_image_url($product[0], 'full')
    : '';
$title = get_product_attribute_brand_and_model($args)['title'] ?? '';
$product_name = get_product_attribute_brand_and_model($product_attributes);
$btn_text = !empty($product_name['title'])
    ? $product_name['title']
    : get_the_title($args['post_id']);
?>
<div class="flex flex-col sm:flex-row gap-4 my-6 product-cta-buttons">
    <button
        type="button"
        class="flex flex-1 items-center justify-center rounded-md border border-transparent bg-secondary-500/95 px-8 py-3 text-base font-semibold antialiased text-white hover:bg-secondary-500 focus:ring-2 focus:bg-secondary-600 focus:ring-offset-2 focus:ring-offset-gray-50 focus:outline-hidden sm:w-full"
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="hs-full-screen-modal-below-md"
        data-hs-overlay="#hs-full-screen-modal-below-md"
        data-title="<?php echo $title; ?>"
        data-callout="Contact our team to place an order today"
        data-image="<?php echo $image_src; ?>">
        Order now
    </button>

    <button
        type="button"
        class="flex flex-1 items-center justify-center px-3 py-3 gap-x-2 text-sm font-semibold antialiased rounded-lg border border-gray-200 text-gray-500 hover:border-gray-400 hover:text-gray-700 focus:outline-none focus:border-blue-600 focus:text-blue-600"
        aria-haspopup="dialog"
        aria-expanded="false"
        aria-controls="hs-full-screen-modal-below-md"
        data-hs-overlay="#hs-full-screen-modal-below-md"
        data-title="<?php echo $title; ?>"
        data-callout="Contact our team to place an order today"
        data-image="<?php echo $image_src; ?>">
        Contact our team
    </button>
</div>