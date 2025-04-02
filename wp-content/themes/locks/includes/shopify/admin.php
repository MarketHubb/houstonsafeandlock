<?php
// Add this to your functions.php or custom plugin
function get_shopify_products_with_inventory()
{
    $shop_url = SHOPIFY_STORE_URL;
    $access_token = SHOPIFY_ACCESS_TOKEN;
    // First get products
    $url = "https://{$shop_url}/admin/api/2024-01/products.json?limit=250"; // Adjust limit as needed

    $args = array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'timeout' => 15 // Increase timeout if needed
    );

    $response = wp_remote_get($url, $args);

    if (is_wp_error($response)) {
        error_log('Shopify API Error: ' . $response->get_error_message());
        return false;
    }

    $products = json_decode(wp_remote_retrieve_body($response), true);

    // Collect all inventory_item_ids
    $inventory_item_ids = array();
    foreach ($products['products'] as $product) {
        foreach ($product['variants'] as $variant) {
            $inventory_item_ids[] = $variant['inventory_item_id'];
        }
    }

    // Get inventory levels for all items in one request
    if (!empty($inventory_item_ids)) {
        $inventory_ids_string = implode(',', $inventory_item_ids);
        $levels_url = "https://{$shop_url}/admin/api/2024-01/inventory_levels.json?inventory_item_ids={$inventory_ids_string}";

        $levels_response = wp_remote_get($levels_url, $args);

        if (!is_wp_error($levels_response)) {
            $levels_data = json_decode(wp_remote_retrieve_body($levels_response), true);

            // Create a lookup array for inventory levels
            $inventory_levels = array();
            foreach ($levels_data['inventory_levels'] as $level) {
                $inventory_levels[$level['inventory_item_id']][] = $level;
            }

            // Add inventory levels back to products array
            foreach ($products['products'] as &$product) {
                foreach ($product['variants'] as &$variant) {
                    $variant['inventory_levels'] = $inventory_levels[$variant['inventory_item_id']] ?? array();
                }
            }
        }
    }

    return $products;
}

// Example usage with better error handling
function debug_inventory()
{
    echo '<pre>';
    try {
        $start_time = microtime(true);

        $products = get_shopify_products_with_inventory();

        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time);

        echo "Execution time: " . number_format($execution_time, 2) . " seconds\n\n";

        if ($products === false) {
            echo "Error fetching products\n";
            return;
        }

        // Print first 2 products only for debugging
        $sample = array_slice($products['products'], 0, 2);
        print_r($sample);

        echo "\nTotal products: " . count($products['products']);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    echo '</pre>';
}

