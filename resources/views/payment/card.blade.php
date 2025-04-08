<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body {
            padding-top: 70px;
            background-color: #f8f9fa;
        }
        .payment-container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background-color: white;
        }
        .StripeElement--focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        #card-errors {
            color: #dc3545;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    @include('home.navbar_conn')

    <div class="payment-container">
        <h2 class="text-center mb-4">Secure Payment</h2>
        <div class="order-summary mb-4 p-3 bg-light rounded">
            <h5>Order Summary</h5>
            <div class="d-flex justify-content-between">
                <strong>Total:</strong>
                <span id="order-total">0.00 DHS</span>
            </div>
            <div class="mt-2">
                <strong>Delivery Address:</strong>
                <p id="delivery-address" class="mb-0"></p>
            </div>
        </div>

        <form id="payment-form" method="POST" action="{{ route('process.card.payment') }}">
            @csrf
            <input type="hidden" name="order_data" id="order-data">
            <input type="hidden" name="payment_method_id" id="payment-method-id">

            <div class="mb-3">
                <label for="cardholder-name" class="form-label">Cardholder Name</label>
                <input type="text" class="form-control" id="cardholder-name" name="cardholder_name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Card Details</label>
                <div id="card-element" class="StripeElement">
                </div>
                <div id="card-errors" role="alert"></div>
            </div>

            <button type="submit" id="submit-button" class="btn btn-primary w-100 py-2">
                <span id="button-text">Pay Now</span>
                <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-center pt-4 border-top">
      <p class="mb-0">&copy; 2025 SPORTERO - All rights reserved.</p>
      <small class="text-light">Site created with ❤️ by a team passionate about sports and coding.</small>
    </footer>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let navbarHeight = document.querySelector("header").offsetHeight;
            document.body.style.paddingTop = (navbarHeight) + "px";
        });
        document.addEventListener("DOMContentLoaded", function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            function updateCartCount() {
                const cartCountEl = document.getElementById('cartCount');
                if (cartCountEl) {
                    const count = cart.reduce((total, item) => total + (item.q_bought || 0), 0);
                    cartCountEl.textContent = count;
                    cartCountEl.style.display = count > 0 ? 'inline-block' : 'none';
                }
            }
            updateCartCount();
            const orderData = JSON.parse(localStorage.getItem('pendingOrder'));
            if (!orderData) {
                window.location.href = "{{ route('cart') }}";
                return;
            }
            document.getElementById('order-total').textContent = orderData.total.toFixed(2) + ' DHS';
            document.getElementById('delivery-address').textContent = orderData.address;
            document.getElementById('order-data').value = JSON.stringify(orderData);

            const stripe = Stripe('{{ env("STRIPE_KEY") }}');
            const elements = stripe.elements();
            const cardElement = elements.create('card');
            cardElement.mount('#card-element');

            const form = document.getElementById('payment-form');
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const submitButton = document.getElementById('submit-button');
                submitButton.disabled = true;
                document.getElementById('spinner').classList.remove('d-none');
                document.getElementById('button-text').textContent = 'Processing...';

                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                    billing_details: {
                        name: document.getElementById('cardholder-name').value
                    }
                });

                if (error) {

                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    document.getElementById('spinner').classList.add('d-none');
                    document.getElementById('button-text').textContent = 'Pay Now';
                } else {
                    document.getElementById('payment-method-id').value = paymentMethod.id;
                    form.submit();
                }
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