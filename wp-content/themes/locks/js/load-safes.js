document.addEventListener("DOMContentLoaded", function () {
    // Check that the global safeProductIds object exists and has a "hidden" array
    if (safeProductIds && Array.isArray(safeProductIds.hidden)) {
        // Build the comma-separated list of product IDs to exclude
        var excludeIds = safeProductIds.hidden.join(',');
        console.log("excludeIds", excludeIds);

        // Build the URL with the exclude_ids query parameter
        var params = new URLSearchParams({ exclude_ids: excludeIds });
        var endpointUrl = '/wp-json/markethubb/remaining-safes?' + params.toString();
        console.log("Endpoint URL:", endpointUrl);

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
                    console.log('Received HTML grid items:', html);
                    // Append the HTML to the .product-grid container
                    var gridContainer = document.querySelector('.product-grid');
                    if (gridContainer) {
                        gridContainer.insertAdjacentHTML('beforeend', html);
                    } else {
                        console.error('Could not find the .product-grid container.');
                    }
                } else {
                    console.warn('No HTML returned from the REST endpoint.');
                }
            })
            .catch(function (error) {
                console.error('Error fetching remaining products:', error);
            });
    } else {
        console.error("safeProductIds.hidden is not available or is not an array.");
    }
});
