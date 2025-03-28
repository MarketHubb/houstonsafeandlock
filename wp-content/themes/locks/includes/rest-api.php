<?php
// Register the custom REST API endpoint
function markethubb_register_remaining_safes_endpoint()
{
    register_rest_route('markethubb', '/remaining-safes', array(
        'methods'             => 'GET',
        'callback'            => 'markethubb_get_remaining_safes',
        'permission_callback' => '__return_true', // Publicly accessible
        'args'                => array(
            'exclude_ids' => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
            ),
        ),
    ));
}
add_action('rest_api_init', 'markethubb_register_remaining_safes_endpoint');

function markethubb_get_remaining_safes(WP_REST_Request $request)
{
    // Retrieve the exclude_ids parameter from the request
    $exclude_ids = $request->get_param('exclude_ids');

    if (empty($exclude_ids)) {
        return new WP_Error('no_ids', 'No exclude_ids provided.', array('status' => 400));
    }

    // Convert the comma-separated string into an array of integers
    $ids = array_map('intval', explode(',', $exclude_ids));

    // Pass the entire array to output_products (which expects an array)
    $output_html = output_products($ids, true);

    // Return the HTML wrapped in an array so that it gets JSON encoded properly.
    return new WP_REST_Response(array('html' => $output_html), 200);
}
