const updateStockModal = document.getElementById('updateStockModal');
if (updateStockModal) {
    updateStockModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;

        const productID = button.getAttribute('data-bs-product-id');
        const productName = button.getAttribute('data-bs-product-name');
        const productSize = button.getAttribute('data-bs-product-size');
        const productColor = button.getAttribute('data-bs-product-color');
        const productStock = button.getAttribute('data-bs-product-stock');

        const modalTitle = updateStockModal.querySelector('.modal-title');
        const productIDInput = updateStockModal.querySelector('#productID');
        const productQuantityInput = updateStockModal.querySelector('#productQuantity');

        modalTitle.textContent = productName ? `Update Stock for Product #${productID}` : 'Update Stock';
        productIDInput.value = productID;
        productQuantityInput.value = productStock;
    });
}

function getProductList() {
    const productButtons = document.querySelectorAll('.button-data');
    const productIDInput = document.getElementById('productID');

    productIDInput.querySelectorAll('option:not([disabled])').forEach(option => option.remove());

    productButtons.forEach(button => {
        const productID = button.getAttribute('data-bs-product-id');
        const productName = button.getAttribute('data-bs-product-name');
        const productSize = button.getAttribute('data-bs-product-size');
        const productColor = button.getAttribute('data-bs-product-color');

        const option = document.createElement('option');
        option.value = productID;
        option.textContent = `#${productID} - ${productName} (${productSize}, ${productColor})`;
        productIDInput.appendChild(option);
    });
}

document.addEventListener('DOMContentLoaded', getProductList);