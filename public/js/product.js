const quantityInput = document.querySelector('#product-quantity');
const addQuantityButton = document.querySelector('#button-plus');
const minusQuantityButton = document.querySelector('#button-minus');
let maxStock = 0;

const productDetailsForm = document.querySelector('#product-details-form');

function updateStockStatus() {
    const size = document.querySelector('#product-size').value;
    const color = document.querySelector('#product-color').value.toLowerCase();

    const stock = window.stockData[size][color] ?? 0;
    document.querySelector('.stock-status-value').textContent = stock;

    // Update maxStock and quantity limit
    quantityInput.max = stock;
    maxStock = stock;

    // Clamp current value if it exceeds stock
    if (parseInt(quantityInput.value) > stock) {
        quantityInput.value = stock > 0 ? stock : 1;
    }

    // Enable/disable buttons accordingly
    addQuantityButton.disabled = (parseInt(quantityInput.value) >= stock);
    minusQuantityButton.disabled = (parseInt(quantityInput.value) <= 1);
}

// PLUS button
addQuantityButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue < maxStock) {
        quantityInput.value = currentValue + 1;
    }
    addQuantityButton.disabled = (parseInt(quantityInput.value) >= maxStock);
    minusQuantityButton.disabled = (parseInt(quantityInput.value) <= 1);
});

// MINUS button
minusQuantityButton.addEventListener('click', () => {
    let currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
    }
    minusQuantityButton.disabled = (parseInt(quantityInput.value) <= 1);
    addQuantityButton.disabled = (parseInt(quantityInput.value) >= maxStock);
});

// Listen to size/color change
document.querySelector('#product-size').addEventListener('change', updateStockStatus);
document.querySelector('#product-color').addEventListener('change', updateStockStatus);

// Listen to form submit
productDetailsForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const action = e.submitter.value;

    if (action === 'Cart') {
        addToCart();
    } else if (action === 'Buy') {
        buyNow();
    }
});

function addToCart() {
    const size = document.querySelector('#product-size').value;
    const color = document.querySelector('#product-color').value.toLowerCase();
    const quantity = parseInt(document.querySelector('#product-quantity').value);

    if (quantity < 0 || quantity > maxStock) {
        alert('Invalid quantity');
        return;
    }
}

function buyNow() {
    const size = document.querySelector('#product-size').value;
    const color = document.querySelector('#product-color').value.toLowerCase();
    const quantity = parseInt(document.querySelector('#product-quantity').value);

    if (quantity < 0 || quantity > maxStock) {
        alert('Invalid quantity');
        return;
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', updateStockStatus);