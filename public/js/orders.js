const updateOrderModal = document.getElementById('updateOrderModal');
if (updateOrderModal) {
    updateOrderModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;

        const orderID = button.getAttribute('data-bs-order-id');
        const orderStatus = button.getAttribute('data-bs-order-status');

        const modalTitle = updateOrderModal.querySelector('.modal-title');
        const orderIDInput = updateOrderModal.querySelector('#orderID');
        const orderStatusInput = updateOrderModal.querySelector('#orderStatus');

        modalTitle.textContent = `Update Order Status for Order ID ${orderID}`;
        orderIDInput.value = orderID;
        orderStatusInput.value = orderStatus;
    });
}