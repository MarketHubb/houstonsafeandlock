document.addEventListener("DOMContentLoaded", () => {
    function getFeaturedImageSrc() {
        const imageContainer = document.querySelector('.g-image-container');

        if (!imageContainer) return null;

        const imageEl = imageContainer.querySelector('figure > img');

        if (!imageEl) return null;

        let src = imageEl.getAttribute('data-lazy-src');

        if (!src) {
            src = imageEl.getAttribute('src');
        }

        return src;
    }

    function getHeadingText() {
        const headingText = document.querySelector('h1');
        console.log("headingText",headingText);

        return headingText.textContent ?? null;
    }

    function getFormButtons() {
        const buttonEl = document.querySelectorAll('.locksmith-cta');

        return buttonEl ?? null;
    }

    function setFormButtons() {
        const btnEls = getFormButtons();
        const imgSrc = getFeaturedImageSrc();
        const headingText = getHeadingText();

        btnEls.forEach((button, index) => {
            button.setAttribute('data-image', imgSrc);
            button.setAttribute('data-title', headingText);
        });
    }


    setFormButtons();
});
