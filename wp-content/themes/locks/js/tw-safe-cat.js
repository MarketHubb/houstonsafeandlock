document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-container > h3 > button');
    const menuButton = document.getElementById('menu-button');
    const dropdown = menuButton.nextElementSibling;

    // Sort
    menuButton.addEventListener('click', function () {
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
        dropdown.classList.toggle('hidden');

        if (!expanded) {
            // Add entering classes
            dropdown.classList.add('transition', 'ease-out', 'duration-100', 'transform', 'opacity-0', 'scale-95');
            // Force a reflow
            dropdown.offsetHeight;
            // Remove initial classes and add final classes
            dropdown.classList.remove('opacity-0', 'scale-95');
            dropdown.classList.add('opacity-100', 'scale-100');
        } else {
            // Add leaving classes
            dropdown.classList.add('transition', 'ease-in', 'duration-75', 'transform', 'opacity-100', 'scale-100');
            // Force a reflow
            dropdown.offsetHeight;
            // Remove initial classes and add final classes
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95');
            // Hide the dropdown after animation
            setTimeout(() => {
                dropdown.classList.add('hidden');
            }, 75);
        }
    });

    // Close the dropdown when clicking outside
    document.addEventListener('click', function (event) {
        if (!menuButton.contains(event.target) && !dropdown.contains(event.target)) {
            menuButton.setAttribute('aria-expanded', 'false');
            dropdown.classList.add('hidden');
        }
    });

    // Handle menu item selection
    const menuItems = dropdown.querySelectorAll('[role="menuitem"]');
    menuItems.forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            // Remove 'font-medium text-gray-900' from all items
            menuItems.forEach(mi => mi.classList.remove('font-medium', 'text-gray-900'));
            // Add 'font-medium text-gray-900' to clicked item
            this.classList.add('font-medium', 'text-gray-900');
            // Update button text (optional)
            menuButton.childNodes[0].nodeValue = this.textContent;
            // Close dropdown
            menuButton.setAttribute('aria-expanded', 'false');
            dropdown.classList.add('hidden');
            // Here you would typically trigger the actual sorting functionality
        });
    });


    // Filter
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true' || false;
            this.setAttribute('aria-expanded', !expanded);
            
            const targetId = this.getAttribute('aria-controls');
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.classList.toggle('hidden');
            }
            
            const expandIcon = this.querySelector('.expand-icon');
            const collapseIcon = this.querySelector('.collapse-icon');
            
            if (expandIcon && collapseIcon) {
                expandIcon.classList.toggle('hidden');
                collapseIcon.classList.toggle('hidden');
            }
        });
    });
});
