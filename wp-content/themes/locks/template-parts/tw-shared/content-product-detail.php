<!-- New single-product template -->
<div class="bg-white">

    <?php
    do_shortcode('[gravityform id="1" title="false" description="false" ajax="false" tabindex="10"]');
    $product_data = get_product_attributes(get_the_ID(), false);
    $terms = get_the_terms(get_the_ID(), 'product_cat');
    $attr = get_product_attributes(get_the_ID());
    ?>


    <?php $attribute_badges = get_attribute_badges_for_safes(get_the_ID()); ?>

    <?php
    $product = wc_get_product(get_the_ID());

    if (! $product) {
        return;
    }
    ?>

    <!-- Container -->
    <div class="mx-auto container px-4 py-8 md:py-10 sm:px-6 sm:pt-10 sm:pb-24 lg:px-8">

        <!-- Breadcrumbs -->
        <nav aria-label="Breadcrumb" class="md:gap-x-8 lg:gap-x-16 pb-8 sm:pb-6">
            <?php echo output_breadcrumbs(get_queried_object()); ?>
        </nav>

        <!-- Content -->
        <div class="lg:grid lg:grid-cols-2 lg:items-stretch md:gap-x-8 lg:gap-x-16">
            <!-- <div class="lg:grid lg:grid-cols-2 lg:items-start md:gap-x-8 lg:gap-x-16"> -->

            <!-- Image gallery -->
            <?php get_template_part(
                'template-parts/product/content',
                'single-carousel-vertical',
                $product->get_gallery_image_ids()
            );
            ?>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:mt-16 sm:px-0 lg:mt-0">

                <div class="flex flex-col gap-y-4 sm:gap-y-6 mb-4 sm:mb-6">
                    <div id="product-header">
                        <!-- Title & description -->
                        <?php
                        get_template_part(
                            "template-parts/product/content",
                            "single-header",
                            $product_data
                        );
                        ?>
                    </div>
                    <div id="product-pricing">
                        <!-- Price -->
                        <?php
                        get_template_part(
                            "template-parts/product/content",
                            "single-price",
                            $product_data
                        );
                        ?>
                    </div>
                </div>

                <div class="flex flex-col gap-y-4 sm:gap-y-6 mb-4 sm:mb-6">
                    <div class="order-last sm:order-first" id="product-callouts">
                        <!-- Callouts -->
                        <?php
                        get_template_part(
                            "template-parts/product/content",
                            "callouts",
                            get_formatted_product_attribute_callouts($product_data['callouts'])
                        );
                        ?>
                    </div>
                    <div id="product-btns">
                        <!-- Btns -->
                        <?php
                        get_template_part("template-parts/product/content","cta-button",$product_data);
                        ?>
                    </div>
                </div>

                <!-- Modal -->
                <?php
                get_template_part(
                    "template-parts/product/content",
                    "modal",
                    $product_data
                );
                ?>


                <!-- Reviews -->
                <div class="mt-3 hidden">
                    <h3 class="sr-only">Reviews</h3>
                    <div class="flex justify-start gap-4">

                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary-500 w-5 h-auto fill-current hover:text-secondary-400"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary-500 w-5 h-auto fill-current hover:text-secondary-400"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary-500 w-5 h-auto fill-current hover:text-secondary-400"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary-500 w-5 h-auto fill-current hover:text-secondary-400"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" class="text-secondary-500 w-5 h-auto fill-current hover:text-secondary-400"
                                viewBox="0 0 16 16">
                                <path
                                    d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z" />
                            </svg>
                        </div>

                        <span class="text-slate-400 font-medium">4.7 out of 5 stars</span>
                    </div>

                </div>


                <div class="mt-10 flex">
                </div>

                <!-- Accordion -->
                <?php
                $accordion_args = [
                    'description' => $product_data['description_long'],
                    'table' => ''
                ];

                get_template_part('template-parts/product/content', 'single-accordion'); ?>

                <section aria-labelledby="details-heading" class="mt-12 hidden">
                    <h2 id="details-heading" class="sr-only">Additional details</h2>




                    <div class="divide-y divide-gray-200 border-t">
                        <?php
                        // product-attributes
                        // get_the_content()
                        // the_field('post_product_gun_long_description'); $post->post_excerpt;
                        //
                        $accordion_tabs = ['Safe Attributes', 'Detailed Specs', 'Overview'];
                        $i              = 1;
                        ?>

                        <?php foreach ($accordion_tabs as $accordion_tab): ?>
                            <?php $is_first = ($i === 1); ?>

                            <div>
                                <h3>
                                    <button type="button"
                                        class="group relative flex w-full items-center justify-between py-3 text-left bg-gray-100"
                                        aria-controls="disclosure-<?php echo $i; ?>"
                                        aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>">
                                        <span class="text-[1.15rem] font-semibold antialiased                                                                                    <?php echo $is_first ? 'text-brand-500' : 'text-gray-600'; ?>">
                                            <?php echo $accordion_tab; ?>
                                        </span>
                                        <span class="ml-6 flex items-center">
                                            <svg class="<?php echo $is_first ? 'hidden' : 'block'; ?> h-6 w-6 text-gray-700 group-hover:text-gray-700"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                            </svg>
                                            <svg class="<?php echo $is_first ? 'block' : 'hidden'; ?> h-6 w-6 text-brand-500 group-hover:text-brand-500"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                            </svg>
                                        </span>
                                    </button>
                                </h3>
                                <div class="prose prose-sm pb-6                                                        <?php echo $is_first ? '' : 'hidden'; ?>"
                                    id="disclosure-<?php echo $i; ?>">
                                    <?php
                                    if ($accordion_tab === 'Safe Attributes') {
                                        get_template_part('template-parts/tw/content', 'product-attributes', $args);
                                    }
                                    if ($accordion_tab === 'Detailed Specs') {
                                        echo get_the_content();
                                    }
                                    if ($accordion_tab === 'Detailed Specs') {
                                        echo get_field('post_product_gun_long_description');
                                        echo get_the_excerpt();
                                    }

                                    ?>
                                </div>
                            </div>

                            <?php $i++; ?>
                        <?php endforeach ?>
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>