<?php 
/**
 * Callback function for the error logging REST API endpoint.
 *
 * Receives error information via POST request and logs it to the WordPress debug log.
 * This function handles the actual processing of requests to the /wp-json/markethubb/log-error endpoint.
 *
 * @since 1.0.0
 * @param WP_REST_Request $request The REST API request object.
 * @return WP_REST_Response A response indicating the success of the logging operation.
 */
function mh_log_rest_errors(WP_REST_Request $request)
{
    $error = $request->get_param('error');
    error_log(print_r($error, true));

    return new WP_REST_Response(array('success' => true), 200);
}

/**
 * Callback function for the remaining safes REST API endpoint.
 *
 * Retrieves a list of products (safes) excluding those specified in the exclude_ids parameter.
 * This function handles the actual processing of requests to the /wp-json/markethubb/remaining-safes endpoint.
 *
 * @since 1.0.0
 * @param WP_REST_Request $request The REST API request object containing the exclude_ids parameter.
 * @return WP_REST_Response|WP_Error HTML output of remaining products wrapped in a JSON response,
 *                                   or an error if no exclude_ids are provided.
 */
function mh_get_remaining_safes(WP_REST_Request $request)
{
    // Retrieve the exclude_ids parameter from the request
    $exclude_ids = $request->get_param('exclude_ids');

    if (true === WP_DEBUG) {
        if (is_array($exclude_ids) || is_object($exclude_ids)) {
            error_log(print_r($request, true));
            error_log(print_r($exclude_ids, true));
        } else {
            error_log($exclude_ids);
        }
    }

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

