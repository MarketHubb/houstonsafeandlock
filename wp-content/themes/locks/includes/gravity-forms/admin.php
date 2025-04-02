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



</button> </label>

<option value="">Visible (Left aligned)</option>
<option value="hidden_label">Hidden</option>
</select>
<div id="field_description_placement_container" style="display:none;">
    <label for="field_description_placement" class="section_label">
        Description Placement <button onclick="return false;" onkeypress="return false;" class="gf_tooltip tooltip tooltip_form_field_description_placement" aria-label="<strong>Description Placement</strong>Select the description placement.  Descriptions can be placed above the field inputs or below the field inputs.">
            <i class="gform-icon gform-icon--question-mark" aria-hidden="true"></i>
        </button> </label>
    <select id="field_description_placement" onchange="SetFieldDescriptionPlacement(jQuery(this).val());">
        <option value="">Use Form Setting (Below inputs)</option>
        <option value="below">Below inputs</option>
        <option value="above">Above inputs</option>
    </select>
</div>
</li>