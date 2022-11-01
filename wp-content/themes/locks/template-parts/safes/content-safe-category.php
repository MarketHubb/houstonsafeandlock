<?php $cat_id = $args['cat_id']; ?>
<?php $attributes = $args['attributes']; ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if (!$attributes) {
            $attributes=['weight', 'fire-rating', 'exterior-depth', 'exterior-width', 'exterior-height'];
        } ?>

        <?php get_template_part('template-parts/safes/content', 'grid-sort', ['attributes' => $attributes]); ?>

        <?php get_template_part('template-parts/safes/content', 'grid-list', ['cat_id' => $cat_id, 'attributes' => $attributes]); ?>


    </main>
</div>
