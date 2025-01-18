<!-- Description -->

<div class="mb-8">
    <h3 class="sr-only">Description</h3>

    <?php if (get_field("post_product_gun_long_description")): ?>

        <div class="space-y-6 text-base text-gray-700 mb-6">
            <p>
                <?php echo get_field("post_product_gun_long_description"); ?>
            </p>
        </div>
        
    <?php endif ?>

</div>