<!-- VIEW of the Product details -->
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
</head>
<body>

@include('home.navbar_conn')

<div class="container py-5 d-flex justify-content-center" >
    <h1 class="text-center mb-5" style="margin-right:30px; font-weight: 700; font-size: 2.5rem; color: #333; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
        🛍️ Your Product
    </h1>

    <div class="row w-100 bg-white bg-opacity-75 rounded shadow-lg p-4" style="backdrop-filter: blur(5px); max-width: 900px;">
        <div class="col-md-6 mb-4 mb-md-0 d-flex align-items-center">
            <img src="{{ asset('productimages/' . basename($product->image)) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow w-100">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h2 class="mb-3">{{ $product->name }}</h2>
            <p class="mb-3">{{ $product->description }}</p>
            <p class="mb-4"><strong>Prix :</strong> {{ number_format($product->price, 2) }} DHS</p>
            
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="btn btn-warning mb-4 btn-add-to-cart" data-json="{{json_encode($product)}}">Add to Cart</button>
            


            <a href="{{ route('homepage') }}" class="btn btn-outline-secondary w-100">← Back to Home</a>
        </div>
    </div>
</div>

<!-- Footer -->
    <footer class="text-center pt-4 border-top">
      <p class="mb-0">&copy; 2025 SPORTERO - All rights reserved.</p>
      <small class="text-light">Site created with ❤️ by a team passionate about sports and coding.</small>
    </footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
    <script src="{{asset('js/addtocart.js')}}"></script>
<script>
// Script pour le navbar fixed
document.addEventListener("DOMContentLoaded", function() {
        let navbarHeight = document.querySelector("header").offsetHeight;
        document.body.style.paddingTop = (navbarHeight) + "px";
        });

</script>

</body>