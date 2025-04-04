<?php

/**
 * Get minimum and maximum values for an ACF field
 *
 * Retrieves the minimum and maximum values for a specified ACF field across all products.
 * Includes special handling for price fields that may contain currency symbols.
 *
 * @param string $acf_field_name The ACF field name to query
 * @param string $post_type The post type to query (default: 'product')
 * @param string $post_status The post status to query (default: 'publish')
 * @param array $post_ids Optional array of post IDs to limit the query to specific posts
 * @return array An associative array with 'min' and 'max' keys
 */
function get_acf_meta_min_max_legacy($acf_field_name, $post_type = 'product', $post_status = 'publish', $post_ids = [])
{
    global $wpdb;

    // Build the base WHERE clause
    $where_clauses = [
        "pm.meta_key = %s",
        "pm.meta_value != ''",
        "pm.meta_value IS NOT NULL"
    ];

    // Prepare query parameters
    $query_params = [$acf_field_name];

    // If post_ids is provided and not empty, use it instead of post_type
    if (!empty($post_ids) && is_array($post_ids)) {
        // Convert array of IDs to comma-separated string for IN clause
        $placeholders = implode(',', array_fill(0, count($post_ids), '%d'));
        $where_clauses[] = "p.ID IN ($placeholders)";

        // Add each post ID as a parameter
        foreach ($post_ids as $id) {
            $query_params[] = $id;
        }
    } else {
        // Use post_type and post_status filtering
        $where_clauses[] = "p.post_type = %s";
        $where_clauses[] = "p.post_status = %s";
        $query_params[] = $post_type;
        $query_params[] = $post_status;
    }

    // Combine WHERE clauses
    $where_clause = implode(' AND ', $where_clauses);

    // Special handling for price field which may contain currency symbols
    if ($acf_field_name === 'post_product_gun_price') {
        // For price fields, we need to clean the data before calculating min/max
        $query = $wpdb->prepare(
            "SELECT
                pm.meta_value
            FROM
                {$wpdb->postmeta} pm
            JOIN
                {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE
                $where_clause",
            ...$query_params
        );

        $results = $wpdb->get_results($query);

        if (empty($results)) {
            return [
                'min' => 0,
                'max' => 1000 // Default max price
            ];
        }

        $prices = [];
        foreach ($results as $result) {
            // Remove currency symbols and any non-numeric characters except decimal point
            $clean_price = preg_replace('/[^0-9.]/', '', $result->meta_value);

            if (is_numeric($clean_price)) {
                $prices[] = (float)$clean_price;
            }
        }

        if (empty($prices)) {
            return [
                'min' => 0,
                'max' => 1000 // Default max price
            ];
        }

        $min = min($prices);
        $max = max($prices);
    } else {
        // Standard handling for regular ACF fields
        $query = $wpdb->prepare(
            "SELECT
                MIN(CAST(pm.meta_value AS DECIMAL(10,2))) as min_value,
                MAX(CAST(pm.meta_value AS DECIMAL(10,2))) as max_value
            FROM
                {$wpdb->postmeta} pm
            JOIN
                {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE
                $where_clause",
            ...$query_params
        );

        $result = $wpdb->get_row($query);

        // Default values if no results
        $min = 0;
        $max = 100;

        if ($result && is_numeric($result->min_value) && is_numeric($result->max_value)) {
            $min = (float)$result->min_value;
            $max = (float)$result->max_value;
        }
    }

    // Ensure min and max are different to avoid slider issues
    if ($min === $max) {
        $max += 1;
    }

    return [
        'min' => $min,
        'max' => $max
    ];
}

/**
 * Get minimum and maximum values for an ACF field
 *
 * @param string $acf_field_name The ACF field name to query
 * @param string $post_type The post type to query (default: 'product')
 * @param string $post_status The post status to query (default: 'publish')
 * @param array $post_ids Optional array of post IDs to limit the query to specific posts
 * @return array An associative array with 'min' and 'max' keys
 */
function get_acf_meta_min_max_c($acf_field_name, $post_type = 'product', $post_status = 'publish', $post_ids = [])
{
    global $wpdb;

    // Start with default values
    $min = 0;
    $max = 100;

    // First, let's get all the raw values to see what we're working with
    $sql_params = [$acf_field_name];

    if (!empty($post_ids) && is_array($post_ids)) {
        // Use specific post IDs
        $id_placeholders = implode(',', array_fill(0, count($post_ids), '%d'));
        $sql = "
            SELECT pm.meta_value
            FROM {$wpdb->postmeta} pm
            JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = %s
            AND p.ID IN ($id_placeholders)
        ";

        // Add post IDs to parameters
        foreach ($post_ids as $id) {
            $sql_params[] = $id;
        }
    } else {
        // Use post type and status - FIXED: 'publish' not 'published'
        $sql = "
            SELECT pm.meta_value
            FROM {$wpdb->postmeta} pm
            JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = %s
            AND p.post_type = %s
            AND p.post_status = %s
        ";
        $sql_params[] = $post_type;
        $sql_params[] = $post_status; // This should be 'publish'
    }

    // Execute the query
    $query = $wpdb->prepare($sql, $sql_params);
    $results = $wpdb->get_results($query);

    // Debug information
    error_log("Query: " . $wpdb->last_query);
    error_log("Number of results: " . count($results));

    // If we have results, process them
    if (!empty($results)) {
        $numeric_values = [];

        foreach ($results as $result) {
            // Clean the value and check if it's numeric
            $value = trim($result->meta_value);

            // For price fields, remove currency symbols
            if ($acf_field_name === 'post_product_gun_price') {
                $value = preg_replace('/[^0-9.]/', '', $value);
            }

            // Only use values that can be converted to numbers
            if (is_numeric($value)) {
                $numeric_values[] = (float)$value;
            }
        }

        error_log("Numeric values found: " . count($numeric_values));
        if (!empty($numeric_values)) {
            error_log("Sample values: " . implode(', ', array_slice($numeric_values, 0, 5)));
        }

        // If we have numeric values, calculate min and max
        if (!empty($numeric_values)) {
            $min = min($numeric_values);
            $max = max($numeric_values);

            error_log("Calculated min: $min, max: $max");
        } else {
            error_log("No numeric values found among the results");
        }
    } else {
        error_log("No results returned from the database");
    }

    // Ensure min and max are different
    if ($min === $max) {
        $max += 1;
    }

    return [
        'min' => $min,
        'max' => $max
    ];
}


/**
 * Get minimum and maximum values for an ACF field.
 *
 * Retrieves the minimum and maximum values for a specified ACF field across all products.
 * When an empty array of $post_ids is passed, this version uses LEFT JOIN (with COALESCE for non-price fields)
 * so that posts without meta values are included.
 *
 * @param string $acf_field_name The ACF field name to query.
 * @param string $post_type      The post type to query (default: 'product').
 * @param string $post_status    The post status to query (default: 'publish').
 * @param array  $post_ids       Optional array of post IDs to limit the query to specific posts.
 * @return array                 An associative array with 'min' and 'max' keys.
 */
function get_acf_meta_min_max($acf_field_name, $post_type = 'product', $post_status = 'publish', $post_ids = [])
{
    global $wpdb;

    // If specific post IDs are provided, use an INNER JOIN
    if (!empty($post_ids) && is_array($post_ids)) {
        $where_clauses = [
            "pm.meta_key = %s",
            "pm.meta_value != ''",
            "pm.meta_value IS NOT NULL"
        ];
        $query_params = [$acf_field_name];

        // Build placeholders for the post IDs and add to the query
        $placeholders = implode(',', array_fill(0, count($post_ids), '%d'));
        $where_clauses[] = "p.ID IN ($placeholders)";
        foreach ($post_ids as $id) {
            $query_params[] = $id;
        }

        $where_clause = implode(' AND ', $where_clauses);

        if ($acf_field_name === 'post_product_gun_price') {
            // Special handling for price fields that may contain currency symbols
            $query = $wpdb->prepare(
                "SELECT pm.meta_value
                FROM {$wpdb->postmeta} pm
                JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE $where_clause",
                ...$query_params
            );
            $results = $wpdb->get_results($query);

            if (empty($results)) {
                return [
                    'min' => 0,
                    'max' => 1000 // Default max price
                ];
            }

            $prices = [];
            foreach ($results as $result) {
                // Remove any non-numeric characters (except decimal point)
                $clean_price = preg_replace('/[^0-9.]/', '', $result->meta_value);
                if (is_numeric($clean_price)) {
                    $prices[] = (float)$clean_price;
                }
            }

            if (empty($prices)) {
                return [
                    'min' => 0,
                    'max' => 1000
                ];
            }

            $min = min($prices);
            $max = max($prices);
        } else {
            // Standard handling for non-price fields with an INNER JOIN
            $query = $wpdb->prepare(
                "SELECT
                    MIN(CAST(pm.meta_value AS DECIMAL(10,2))) as min_value,
                    MAX(CAST(pm.meta_value AS DECIMAL(10,2))) as max_value
                FROM {$wpdb->postmeta} pm
                JOIN {$wpdb->posts} p ON p.ID = pm.post_id
                WHERE $where_clause",
                ...$query_params
            );
            $result = $wpdb->get_row($query);

            // Set default values
            $min = 0;
            $max = 100;

            if ($result && is_numeric($result->min_value) && is_numeric($result->max_value)) {
                $min = (float)$result->min_value;
                $max = (float)$result->max_value;
            }
        }
    } else {
        // When no specific post IDs are provided, use LEFT JOIN to include all posts
        if ($acf_field_name === 'post_product_gun_price') {
            // For price fields, select all posts even if they don't have a price saved
            $query = $wpdb->prepare(
                "SELECT pm.meta_value
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->postmeta} pm
                    ON (p.ID = pm.post_id AND pm.meta_key = %s)
                WHERE p.post_type = %s AND p.post_status = %s",
                $acf_field_name,
                $post_type,
                $post_status
            );
            $results = $wpdb->get_results($query);

            if (empty($results)) {
                return [
                    'min' => 0,
                    'max' => 1000
                ];
            }

            $prices = [];
            foreach ($results as $result) {
                $clean_price = preg_replace('/[^0-9.]/', '', $result->meta_value);
                if (is_numeric($clean_price)) {
                    $prices[] = (float)$clean_price;
                }
            }

            if (empty($prices)) {
                return [
                    'min' => 0,
                    'max' => 1000
                ];
            }

            $min = min($prices);
            $max = max($prices);
        } else {
            // For non-price fields, use LEFT JOIN and COALESCE to include posts missing the meta value
            $query = $wpdb->prepare(
                "SELECT
                    MIN(CAST(COALESCE(pm.meta_value, 0) AS DECIMAL(10,2))) as min_value,
                    MAX(CAST(COALESCE(pm.meta_value, 0) AS DECIMAL(10,2))) as max_value
                FROM {$wpdb->posts} p
                LEFT JOIN {$wpdb->postmeta} pm
                    ON (p.ID = pm.post_id AND pm.meta_key = %s)
                WHERE p.post_type = %s AND p.post_status = %s",
                $acf_field_name,
                $post_type,
                $post_status
            );
            $result = $wpdb->get_row($query);

            // Default values
            $min = 0;
            $max = 100;

            if ($result && is_numeric($result->min_value) && is_numeric($result->max_value)) {
                $min = (float)$result->min_value;
                $max = (float)$result->max_value;
            }
        }
    }

    // Ensure that min and max are not the same to avoid slider issues
    if ($min === $max) {
        $max += 1;
    }

    return [
        'min' => $min,
        'max' => $max
    ];
}


/**
 * Get min/max ranges for multiple product attributes
 *
 * Retrieves minimum and maximum values for multiple product attributes.
 * Uses transient caching to improve performance.
 *
 * @param array $attributes An array of attribute keys and their corresponding ACF field names
 * @return array An associative array of attribute keys with their min/max values
 */
function get_product_attribute_ranges(array $attributes, mixed $post_ids = null)
{
    // Try to get from transient first
    // $ranges = get_transient('product_filter_ranges');
    $ranges = false;

    // If not in transient, calculate and store
    if ($ranges === false) {
        $ranges = [];

        foreach ($attributes as $attribute_key => $acf_field_name) {
            $post_type = 'product';
            $post_status = 'published';
            $post_ids = is_array($post_ids) && !empty($post_ids)
                ? $post_ids
                : [];


            $ranges[$attribute_key] = get_acf_meta_min_max($acf_field_name, $post_type, $post_status, $post_ids);
        }

        // set_transient('product_filter_ranges', $ranges, 12 * HOUR_IN_SECONDS);
    }

    return $ranges;
}

/**
 * Clear the product ranges transient cache
 *
 * Deletes the cached product attribute ranges when a product is updated,
 * ensuring that filter values stay current.
 *
 * @param int $post_id The ID of the post being saved/updated
 * @return void
 */
function clear_product_ranges_cache($post_id)
{
    if (get_post_type($post_id) === 'product') {
        delete_transient('product_filter_ranges');
    }
}
// add_action('save_post', 'clear_product_ranges_cache');
// add_action('deleted_post', 'clear_product_ranges_cache');
// add_action('acf/save_post', 'clear_product_ranges_cache');

/**
 * Add product attribute ranges to the page as JavaScript variables
 *
 * Outputs the min/max ranges for product attributes as a JavaScript variable
 * that can be used to initialize sliders and other filter UI elements.
 *
 * @return void
 */
function add_product_ranges_to_page()
{
    // Only add on relevant pages
    if (!is_page('your-product-page') && !is_post_type_archive('product')) {
        return;
    }

    // Define your attributes and their corresponding meta keys
    $product_attributes = [
        'weight' => 'post_product_gun_weight',
        'price' => 'post_product_gun_price',
        // Add more as needed
    ];

    $ranges = get_product_attribute_ranges($product_attributes);

    echo '<script>
        const productRanges = ' . json_encode($ranges) . ';
    </script>';
}
add_action('wp_footer', 'add_product_ranges_to_page');


/**
 * Get all unique values for an ACF field
 *
 * @param string $acf_field_name The ACF field name
 * @param string $post_type The post type to query (default: 'product')
 * @param string $post_status The post status to query (default: 'publish')
 * @return array An array of unique values sorted alphabetically/numerically
 */
function get_acf_unique_values($acf_field_name, $post_type = 'product', $post_status = 'publish')
{
    global $wpdb;

    // Special handling for price field which may contain currency symbols
    if ($acf_field_name === 'post_product_gun_price') {
        // For price fields, we need to clean the data before getting unique values
        $query = $wpdb->prepare(
            "SELECT
                pm.meta_value
            FROM
                {$wpdb->postmeta} pm
            JOIN
                {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE
                pm.meta_key = %s
                AND p.post_type = %s
                AND p.post_status = %s
                AND pm.meta_value != ''
                AND pm.meta_value IS NOT NULL",
            $acf_field_name,
            $post_type,
            $post_status
        );

        $results = $wpdb->get_results($query);

        if (empty($results)) {
            return [];
        }

        $unique_values = [];
        foreach ($results as $result) {
            // Remove currency symbols and any non-numeric characters except decimal point
            $clean_value = preg_replace('/[^0-9.]/', '', $result->meta_value);

            if (is_numeric($clean_value)) {
                $unique_values[] = (float)$clean_value;
            }
        }

        // Remove duplicates and sort
        $unique_values = array_unique($unique_values);
        sort($unique_values);

        return $unique_values;
    } else {
        // Standard handling for regular ACF fields
        $query = $wpdb->prepare(
            "SELECT DISTINCT
                pm.meta_value
            FROM
                {$wpdb->postmeta} pm
            JOIN
                {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE
                pm.meta_key = %s
                AND p.post_type = %s
                AND p.post_status = %s
                AND pm.meta_value != ''
                AND pm.meta_value IS NOT NULL
            ORDER BY
                pm.meta_value",
            $acf_field_name,
            $post_type,
            $post_status
        );

        $results = $wpdb->get_results($query);

        if (empty($results)) {
            return [];
        }

        $unique_values = [];
        foreach ($results as $result) {
            // Try to detect if the value is numeric for proper sorting
            if (is_numeric($result->meta_value)) {
                $unique_values[] = (float)$result->meta_value;
            } else {
                $unique_values[] = $result->meta_value;
            }
        }

        // For non-price fields, we need to sort after converting numeric values
        if (is_numeric(reset($unique_values))) {
            sort($unique_values);
        } else {
            // For text values, we'll use natural sort
            natcasesort($unique_values);
            $unique_values = array_values($unique_values); // Reset array keys
        }

        return $unique_values;
    }
}

/**
 * Get unique values for multiple product attributes (ACF fields)
 *
 * @param array $attributes An array of attribute keys and their corresponding ACF field names
 * @return array An array of attribute keys and their unique values
 */
function get_product_attribute_unique_values($attributes)
{
    // Try to get from transient first
    $unique_values = get_transient('product_filter_unique_values');

    // If not in transient, calculate and store
    if ($unique_values === false) {
        $unique_values = [];

        foreach ($attributes as $attribute_key => $acf_field_name) {
            $unique_values[$attribute_key] = get_acf_unique_values($acf_field_name);
        }

        set_transient('product_filter_unique_values', $unique_values, 12 * HOUR_IN_SECONDS);
    }

    return $unique_values;
}

/**
 * Clear both transients when products are updated
 */
function clear_product_filter_caches($post_id)
{
    if (get_post_type($post_id) === 'product') {
        delete_transient('product_filter_ranges');
        delete_transient('product_filter_unique_values');
    }
}
add_action('save_post', 'clear_product_filter_caches');
add_action('deleted_post', 'clear_product_filter_caches');
add_action('acf/save_post', 'clear_product_filter_caches');

/**
 * Add both ranges and unique values to the page for JavaScript
 */
function add_product_filter_data_to_page()
{
    // Only add on relevant pages
    if (!is_page('your-product-page') && !is_post_type_archive('product')) {
        return;
    }

    // Define your attributes and their corresponding meta keys
    $product_attributes = [
        'weight' => 'post_product_gun_weight',
        'price' => 'post_product_gun_price',
        'caliber' => 'post_product_gun_caliber', // Example of a categorical field
        // Add more as needed
    ];

    $ranges = get_product_attribute_ranges($product_attributes);
    $unique_values = get_product_attribute_unique_values($product_attributes);

    echo '<script>
        const productRanges = ' . json_encode($ranges) . ';
        const productUniqueValues = ' . json_encode($unique_values) . ';
    </script>';
}
add_action('wp_footer', 'add_product_filter_data_to_page');

function get_related_safe_products($post_id)
{
    // Get all terms for the current product
    $terms_all = get_the_terms($post_id, 'product_cat');
    if ( ! $terms_all || is_wp_error($terms_all)) {
        return [];
    }

    $related_ids    = [];
    $posts_per_page = 4;

    // Determine which term to use
    $term_to_use = null;
    foreach ($terms_all as $term) {
        if ($term->term_id !== 75 && $term->term_id !== 78) {
            $term_to_use = $term;
            break;
        }
    }

    // If no suitable term found, use the last term in the array
    if ( ! $term_to_use) {
        $term_to_use = end($terms_all);
    }

    // First query using the selected term
    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $posts_per_page,
        'post__not_in'   => [$post_id],
        'tax_query'      => [
            [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $term_to_use->term_id,
            ],
        ],
        'fields'         => 'ids', // Only get post IDs
    ];

    $related_products = get_posts($args);
    $related_ids      = $related_products;

    // If we don't have enough products, try the parent category
    if (count($related_ids) < $posts_per_page && isset($term_to_use->parent) && $term_to_use->parent != 0) {
        $remaining_needed = $posts_per_page - count($related_ids);

        $args['posts_per_page']        = $remaining_needed;
        $args['post__not_in']          = array_merge([$post_id], $related_ids);
        $args['tax_query'][0]['terms'] = $term_to_use->parent;

        $additional_products = get_posts($args);
        $related_ids         = array_merge($related_ids, $additional_products);
    }

    return array_slice($related_ids, 0, $posts_per_page);
}



// -------------------------------
/*

REVIEW

*/


/**
 * Get the minimum and maximum numeric values for a specified key from an array.
 *
 * Only non-array values that are numeric (or numeric strings) are considered.
 * Values containing a decimal point are cast to float; otherwise, they're cast to int.
 *
 * @param array  $attributes Array of associative arrays.
 * @param string $key        The key to search for.
 * @return array             Returns an array with keys 'min' and 'max'.
 */
function get_min_and_max_attribute_vals(array $attributes, $key)
{
    $min = null;
    $max = null;

    foreach ($attributes as $item) {
        if (isset($item[$key]) && !is_array($item[$key]) && is_numeric($item[$key])) {
            $value = $item[$key];
            // Use float if value contains a decimal, otherwise use int.
            $value = (strpos($value, '.') !== false) ? (float)$value : (int)$value;

            if ($min === null || $value < $min) {
                $min = $value;
            }
            if ($max === null || $value > $max) {
                $max = $value;
            }
        }
    }

    return ['min' => $min, 'max' => $max];
}

/**
 * Get a list of unique values for a specified key from an array.
 *
 * If the value for the given key is an array (like 'terms'), it will be flattened
 * into individual values; otherwise, the scalar value is used.
 *
 * @param array  $attributes Array of associative arrays.
 * @param string $key        The key to search for.
 * @return array             Returns a re-indexed array of unique values.
 */
function get_unique_attribute_vals(array $attributes, $key)
{
    $values = [];

    foreach ($attributes as $item) {
        if (isset($item[$key])) {
            $value = $item[$key];
            // If the value is an array, merge its individual values.
            if (is_array($value)) {
                foreach ($value as $subvalue) {
                    $values[] = $subvalue;
                }
            } else {
                $values[] = $value;
            }
        }
    }

    // Remove duplicates and re-index the array.
    return array_values(array_unique($values));
}
