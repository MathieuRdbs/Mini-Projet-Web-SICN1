<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    
</head>
<body>
       
    @include('home.navbar_conn')
    @auth
    
    @include('home.home_page_presentation')


    @else
        
<!-- 
        <h1>WELCOME TO OUR HOMEPAGE</h1>
        <p>Login or register</p> -->

        @include('home.home_page_presentation')

      {{-- <!--   <a href="{{route('login')}}">login</a>
    <a href="{{route('register')}}">Register</a> --> --}}
    @endauth

    <!-- Footer -->
    <footer class="text-center pt-4 border-top">
      <p class="mb-0">&copy; 2025 SPORTERO - All rights reserved.</p>
      <small class="text-light">Site created with ❤️ by a team passionate about sports and coding.</small>
    </footer>
  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="{{asset('js/addtocart.js')}}"></script>
    <script>

        // Script pour le navbar fixed
        document.addEventListener("DOMContentLoaded", function() {
        let navbarHeight = document.querySelector("header").offsetHeight;
        document.body.style.paddingTop = (navbarHeight) + "px";
        });

        //Script pour la 2eme partie du homepage apres le Carousel
        window.addEventListener('scroll', function() {
        const cards = document.querySelectorAll('.card');
        const scrollPosition = window.scrollY + window.innerHeight;

        cards.forEach(card => {
            if (card.offsetTop < scrollPosition) {
                card.classList.add('visible'); // Ajoute la classe visible quand la card est dans le viewport
            }
        });
    });
    </script>
</body>
</html>
