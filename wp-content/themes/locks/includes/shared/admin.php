<?php 
// Disable full-screen editor
if (is_admin()) {
    function pa_disable_fullscreen_wp_editor()
    {
        $script = "jQuery( window ).load(function() { const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' ); if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); } });";
        wp_add_inline_script('wp-blocks', $script);
    }
    add_action('enqueue_block_editor_assets', 'pa_disable_fullscreen_wp_editor');
}

function meks_which_template_is_loaded()
{
    if (is_super_admin()) {
        global $template;
        highlight_string("<?php\n\$template =\n" . var_export($template, true) . ";\n?>");
    }
}

add_action('wp_footer', 'meks_which_template_is_loaded');
