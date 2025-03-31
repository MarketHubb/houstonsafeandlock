document.addEventListener("DOMContentLoaded", function () {
    // Check that the global safeProductIds object exists and has a "hidden" array
    if (safeProductIds && Array.isArray(safeProductIds.hidden)) {
        // Build the comma-separated list of product IDs to exclude
        var excludeIds = safeProductIds.hidden.join(',');

        // Build the URL with the exclude_ids query parameter
        var params = new URLSearchParams({ exclude_ids: excludeIds });
        var endpointUrl = '/wp-json/markethubb/remaining-safes?' + params.toString();

        // Make the AJAX call using the Fetch API
        fetch(endpointUrl, { method: 'GET' })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error("Network response was not ok: " + response.status);
                }
                // Parse the response as JSON
                return response.json();
            })
            .then(function (data) {
                // Extract the HTML from the returned JSON object
                var html = data.html;
                if (html && html.trim() !== '') {
                    // Append the HTML to the .product-grid container
                    var gridContainer = document.querySelector('.product-grid');
                    if (gridContainer) {
                        gridContainer.insertAdjacentHTML('beforeend', html);
                    }
                }
            })
            .catch(function (error) {
                // write error to debug.log here
            });
    }
});
