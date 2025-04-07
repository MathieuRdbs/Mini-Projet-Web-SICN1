document.addEventListener('DOMContentLoaded', function () {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCartCount();

    const add_to_cart_btn = document.querySelectorAll('.btn-add-to-cart');
    add_to_cart_btn.forEach(button => {
        button.addEventListener('click', function () {
            const product = JSON.parse(this.getAttribute('data-json'));

           if (product.quantity != 0) {
             const item_exist = cart.find(item => item.id === product.id);
             if (item_exist != null) {
                 if (item_exist.q_bought < product.quantity) {
                     item_exist.q_bought += 1;
                     const btn = this;
                     btn.textContent = 'Added!';
                     btn.classList.replace('btn-primary', 'btn-success');
                     setTimeout(() => {
                         btn.textContent = 'Add to Cart';
                         btn.classList.replace('btn-success', 'btn-primary');
                     }, 1000);
                     updateCartCount();
                 } else {
                     toastr.error("You have reached the item max quantity");
                 }
             } else {
                 product['q_bought'] = 1;
                 cart.push(product);
                 const btn = this;
                 btn.textContent = 'Added!';
                 btn.classList.replace('btn-primary', 'btn-success');
                 setTimeout(() => {
                     btn.textContent = 'Add to Cart';
                     btn.classList.replace('btn-success', 'btn-primary');
                 }, 1000);
                 updateCartCount();
             }
 
             localStorage.setItem('cart', JSON.stringify(cart));
           } else {
                toastr.error("this product have 0 quantity");
           }
        });
    });

    function updateCartCount() {
        const count = cart.reduce((total, item) => total + (item.q_bought || 0), 0);

        const cartCountElement = document.getElementById('cartCount');
        if (cartCountElement) {
            cartCountElement.textContent = count;

            if (count > 0) {
                cartCountElement.style.display = 'inline-block';
            } else {
                cartCountElement.style.display = 'none';
            }
        } else {
            console.error("Cart count element not found in the DOM");
        }
    }
});