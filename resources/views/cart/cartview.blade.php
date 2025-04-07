<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <style>
      body {
        background-size: cover;
      }

      .cart-container {
        max-width: 800px;
        margin: 50px auto;
        background: rgba(255, 255, 255, 0.85); /* Transparent white */
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0,0,0,0.15);
        padding: 30px;
        backdrop-filter: blur(4px);
      }

      .cart-title {
        text-align: center;
        margin-bottom: 30px;
      }

      .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
      }

      .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
      }

      .quantity-btn {
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 18px;
        line-height: 1;
      }

      .total-section {
        text-align: right;
        margin-top: 30px;
      }
    </style>
</head>
<body>

    @include('home.navbar_conn')
        
    
    <div class="cart-container">
        <h2 class="cart-title">🛒 My Cart</h2>
    
        <div class="row mb-2">
            <div class="col-2 text-center">
            <strong>Image</strong>
            </div>
            <div class="col-4 text-center">
            <strong>Name</strong>
            </div>
            <div class="col-2 text-center">
            <strong>Quantity</strong>
            </div>
            <div class="col-2 text-center">
            <strong>Unit Price</strong>
            </div>
            <div class="col-2 text-center">
            <strong>Total Price</strong>
            </div>
        </div>
        <div class="total-section">
            <h5>Total : <strong>0 DHS</strong></h5>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-2 justify-content-end">
            <a href="{{ route('homepage') }}" class="btn btn-outline-primary">← Back to Shop</a>
            <button id="empty-cart-btn" class="btn btn-outline-danger" onclick="emptyCart()">Empty Cart</button>
            <form action="{{ route('cash') }}" method="POST" id="cash-payment-form">
                @csrf
                <input type="hidden" name="order_data" id="cash-order-data">
                <button id="cash-payment-btn" class="btn btn-success" type="submit">Pay with Cash on Delivery</button>
            </form>
            <button id="stripe-payment-btn" class="btn btn-primary">
                <i class="bi bi-credit-card me-2"></i>Pay with Card
            </button>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let navbarHeight = document.querySelector("header").offsetHeight;
            document.body.style.paddingTop = (navbarHeight) + "px";
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            if ("{{ session('clear_cart') }}") {
                localStorage.removeItem('cart');
                localStorage.removeItem('deliveryAddress');
                localStorage.removeItem('pendingOrder');
            }
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartContainer = document.querySelector('.cart-container');
            
            const totalSection = document.querySelector('.total-section');
            const cartItemsContainer = document.createElement('div');
            cartItemsContainer.id = 'cart-items';
            cartContainer.insertBefore(cartItemsContainer, totalSection);
            
            const shippingSection = document.createElement('div');
            shippingSection.id = 'shipping-section';
            shippingSection.className = 'shipping-section mt-4';
            cartContainer.insertBefore(shippingSection, totalSection);

            displayCart();
            displayShippingForm();

            function displayCart() {
                const cartItemsEl = document.getElementById('cart-items');
                let cartHTML = '';
                let totalAmount = 0;
                
                if (cart.length === 0) {
                    cartHTML = `
                        <div class="text-center p-5">
                            <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                            <p class="mt-3">Your cart is empty</p>
                            <a href="{{ route('buy') }}" class="btn btn-primary mt-2">Continue Shopping</a>
                        </div>
                    `;

                    document.getElementById('shipping-section').style.display = 'none';
                    totalSection.style.display = 'none';

                    document.getElementById('cash-payment-btn').style.display = 'none';
                    document.getElementById('stripe-payment-btn').style.display = 'none';
                    document.getElementById('empty-cart-btn').style.display = 'none';
                } else {
                    document.getElementById('shipping-section').style.display = 'block';
                    totalSection.style.display = 'block';

                    document.getElementById('cash-payment-btn').style.display = 'block';
                    document.getElementById('stripe-payment-btn').style.display = 'block';
                    document.getElementById('empty-cart-btn').style.display = 'block';

                    cart.forEach((item, index) => {
                        const itemTotal = item.price * item.q_bought;
                        totalAmount += itemTotal;
                        
                        cartHTML += `
                            <div class="row mb-3 py-2 align-items-center" style="border-bottom: 1px solid #eee;">
                                <div class="col-2 text-center">
                                    <img src="${item.image}" alt="${item.name}" class="product-img">
                                </div>
                                <div class="col-4">
                                    <h6>${item.name}</h6>
                                </div>
                                <div class="col-2">
                                    <div class="quantity-control">
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" onclick="decreaseQuantity(${index})">-</button>
                                        <span>${item.q_bought}</span>
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" onclick="increaseQuantity(${index})">+</button>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    ${item.price.toFixed(2)} DHS
                                </div>
                                <div class="col-2 text-center">
                                    ${itemTotal.toFixed(2)} DHS
                                </div>
                            </div>
                        `;
                    });
                }
                
                cartItemsEl.innerHTML = cartHTML;
                
                document.querySelector('.total-section h5 strong').textContent = `${totalAmount.toFixed(2)} DHS`;
                localStorage.setItem('cartTotal', totalAmount.toFixed(2));
                updateCartCount();
                
            }
            
            function displayShippingForm() {
                const shippingSection = document.getElementById('shipping-section');
                
                shippingSection.innerHTML = `
                    <h4 class="mb-3">Delivery Address</h4>
                    <form id="shipping-form">
                        <div class="mb-3">
                            <label for="address" class="form-label">Delivery Address</label>
                            <textarea class="form-control" id="address" rows="3" required placeholder="Enter your complete delivery address"></textarea>
                        </div>
                    </form>
                `;
            }

            function updateCartCount() {
                const cartCountEl = document.getElementById('cartCount');
                if (cartCountEl) {
                    const count = cart.reduce((total, item) => total + (item.q_bought || 0), 0);
                    cartCountEl.textContent = count;
                    cartCountEl.style.display = count > 0 ? 'inline-block' : 'none';
                }
            }
            
            window.increaseQuantity = function(index) {
                if (cart[index].q_bought < cart[index].quantity) {
                    cart[index].q_bought += 1;
                    localStorage.setItem('cart', JSON.stringify(cart));
                    displayCart();
                }
            };
            
            window.decreaseQuantity = function(index) {
                if (cart[index].q_bought > 1) {
                    cart[index].q_bought -= 1;
                } else {
                    cart.splice(index, 1);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                displayCart();
            };
            
            window.emptyCart = function() {
                if (confirm('Are you sure you want to empty your cart?')) {
                    localStorage.removeItem('cart');
                    location.reload();
                }
            };

            function validateShippingForm() {
                const addressInput = document.getElementById('address');
                if (!addressInput.value.trim()) {
                    addressInput.classList.add('is-invalid');
                    return false;
                } else {
                    addressInput.classList.remove('is-invalid');
                    return true;
                }
            }
            
            function saveShippingDetails() {
                const address = document.getElementById('address').value;
                localStorage.setItem('deliveryAddress', address);
                return address;
            }
            
            document.getElementById('cash-payment-form').addEventListener('submit', function(e) {
                if (!validateShippingForm()) {
                    e.preventDefault();
                    alert('Please enter your delivery address');
                    return false;
                }
                
                const address = saveShippingDetails();
                const orderData = {
                    items: cart,
                    address: address,
                    total: parseFloat(localStorage.getItem('cartTotal')),
                    paymentMethod: 'cash'
                };
                
                document.getElementById('cash-order-data').value = JSON.stringify(orderData);
            });
            
            document.getElementById('stripe-payment-btn').addEventListener('click', function() {
                if (!validateShippingForm()) {
                    alert('Please enter your delivery address');
                    return false;
                }
                
                const address = saveShippingDetails();
                const orderData = {
                    items: cart,
                    address: address,
                    total: parseFloat(localStorage.getItem('cartTotal')),
                    paymentMethod: 'card'
                };
                
                localStorage.setItem('pendingOrder', JSON.stringify(orderData));
                
                window.location.href = "{{ route('custom.payment.page') }}";
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
        };
    </script>
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}");
        </script>
    @endif
</body>
</html>