document.addEventListener('DOMContentLoaded', function () {
    const accordionButtons = document.querySelectorAll('button[aria-controls^="disclosure-"]');
    
    if (!accordionButtons.length) return;

    accordionButtons.forEach(button => {
        button.addEventListener('click', () => {
            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            const contentId = button.getAttribute('aria-controls');
            const content = document.getElementById(contentId);
            const plusIcon = button.querySelector('svg:first-of-type');  // First SVG is plus icon
            const minusIcon = button.querySelector('svg:last-of-type');  // Second SVG is minus icon
            const buttonText = button.querySelector('span:first-child');
            
            // Close all other sections
            accordionButtons.forEach(otherButton => {
                if (otherButton !== button) {
                    const otherId = otherButton.getAttribute('aria-controls');
                    const otherContent = document.getElementById(otherId);
                    const otherPlusIcon = otherButton.querySelector('svg:first-of-type');
                    const otherMinusIcon = otherButton.querySelector('svg:last-of-type');
                    const otherButtonText = otherButton.querySelector('span:first-child');
                    
                    otherButton.setAttribute('aria-expanded', 'false');
                    
                    if (otherContent) {
                        otherContent.classList.add('hidden');
                    }
                    
                    // Ensure plus icon is showing and minus icon is hidden
                    if (otherPlusIcon && otherMinusIcon) {
                        otherPlusIcon.classList.remove('hidden');
                        otherPlusIcon.classList.add('block');
                        otherMinusIcon.classList.add('hidden');
                        otherMinusIcon.classList.remove('block');
                    }
                    
                    if (otherButtonText) {
                        otherButtonText.classList.remove('text-brand-500');
                        otherButtonText.classList.add('text-gray-600');
                    }
                }
            });

            // Toggle current section
            button.setAttribute('aria-expanded', !isExpanded);
            
            if (content) {
                content.classList.toggle('hidden');
            }
            
            if (plusIcon && minusIcon) {
                plusIcon.classList.toggle('hidden');
                plusIcon.classList.toggle('block');
                minusIcon.classList.toggle('hidden');
                minusIcon.classList.toggle('block');
            }
            
            if (buttonText) {
                buttonText.classList.toggle('text-brand-500');
                buttonText.classList.toggle('text-gray-600');
            }
        });
    });
});
