<?php

function gform_register_admin_layout_checkbox($placement, $form_id)
{
    if ($placement == 50) {
        $options = ['List Group - Vertical', 'List Group - Horizontal'];

        $layout  = '<li class="label_placement_setting field_setting" style="">';
        $layout .= '<label for="field_label_placement" class="section_label">';
        $layout .= 'Select checkbox layout';
        $layout .= '</label>';
        $layout .= '<select id="field_layout">';

        foreach ($options as $option) {
            $option_val = strtolower(str_replace(' ', '_', $option));
            $layout .= '<option value="' . $option_val . '">';
            $layout .= $option;
            $layout .= '</option>';
        }

        $layout .= '</select>';
    }

    // echo $layout;
}
// add_action('gform_field_appearance_settings', 'gform_register_admin_layout_checkbox', 10, 2);
?>