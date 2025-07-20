document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', () => {
        const index = button.dataset.index;
        
        // Sample API call for deleting item from cart
        /* fetch('../../api/cart/remove-item.php', {
            method: 'POST',
            body: JSON.stringify({
                index: index
            })
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                button.parentElement.parentElement.remove();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        }); */

        // Remove item from cart
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems[index].remove();
    });
})