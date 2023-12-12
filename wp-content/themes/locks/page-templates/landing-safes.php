<?php

/* Template Name: Landing - Safes */

get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php 
        $include_hero = get_field('include_hero');
        
        $hero_inputs = get_field('hero');
        
        highlight_string("<?php\n\$hero_inputs =\n" . var_export($hero_inputs, true) . ";\n?>");

        if ($hero_inputs) {
            get_template_part('template-parts/hero/content', 'full-width', $hero_inputs);
        }

        ?>

    </main>
</div>


<?php get_footer(); ?>

