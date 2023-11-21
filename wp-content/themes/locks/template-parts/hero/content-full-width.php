<?php if ($args) { ?>
    <div class="hero-full-width" style="background-image: url(<?php echo $args['hero_background_image']; ?>);">
        
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7">

                    <?php if ($args['hero_heading']) { ?>
                        <h1><?php echo $args['hero_heading']; ?></h1>
                    <?php } ?>

                    <?php if ($args['hero_description']) { ?>
                        <p class="lead"><?php echo $args['description']; ?></p>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

<?php } ?>
