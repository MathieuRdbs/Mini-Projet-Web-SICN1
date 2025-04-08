<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>


    <div class="form-container">
        <h1 class="text-center mb-4">Your orders</h1>
    
        <div class="text-center mb-3">
            <a href="{{ route('homepage') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil
            </a>
        </div>
        <div class="m-4">
            <div class="bg-white rounded-4 shadow p-3"> 
                <div class="table-responsive"> 
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light"> 
                            <tr>
                                <th scope="col" class="text-center">User</th>
                                <th scope="col" class="text-center">Shipping Address</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Total</th>
                                <th scope="col" class="text-center">Payment method</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($orders->isNotEmpty())
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->user->fullname }}</td>
                                        <td class="text-center">
                                            {{ Str::limit($order->shipping_address, 10, '...') }}</td>
                                        <td class="text-center">
                                                {{ $order->status }}
                                        </td>
                                        <td class="text-center">{{ $order->total_price }} dh</td>
                                        <td class="text-center">{{ $order->payment_methode }}</td>
                                        <td class="text-center">
                                            @csrf
                                            <button class="btn btn-sm btn-primary show-btn" 
                                                data-order="{{ json_encode($order) }}"
                                                data-cart="{{ json_encode($order->carts) }}">
                                                <i class="fas fa-eye"></i> Show
                                            </button>
                                            @if ($order->status == 'pendding')
                                                <a href="{{ route('ordercanceluser', $order->id) }}"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirmation(event, 'This order will be canceled!')">
                                                    <i class="fas fa-times"></i> Cancel
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-4">There are no orders.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="m-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    
        <div class="modal fade" id="ShowModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4"> 
                    <div class="modal-header mhead bg-light"> 
                        {{-- header from js --}}
                    </div>
                    <div class="modal-body mbody">
                        {{-- order details --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="cancelBtn" class="btn btn-secondary rounded-3"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script pour le navbar fixed
        document.addEventListener("DOMContentLoaded", function() {
            let navbarHeight = document.querySelector("header").offsetHeight;
            document.body.style.paddingTop = (navbarHeight) + "px";
        });
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
    <script src="{{ asset('js/ordershowadmin.js') }}"></script>
    <script src="{{asset('js/confirmationmsg.js')}}"></script>
</body>

</html>
