document.addEventListener('DOMContentLoaded', function () {
    // const modal = document.getElementById('hs-modal-global');
    // console.log("modal",modal);
    const modal = new HSOverlay(document.querySelector('#hs-modal-global'));
    console.log("modal",modal);
    modal.open();
    const openBtn = document.querySelector('#open-btn-sale');

});