function get_shopify_inventory_graphql()
{
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    $shop_url = SHOPIFY_STORE_URL;
    $access_token = SHOPIFY_ACCESS_TOKEN;

    // Get current page and sort parameters
    $current_page = isset($_GET['page_number']) ? max(1, intval($_GET['page_number'])) : 1;
    $per_page = 50;
    $sort_by = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'title';
    $sort_dir = isset($_GET['dir']) ? sanitize_text_field($_GET['dir']) : 'asc';

    // Transient-based cursor handling
    $transient_key = 'shopify_cursors';
    $cursors = get_transient($transient_key) ?: array();

    // Get cursor for current page
    $cursor = null;
    if ($current_page > 1) {
        $cursor = isset($cursors[$current_page - 1]) ? $cursors[$current_page - 1] : null;
    }

    $url = "https://{$shop_url}/admin/api/2024-01/graphql.json";

    $query = '
    query getProducts($cursor: String) {
      products(
        first: ' . $per_page . ', 
        after: $cursor,
        query: "product_type:\'Gun Safe\'"  # Simplified query to just look for Gun Safe
      ) {
        pageInfo {
          hasNextPage
          endCursor
        }
        edges {
          node {
            id
            title
            productType
            variants(first: 10) {  # Increased to get more variants
              edges {
                node {
                  id
                  title
                  sku
                  price
                  inventoryItem {
                    id
                    tracked
                    inventoryLevels(first: 5) {
                      edges {
                        node {
                          available
                          incoming
                          location {
                            name
                            id
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }';

    $response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode([
            'query' => $query,
            'variables' => ['cursor' => null]
        ])
    ));

    if (is_wp_error($response)) {
        error_log('Shopify GraphQL Error: ' . $response->get_error_message());
        return false;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Let's also try a direct product query
    $direct_query = '
    {
      product(id: "gid://shopify/Product/8840722415905") {
        id
        title
        productType
        variants(first: 1) {
          edges {
            node {
              id
              sku
              price
            }
          }
        }
      }
    }';

    $direct_response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(['query' => $direct_query])
    ));

    // Add debug output
    echo "<!-- Direct Query Response: " . wp_remote_retrieve_body($direct_response) . " -->";


    $variables = array('cursor' => $cursor);

    $args = array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'method' => 'POST',
        'body' => json_encode([
            'query' => $query,
            'variables' => $variables
        ])
    );

    $response = wp_remote_post($url, $args);

    if (is_wp_error($response)) {
        error_log('Shopify GraphQL Error: ' . $response->get_error_message());
        return false;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    // Store the current page's cursor in transient
    if (isset($data['data']['products']['pageInfo']['endCursor'])) {
        $cursors[$current_page] = $data['data']['products']['pageInfo']['endCursor'];
        set_transient($transient_key, $cursors, HOUR_IN_SECONDS);
    }

    // Build sortable table
    echo "<h2>Detailed Inventory Analysis</h2>";
    echo "<div style='background: #fff; padding: 20px; margin: 20px 0;'>";

    // Create array for sorting
    $products_array = array();
    if (isset($data['data']['products']['edges'])) {
        foreach ($data['data']['products']['edges'] as $productEdge) {
            $product = $productEdge['node'];
            if (isset($product['variants']['edges'][0])) {
                $variant = $product['variants']['edges'][0]['node'];
                $inventoryItem = $variant['inventoryItem'];

                // Extract variant ID and remove the Shopify GraphQL prefix
                $variant_id = str_replace('gid://shopify/ProductVariant/', '', $variant['id']);

                if (isset($inventoryItem['inventoryLevels']['edges'])) {
                    foreach ($inventoryItem['inventoryLevels']['edges'] as $levelEdge) {
                        $level = $levelEdge['node'];
                        $products_array[] = array(
                            'title' => $product['title'],
                            'variant_id' => $variant_id,
                            'sku' => $variant['sku'] ?: 'No SKU',
                            'price' => floatval($variant['price']),
                            'product_type' => $product['productType'],
                            'tracked' => $inventoryItem['tracked'] ? 'Tracked' : 'Not Tracked',
                            'location' => $level['location']['name'],
                            'available' => intval($level['available']),
                            'incoming' => intval($level['incoming'])
                        );
                    }
                } else {
                    $products_array[] = array(
                        'title' => $product['title'],
                        'variant_id' => $variant_id,
                        'sku' => $variant['sku'] ?: 'No SKU',
                        'price' => floatval($variant['price']),
                        'product_type' => $product['productType'],
                        'tracked' => $inventoryItem['tracked'] ? 'Tracked' : 'Not Tracked',
                        'location' => 'N/A',
                        'available' => 0,
                        'incoming' => 0
                    );
                }
            }
        }
    }

    // Sort the array
    usort($products_array, function ($a, $b) use ($sort_by, $sort_dir) {
        $result = 0;
        if ($sort_by === 'price' || $sort_by === 'available' || $sort_by === 'incoming') {
            $result = $a[$sort_by] <=> $b[$sort_by];
        } else {
            $result = strcasecmp($a[$sort_by], $b[$sort_by]);
        }
        return $sort_dir === 'desc' ? -$result : $result;
    });

    // Generate sort URLs
    function get_sort_url($column, $current_sort, $current_dir, $current_page)
    {
        return add_query_arg(array(
            'page' => 'shopify-inventory',
            'sort' => $column,
            'dir' => ($column === $current_sort && $current_dir === 'asc') ? 'desc' : 'asc',
            'page_number' => $current_page
        ), admin_url('admin.php'));
    }

    // Display table
    echo "<table class='wp-list-table widefat fixed striped'>";
    echo "<thead><tr>";
    $columns = array(
        'title' => 'Product',
        'variant_id' => 'Variant ID',
        'sku' => 'SKU',
        'price' => 'Price',
        'product_type' => 'Product Type',
        'tracked' => 'Tracking Status',
        'location' => 'Location',
        'available' => 'Available',
        'incoming' => 'Incoming'
    );

    foreach ($columns as $column => $label) {
        $sort_url = get_sort_url($column, $sort_by, $sort_dir, $current_page);
        $sort_indicator = ($sort_by === $column) ? ($sort_dir === 'asc' ? ' ↑' : ' ↓') : '';
        echo "<th><a href='" . esc_url($sort_url) . "'>" . esc_html($label) . $sort_indicator . "</a></th>";
    }
    echo "</tr></thead><tbody>";

    foreach ($products_array as $product) {
        echo "<tr>";
        echo "<td>" . esc_html($product['title']) . "</td>";
        echo "<td>" . esc_html($product['variant_id']) . "</td>";
        echo "<td>" . esc_html($product['sku']) . "</td>";
        echo "<td>$" . number_format($product['price'], 2) . "</td>";
        echo "<td>" . esc_html($product['product_type']) . "</td>";
        echo "<td>" . esc_html($product['tracked']) . "</td>";
        echo "<td>" . esc_html($product['location']) . "</td>";
        echo "<td>" . esc_html($product['available']) . "</td>";
        echo "<td>" . esc_html($product['incoming']) . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";

    // Pagination
    $has_next_page = $data['data']['products']['pageInfo']['hasNextPage'];
    echo "<div class='tablenav'><div class='tablenav-pages'>";
    if ($current_page > 1) {
        $prev_url = add_query_arg(array(
            'page' => 'shopify-inventory',
            'page_number' => $current_page - 1,
            'sort' => $sort_by,
            'dir' => $sort_dir
        ), admin_url('admin.php'));
        echo "<a href='" . esc_url($prev_url) . "' class='button'>Previous</a> ";
    }
    echo "<span class='page-numbers current'>" . $current_page . "</span> ";
    if ($has_next_page) {
        $next_url = add_query_arg(array(
            'page' => 'shopify-inventory',
            'page_number' => $current_page + 1,
            'sort' => $sort_by,
            'dir' => $sort_dir
        ), admin_url('admin.php'));
        echo "<a href='" . esc_url($next_url) . "' class='button'>Next</a>";
    }
    echo "</div></div>";

    echo "</div>";
}


// Add to your admin menu
add_action('admin_menu', function () {
    add_menu_page(
        'Shopify Inventory',
        'Shopify Inventory',
        'manage_options',
        'shopify-inventory',
        'get_shopify_inventory_graphql',
        'dashicons-store',
        30
    );
});

function debug_specific_product()
{
    $shop_url = SHOPIFY_STORE_URL;
    $access_token = SHOPIFY_ACCESS_TOKEN;

    echo "<div style='background: #fff; padding: 20px; margin: 20px; font-family: monospace;'>";
    echo "<h2>Debugging Product SKU 6010</h2>";

    $query = '
    {
      products(first: 1, query: "sku:6010") {
        edges {
          node {
            id
            title
            productType
            variants(first: 1) {
              edges {
                node {
                  id
                  sku
                  price
                }
              }
            }
          }
        }
      }
    }';

    $response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(['query' => $query])
    ));

    echo "<h3>API Response:</h3>";
    echo "<pre>";
    var_dump(json_decode(wp_remote_retrieve_body($response), true));
    echo "</pre>";

    // Also debug the admin table query
    echo "<h3>Admin Table Query Test:</h3>";
    $admin_query = '
    {
      products(first: 10, query: "product_type:\'Gun Safe\' OR product_type:\'Safes\'") {
        edges {
          node {
            id
            title
            productType
            variants(first: 1) {
              edges {
                node {
                  id
                  sku
                  price
                }
              }
            }
          }
        }
      }
    }';

    $admin_response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(['query' => $admin_query])
    ));

    echo "<pre>";
    var_dump(json_decode(wp_remote_retrieve_body($admin_response), true));
    echo "</pre>";

    echo "</div>";
}

// Add to WordPress admin menu for easy access
add_action('admin_menu', function () {
    add_menu_page(
        'Shopify Debug',
        'Shopify Debug',
        'manage_options',
        'shopify-debug',
        'debug_specific_product',
        'dashicons-bug',
        31  // Position after Shopify Inventory
    );
});


function update_all_posts_with_shopify_data()
{
    $shop_url = SHOPIFY_STORE_URL;
    $access_token = SHOPIFY_ACCESS_TOKEN;

    $query = '
    query getProducts($cursor: String) {
      products(
        first: 250,
        after: $cursor,
        query: "product_type:\'Gun Safe\'"
      ) {
        pageInfo {
          hasNextPage
          endCursor
        }
        edges {
          node {
            id
            title
            productType
            variants(first: 10) {
              edges {
                node {
                  id
                  sku
                  price
                  inventoryItem {
                    id
                    tracked
                    inventoryLevels(first: 5) {
                      edges {
                        node {
                          available
                          incoming
                          location {
                            name
                            id
                          }
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }';

    $cursor = null;
    $updated_posts = array();
    $errors = array();

    do {
        $response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
            'headers' => array(
                'X-Shopify-Access-Token' => $access_token,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode([
                'query' => $query,
                'variables' => ['cursor' => $cursor]
            ])
        ));

        if (is_wp_error($response)) {
            $errors[] = "API Error: " . $response->get_error_message();
            break;
        }

        $data = json_decode(wp_remote_retrieve_body($response), true);

        if (isset($data['data']['products']['edges'])) {
            foreach ($data['data']['products']['edges'] as $productEdge) {
                $product = $productEdge['node'];

                foreach ($product['variants']['edges'] as $variantEdge) {
                    $variant = $variantEdge['node'];
                    $sku = $variant['sku'];

                    // Skip if no SKU
                    if (empty($sku)) continue;

                    // Check if post exists with this ID
                    $post = get_post(intval($sku));
                    if ($post && $post->post_type === 'product') {
                        $inventory_rows = array();
                        $inventoryItem = $variant['inventoryItem'];

                        // Initialize inventory levels
                        $inventory = array(
                            'westheimer' => array('available' => 0, 'incoming' => 0),
                            'memorial' => array('available' => 0, 'incoming' => 0),
                            'warehouse' => array('available' => 0, 'incoming' => 0)
                        );

                        // Process inventory levels
                        if (isset($inventoryItem['inventoryLevels']['edges'])) {
                            foreach ($inventoryItem['inventoryLevels']['edges'] as $levelEdge) {
                                $level = $levelEdge['node'];
                                $location_name = strtolower($level['location']['name']);

                                foreach ($inventory as $key => $values) {
                                    if (strpos($location_name, $key) !== false) {
                                        $inventory[$key]['available'] = intval($level['available']);
                                        $inventory[$key]['incoming'] = intval($level['incoming']);
                                    }
                                }
                            }
                        }

                        // Create row data
                        $inventory_rows[] = array(
                            'product' => $product['title'],
                            'variant_id' => str_replace('gid://shopify/ProductVariant/', '', $variant['id']),
                            'price' => $variant['price'],
                            'tracking_status' => $inventoryItem['tracked'] ? 'Tracked' : 'Not Tracked',
                            'westheimer_available' => $inventory['westheimer']['available'],
                            'westheimer_incoming' => $inventory['westheimer']['incoming'],
                            'memorial_available' => $inventory['memorial']['available'],
                            'memorial_incoming' => $inventory['memorial']['incoming'],
                            'warehouse_available' => $inventory['warehouse']['available'],
                            'warehouse_incoming' => $inventory['warehouse']['incoming']
                        );

                        // Update the repeater field
                        update_field('product_inventory', $inventory_rows, $post->ID);
                        $updated_posts[] = $post->ID;
                    }
                }
            }
        }

        $cursor = $data['data']['products']['pageInfo']['endCursor'];
        $has_next_page = $data['data']['products']['pageInfo']['hasNextPage'];
    } while ($has_next_page);

    return array(
        'updated' => $updated_posts,
        'errors' => $errors
    );
}



// 2. Schedule daily update
function schedule_shopify_inventory_update()
{
    if (!wp_next_scheduled('shopify_inventory_daily_update')) {
        wp_schedule_event(strtotime('today midnight'), 'daily', 'shopify_inventory_daily_update');
    }
}
add_action('wp', 'schedule_shopify_inventory_update');

// The function that runs during the cron event
add_action('shopify_inventory_daily_update', 'update_all_posts_with_shopify_data');

// 3. Add manual update button to admin page
function add_manual_update_button()
{
    // Only add to our Shopify inventory page
    $screen = get_current_screen();
    if ($screen->id !== 'toplevel_page_shopify-inventory') return;

?>
    <div class="wrap">
        <h2>Manual Inventory Update</h2>
        <form method="post" action="">
            <?php wp_nonce_field('shopify_manual_update', 'shopify_update_nonce'); ?>
            <input type="submit" name="run_shopify_update" class="button button-primary" value="Update Inventory Now">
        </form>
    </div>
    <?php

    // Handle form submission
    if (isset($_POST['run_shopify_update']) && check_admin_referer('shopify_manual_update', 'shopify_update_nonce')) {
        $result = update_all_posts_with_shopify_data();

        if (!empty($result['updated'])) {
            add_settings_error(
                'shopify_inventory',
                'shopify_updated',
                sprintf('Successfully updated %d products.', count($result['updated'])),
                'updated'
            );
        }

        if (!empty($result['errors'])) {
            foreach ($result['errors'] as $error) {
                add_settings_error(
                    'shopify_inventory',
                    'shopify_error',
                    $error,
                    'error'
                );
            }
        }
    }
}
add_action('admin_notices', 'add_manual_update_button');

// Add settings errors display
function display_update_messages()
{
    settings_errors('shopify_inventory');
}
add_action('admin_notices', 'display_update_messages');



function update_product_discounts()
{
    $shop_url = SHOPIFY_STORE_URL;
    $access_token = SHOPIFY_ACCESS_TOKEN;

    echo "<div style='background: #fff; padding: 20px; margin: 20px; font-family: monospace;'>";
    echo "<h2>Discount Update Debug Output</h2>";

    // First, get products from the specific collections
    $collections_query = '
    {
      collections(first: 10, query: "id:463973384481 OR id:463973417249") {
        edges {
          node {
            id
            title
            products(first: 250) {
              edges {
                node {
                  id
                  title
                  variants(first: 10) {
                    edges {
                      node {
                        id
                        sku
                        price
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }';

    echo "<h3>Collections Query:</h3>";
    echo "<pre>" . htmlspecialchars($collections_query) . "</pre>";

    $response = wp_remote_post("https://{$shop_url}/admin/api/2024-01/graphql.json", array(
        'headers' => array(
            'X-Shopify-Access-Token' => $access_token,
            'Content-Type' => 'application/json'
        ),
        'body' => json_encode(['query' => $collections_query])
    ));

    if (is_wp_error($response)) {
        echo "<h3>Error:</h3>";
        echo "<pre>" . $response->get_error_message() . "</pre>";
        echo "</div>";
        return false;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    echo "<h3>API Response:</h3>";
    echo "<pre>" . print_r($data, true) . "</pre>";

    $updated_products = array();
    $discount_percentage = 25; // We know it's 25% from the price rule

    // Process each collection's products
    if (isset($data['data']['collections']['edges'])) {
        foreach ($data['data']['collections']['edges'] as $collectionEdge) {
            $collection = $collectionEdge['node'];
            echo "<h3>Processing Collection: {$collection['title']}</h3>";

            if (isset($collection['products']['edges'])) {
                foreach ($collection['products']['edges'] as $productEdge) {
                    $product = $productEdge['node'];

                    foreach ($product['variants']['edges'] as $variantEdge) {
                        $variant = $variantEdge['node'];
                        $variant_id = str_replace('gid://shopify/ProductVariant/', '', $variant['id']);
                        $original_price = floatval($variant['price']);
                        $discount_amount = $original_price * ($discount_percentage / 100);
                        $discount_price = $original_price - $discount_amount;

                        echo "<h4>Processing Variant:</h4>";
                        echo "<p>Product: {$product['title']}</p>";
                        echo "<p>Variant ID: {$variant_id}</p>";
                        echo "<p>Original Price: {$original_price}</p>";
                        echo "<p>Discount Amount: {$discount_amount}</p>";
                        echo "<p>Discount Price: {$discount_price}</p>";

                        // Get all products
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => -1
                        );

                        $query = new WP_Query($args);

                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $post_id = get_the_ID();

                                // Get current repeater rows
                                $rows = get_field('product_inventory', $post_id);


                                // Inside the loop where we update the rows, modify this section:
                                if ($rows) {
                                    $updated = false;
                                    foreach ($rows as $key => $row) {
                                        if ($row['variant_id'] === $variant_id) {
                                            $rows[$key]['discount_price'] = $discount_price;
                                            $rows[$key]['discount_amount'] = $discount_amount;
                                            $rows[$key]['discount'] = $discount_percentage . '%'; // Add this line
                                            $updated = true;
                                            echo "<p>Found matching variant in post {$post_id}, updating row {$key}</p>";
                                        }
                                    }

                                    if ($updated) {
                                        $update_result = update_field('product_inventory', $rows, $post_id);
                                        echo "<p>Update result for post {$post_id}: " . ($update_result ? 'Success' : 'Failed') . "</p>";
                                        if ($update_result) {
                                            $updated_products[] = $post_id;
                                        }
                                    }
                                }
                            }
                            wp_reset_postdata();
                        }
                    }
                }
            }
        }
    }

    $unique_updated = array_unique($updated_products);
    echo "<h3>Final Results:</h3>";
    echo "<p>Updated Products: " . implode(', ', $unique_updated) . "</p>";
    echo "</div>";

    return array(
        'updated' => $unique_updated,
        'message' => sprintf('Updated discounts for %d products', count($unique_updated))
    );
}


// Add an admin button specifically for updating discounts
function add_update_discounts_button()
{
    // Only add to our Shopify inventory page
    $screen = get_current_screen();
    if ($screen->id !== 'toplevel_page_shopify-inventory') return;

    ?>
    <div class="wrap">
        <h2>Update Product Discounts</h2>
        <form method="post" action="">
            <?php wp_nonce_field('shopify_discount_update', 'shopify_discount_nonce'); ?>
            <input type="submit" name="run_discount_update" class="button button-secondary" value="Update Discounts Only">
        </form>
    </div>
<?php

    // Handle form submission
    if (isset($_POST['run_discount_update']) && check_admin_referer('shopify_discount_update', 'shopify_discount_nonce')) {
        $result = update_product_discounts();
    }
}
add_action('admin_notices', 'add_update_discounts_button');
