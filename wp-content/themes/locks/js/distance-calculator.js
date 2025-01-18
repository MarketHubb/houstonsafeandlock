import { zipCodeDistance } from 'zipcode-city-distance';

document.addEventListener('DOMContentLoaded', function() {
    // Get the form element
    const distanceForm = document.getElementById('zip-distance-form');
    
    if (distanceForm) {
        distanceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userZip = document.getElementById('user-zip').value;
            const baseZip = document.getElementById('base-zip').value; // Hidden field with ACF value
            
            try {
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
