<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    
</head>
<body>
       

    @auth
    <!-- Ce qui s'affiche lorsque l'utilisateur est connecté -->
    <div>
        @include('home.navbar_yes_conn')
        <h2>Bienvenue, {{$user->fullname}} !</h2>
            <p>Voici vos informations :</p>
            <ul>
                <li><strong>ID:</strong> {{$user->id}}</li>
                <li><strong>Email:</strong> {{$user->email}}</li>
                <li><strong>Numéro de téléphone:</strong> {{$user->phonenumber}}</li>
                <li><strong>Rôle:</strong> {{$user->role}}</li>
            </ul>
        </div>
    <form action="{{route('logout')}}" method="post">
        @csrf
        <div>
            <button type="submit">logout</button>
        </div>
    </form>


    @else
        @include('home.navbar_no_conn')

        <h1>WELCOME TO OUR HOMEPAGE</h1>
        <p>Login or register</p>

      <!--   <a href="{{route('login')}}">login</a>
    <a href="{{route('register')}}">Register</a> -->
    @endauth


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<!--
Salam
@auth
    {{$user->id}}
    {{$user->fullname}}
    {{$user->email}}
    {{$user->phonenumber}}
    {{$user->password}}
    {{$user->role}}
@endauth

-->
