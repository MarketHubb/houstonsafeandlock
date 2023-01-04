<?php
$post_id = get_the_ID();
if( have_rows('attributes', 'option') ):
    $attributes = '<div class="row attributes">';

    while ( have_rows('attributes', 'option') ) : the_row();
        $label = get_sub_field('attribute', 'option');

        if ($label === 'Type') {
            $safe_type = get_safe_type_attributes($post_id);
        } else {
            $field_name = get_sub_field('acf_field', 'option');
            $formatted_field_name = str_replace('post_product_gun_', '', $field_name);
            $safe_type['attribute_label'] = $label;
            $safe_type['attribute_value'] = get_safe_attribute_values($post_id, $formatted_field_name)['formatted'];
            $safe_type['attribute_image'] = get_sub_field('icon', 'option');
        }

        if ($label === 'Manufacturer') {
            $safe_type['attribute_image'] = return_manufacturer_attributes_logo(get_the_ID());
        }

        $attributes .= '<div class="col-6 col-md-4 mb-4">';
        $attributes .= '<div class="card text-center h-100">';
        $attributes .= '<div class="card-header">';
        $attributes .= '<p class="fw-normal mb-0">' . $safe_type['attribute_label'] . '</p>';
        $attributes .= '</div>';
        $attributes .= '<div class="card-body text-center pt-4 pb-3 ">';
        $attributes .= '<img src="' . $safe_type['attribute_image'] . '"  class="attribute-icons mb-2 text-secondary" />';
        $attributes .= '<p class="lead fw-600 mb-0 anti ' . strtolower(str_replace(' ', '_', $safe_type['attribute_label'])) .  '">' . $safe_type['attribute_value'] . '</p>';
        $attributes .= '</div></div></div>';

    endwhile;

    $attributes .= '</div>';
    echo $attributes;

endif;
?>
