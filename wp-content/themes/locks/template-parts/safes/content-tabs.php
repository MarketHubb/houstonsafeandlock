
<ul class="nav nav-tabs nav-fill lst-none ps-0 ms-0" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-600 active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-600 " id="attributes-tab" data-bs-toggle="tab" data-bs-target="#attributes" type="button" role="tab" aria-controls="attributes" aria-selected="false">Attributes</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link fw-600" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab" aria-controls="specs" aria-selected="false">Specs</button>
    </li>
</ul>
<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <?php if (get_field('post_product_gun_long_description')) { ?>
            <p><?php the_field('post_product_gun_long_description'); ?></p>
        <?php } ?>
        <div class="post-excerpt bullets mt-4 pt-4">
            <?php echo $post->post_excerpt; ?>
        </div>
    </div>

    <div class="tab-pane fade " id="attributes" role="tabpanel" aria-labelledby="home-tab">
        <?php get_template_part('template-parts/safes/content', 'warranty'); ?>
        <?php get_template_part('template-parts/safes/content', 'attributes'); ?>
    </div>

    <div class="tab-pane fade" id="specs" role="tabpanel" aria-labelledby="contact-tab">
        <?php echo get_the_content(); ?>
    </div>
</div>