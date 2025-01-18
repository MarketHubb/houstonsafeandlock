<?php
// Get the base zip code from ACF
$base_zip = get_field('base_zip_code', 'option'); // Replace 'base_zip_code' with your ACF field name
?>

<form id="zip-distance-form" class="max-w-sm mx-auto">
    <input type="hidden" id="base-zip" value="<?php echo esc_attr($base_zip ?: '77042'); ?>">
    
    <div class="mb-4">
        <label for="user-zip" class="block text-sm font-medium text-gray-700">Enter Your Zip Code</label>
        <input 
            type="text" 
            id="user-zip" 
            pattern="[0-9]{5}" 
            maxlength="5"
            required
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            placeholder="Enter zip code"
        >
    </div>
    
    <button 
        type="submit"
        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
    >
        Calculate Distance
    </button>

    <div id="distance-result" class="mt-12 text-center font-medium text-black">Distance</div>
</form>
