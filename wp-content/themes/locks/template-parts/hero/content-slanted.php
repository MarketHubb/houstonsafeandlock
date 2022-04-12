<?php
$image = get_query_var('bg_image') ?: get_home_url() . '/wp-content/uploads/2016/09/hotDealsHeader.jpg';
$heading = $args['heading'];
$description = $args['description'];
?>
<div class="container-fixed">
</div>
<div id="header-hero"
     style="background-image: url(<?php echo $image; ?>);">
    <div class="container-straight">
        <div class="container-fixed">
            <?php if ($heading){ ?>
                <h1 class="test"><?php echo $heading; ?></h1>
            <?php } ?>
            <?php if ($description){ ?>
                <h1 class="test"><?php echo $description; ?></h1>
            <?php } ?>
        </div>
    </div>
</div>
