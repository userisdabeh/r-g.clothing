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

function shortenText(text, maxLength) {
    return text.length > maxLength ? text.slice(0, maxLength) + '...' : text;
}

function getOrderList() {
    const orderButtons = document.querySelectorAll('.button-data');
    const orderIDInput = document.getElementById('orderID');

    orderIDInput.querySelectorAll('option:not([disabled])').forEach(option => option.remove());

    orderButtons.forEach(button => {
        const orderID = button.getAttribute('data-bs-order-id');
        const orderStatus = button.getAttribute('data-bs-order-status');
        const orderItems = button.getAttribute('data-bs-order-items');

        const option = document.createElement('option');    
        option.value = orderID;
        option.title = `${orderID} - ${orderItems} (${orderStatus})`;
        const text = `${orderID} - ${orderItems} (${orderStatus})`;
        option.textContent = shortenText(text, 60);
        orderIDInput.appendChild(option);
    });
}

document.addEventListener('DOMContentLoaded', getOrderList);