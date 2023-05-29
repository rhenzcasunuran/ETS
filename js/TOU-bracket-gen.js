document.addEventListener('DOMContentLoaded', function () {
    const confirmButton = document.getElementById('confirmButton');
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmYes = document.getElementById('confirmYes');
    const confirmNo = document.getElementById('confirmNo');
    const close = document.getElementsByClassName('close')[0];

    confirmButton.addEventListener('click', function () {
        confirmationModal.style.display = 'block';
    });

    confirmYes.addEventListener('click', function () {
        // Perform the action here
        console.log('Item deleted');
        confirmationModal.style.display = 'none';
    });

    confirmNo.addEventListener('click', function () {
        confirmationModal.style.display = 'none';
    });

    close.addEventListener('click', function () {
        confirmationModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        if (event.target === confirmationModal) {
            confirmationModal.style.display = 'none';
        }
    });
});