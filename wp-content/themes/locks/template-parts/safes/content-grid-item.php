<?php $attributes = $args; ?>

<?php
if ($attributes) {
    $attribute_list = '<ul class="product-details-list lst-none">';

    foreach ($attributes as $attribute) {
        $val = get_safe_attribute_values($post->ID, $attribute);
        $attr_clean = strtolower(str_replace(' ', '_', $attribute));

        $attribute_list .= '<li class="' . $attr_clean . '">';
        $attribute_list .= '<span class="badge text-secondary attribute-label ' . $attribute . ' text-right">';
        $attribute_list .=  get_formatted_attributes($attribute)['name'] . ':</strong></span>';
        $attribute_list .= '<span class="product-detail-value">';
        $attribute_list .= $val['formatted'] . '</span>';

        if ($attr_clean === 'msrp') {
            $attribute_list .= '<span class="badge bg-primary sale ms-4">20% Off</span>';
        }

        $attribute_list .= '</li>';
    }
    $attribute_list .= '</ul>';
    echo $attribute_list;
}
?>

