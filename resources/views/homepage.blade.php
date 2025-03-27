<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        
    @auth
    <form action="{{route('logout')}}" method="post">
        @csrf
        <div>
            <button type="submit">logout</button>
        </div>
    </form>
    @else
        
        <a href="{{route('login')}}">login</a>
    <a href="{{route('register')}}">Register</a>
    @endauth
</body>
</html>
Salam
@auth
    {{$user->id}}
    {{$user->fullname}}
    {{$user->email}}
    {{$user->phonenumber}}
    {{$user->password}}
    {{$user->role}}
@endauth