<?php
$related_ids = get_related_safe_products(get_the_ID());

if (!empty($related_ids)) : ?>
    <div class="container mx-auto px-4 py-12">
        <h2 class="text-2xl font-bold mb-6">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($related_ids as $product_id) :
                $product = wc_get_product($product_id);
                if (!$product) continue;

                $image_id = $product->get_image_id();
                $image_url = wp_get_attachment_image_url($image_id, 'medium');
                $placeholder_image = wc_placeholder_img_src('medium');
            ?>

                <a class="flex flex-col bg-white border shadow-sm rounded-xl hover:shadow-lg focus:outline-none focus:shadow-lg transition py-4 px-2 sm:px-3 sm:py-6 !no-underline"
                    href="<?php echo get_permalink($product_id); ?>">
                    <img class=" rounded-t-xl aspect-square masx-h-24 sm:max-h-36 w-auto object-contain"
                        src="<?php echo $image_url ?: $placeholder_image; ?>"
                        alt="<?php echo esc_attr($product->get_name()); ?>">
                    <div class="p-4 md:p-5">
                        <h3 class="text-lg font-bold text-gray-800">
                            <?php echo $product->get_name(); ?>
                        </h3>
                        <p class="mt-1 text-gray-500">
                            <?php
                            $description = esc_html(get_product_attribute_description_long(get_the_ID()));
                            $description = $description ?? wp_strip_all_tags($product->get_short_description());

                            echo wp_trim_words($description, 15, '...');
                            ?>
                        </p>
                        <div class="mt-3 font-bold text-primary">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>