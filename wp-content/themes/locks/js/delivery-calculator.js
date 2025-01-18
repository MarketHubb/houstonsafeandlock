document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const form = document.querySelector('form');
    
    if (form) {
        // Listen for form submission instead of button click
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get zip codes from inputs
            const userZip = document.getElementById('zip').value;
            const baseZip = document.getElementById('base-zip').value;
            
            try {
                // Calculate distance using the globally available function
                const distance = zipCodeDistance(baseZip, userZip);
                const resultDiv = document.getElementById('distance-result');
                resultDiv.textContent = `Distance: ${Math.round(distance)} miles`;
            } catch (error) {
                console.error('Error calculating distance:', error);
                const resultDiv = document.getElementById('distance-result');
                resultDiv.textContent = 'Invalid zip code entered';
            }
        });
    }
});
