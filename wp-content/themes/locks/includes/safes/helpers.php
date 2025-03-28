<?php
function is_safe_parent_page()
{
    return get_queried_object_id() === 3901;
}

function is_safe_tax_page()
{
    return is_tax('product_cat');
}
// region Content
function remove_safes_from_string($string)
{
    return trim(str_replace("Safes", "", $string));
}
// endregion

// region Attributes
function is_safe_rated(string $attribute_value)
{
    if (empty($attribute_value)) return null;

    if (!str_contains('not rated', strtolower($attribute_value))) {
        return $attribute_value;
    }

    return false;
}
// endregion

// region Strings
function replace_space_with_underscore($string)
{
    return trim(str_replace(' ', '_', $string));
}
// endregion