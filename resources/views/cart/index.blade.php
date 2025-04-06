<!-- Main view of the cart -->

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

  <!-- Parcours des produits du panier -->
  @foreach ($cartItems as $item)
  <div class="row align-items-center mb-4" data-cart-id="{{ $item->id }}">  <!-- Utilise l'id du panier -->
    <div class="col-2">
      <img src="{{ asset('productimages/' . basename($item->product->image)) }}" class="product-img" alt="{{ $item->product->name }}">
    </div>
    <div class="col-4">
      <h5 class="mb-1">{{ $item->product->name }}</h5>
    </div>
    <div class="col-2 text-center">
      <div class="quantity-control">
        <button class="btn btn-sm btn-outline-secondary quantity-btn decrease-btn">-</button>
        <span class="quantity">{{ $item->q_bought }}</span> <!-- Classe pour la quantité -->
        <button class="btn btn-sm btn-outline-secondary quantity-btn increase-btn">+</button>
        <button class="btn btn-sm btn-outline-danger quantity-btn delete-btn" data-cart-id="{{ $item->id }}">
        <i class="bi bi-trash"></i> <!-- Icône poubelle de Bootstrap Icons -->
        </button>
      </div>
    </div>
    <div class="col-2 text-end">
      <span>€{{ number_format($item->product->price, 2) }}</span>
    </div>
    <div class="col-2 text-end">
      <strong class="total-price">€{{ number_format($item->t_price, 2) }}</strong> <!-- Classe pour le prix total -->
    </div>
  </div>
@endforeach

  <!-- Total -->
  <div class="total-section">
    <h5>Total : <strong>€{{ number_format($cartItems->sum('t_price'), 2) }}</strong></h5>
    <a href="{{ route('homepage') }}" class="btn btn-outline-primary mt-3">Retour</a>
    <button class="btn btn-success mt-3">Valider</button>
    <div class="mt-2 alert alert-info">
      <small>Pour voir le prix total mis à jour, veuillez actualiser la page.</small>
    </div>
  </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// Script pour le navbar fixed
document.addEventListener("DOMContentLoaded", function() {
        let navbarHeight = document.querySelector("header").offsetHeight;
        document.body.style.paddingTop = (navbarHeight) + "px";
        });


//Fonction pour envoyer la requete AJAX pour augemnter et diminuer la quantité de produit dans le panier
function updateCart(cartItemId, action) {
  $.ajax({
    url: '{{ route('cart.updateQuantity') }}',
    method: 'POST',
    data: {
      cart_item_id: cartItemId,
      action: action,
      _token: '{{ csrf_token() }}'
    },
    success: function(response) {
      // Mettre à jour la quantité et le prix total dans la vue
      const cartRow = $(`[data-cart-id=${cartItemId}]`); // Utilise data-cart-id
      cartRow.find('.quantity').text(response.new_quantity); // Met à jour la quantité
      cartRow.find('.total-price').text('€' + response.new_total.toFixed(2)); // Met à jour le prix total
    },
    error: function(response) {
      console.log(response); // Affiche la réponse d'erreur dans la console
      alert('Erreur lors de la mise à jour de la quantité : ' + response.responseText);
    }
  });
}

// Gestion des clics sur les boutons + et -
$('.decrease-btn').click(function() {
  const cartItemId = $(this).closest('.row').data('cart-id'); // Utilise data-cart-id
  console.log("Cart item ID récupéré : ", cartItemId);
  updateCart(cartItemId, 'decrease');
});

$('.increase-btn').click(function() {
  const cartItemId = $(this).closest('.row').data('cart-id'); // Utilise data-cart-id
  console.log("Cart item ID récupéré : ", cartItemId);
  updateCart(cartItemId, 'increase');
});


//supprimer la ligne
$('.delete-btn').click(function() {
    const cartItemId = $(this).data('cart-id'); // Récupérer l'id de l'élément du panier
    const row = $(this).closest('.row'); // La ligne de produit à supprimer

    // Confirmer la suppression avec un message
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article de votre panier ?')) {
        // Envoyer la requête AJAX pour supprimer l'élément du panier
        $.ajax({
            url: '/cart/' + cartItemId, // Route pour supprimer l'élément
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}' // Token CSRF pour la sécurité
            },
            success: function(response) {
                // Si la suppression est réussie, supprimer la ligne du panier
                row.remove(); // Supprimer la ligne du DOM
            },
            error: function(xhr, status, error) {
                // Afficher une erreur en cas de problème
                alert('Erreur lors de la suppression de l\'article.');
            }
        });
    }
});


</script>


</body>
</html>