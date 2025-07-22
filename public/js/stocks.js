const updateStockModal = document.getElementById('updateStockModal');
if (updateStockModal) {
    updateStockModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;

        const productName = button.getAttribute('data-bs-product-name');
        const productSize = button.getAttribute('data-bs-product-size');
        const productColor = button.getAttribute('data-bs-product-color');
        const productStock = button.getAttribute('data-bs-product-stock');

        const modalTitle = updateStockModal.querySelector('.modal-title');
        const productNameInput = updateStockModal.querySelector('#productName');
        const productSizeInput = updateStockModal.querySelector('#productSize');
        const productColorInput = updateStockModal.querySelector('#productColor');
        const productQuantityInput = updateStockModal.querySelector('#productQuantity');

        modalTitle.textContent = `Update Stock for ${productName}`;
        productNameInput.value = productName;
        productSizeInput.value = productSize;
        productColorInput.value = productColor;
        productQuantityInput.value = productStock;
    });
}