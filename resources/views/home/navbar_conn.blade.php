<!-- NAV BAR if USER NOT CONNECTED -->

<header class="p-3 text-bg-dark fixed-top" >
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="{{route('homepage')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <img src="{{ asset('img/Sportero_transparent-.png') }}" alt="Mon Icône" width="130" height="112" class="me-2">
            </a>
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 align-items-center">
            <li><a href="{{route('homepage')}}" class="nav-link px-2 text-white mx-3">Home</a></li>

            <li class="nav-item dropdown mx-3">
                <a class="nav-link dropdown-toggle px-2 text-white" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Products 
                <!-- <span class="ms-1"><i class="bi bi-chevron-down"></i></span> -->
                </a>
                <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                      @foreach($categories as $categorie)
                      <li><a class="dropdown-item" href="#">{{$categorie->category_name}}</a></li>
                      @endforeach

                        <!-- <li><a class="dropdown-item" href="#">Category 1</a></li>
                        <li><a class="dropdown-item" href="#">Category 2</a></li>
                        <li><a class="dropdown-item" href="#">Category 3</a></li> -->
                </ul>
            </li>
            <li><a href="#" class="nav-link px-2 text-white mx-3">Contact</a></li>
            @auth
            <li class="nav-item mx-2">
              <a class="nav-link position-relative px-2 text-white" href="{{route('cart')}}">
              <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{$cartItemCount}}<!-- Ce chiffre sera dynamique plus tard -->
              </span>
            </a>
            </li>
            @endauth
            </ul>

            
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
              <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search" >
            </form>
            @auth
            <div class="dropdown text-end">
              <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="true">
                <img src="{{asset('img/man.png')}}" alt="mdo" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small " data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34.2857px, 0px);">
                <li><a class="dropdown-item" href="{{route('user.profile')}}">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <form action="{{route('logout')}}" method="post">
                  @csrf
                  <li><button class="dropdown-item" type="submit">logout</button></li>
                </form>
              </ul>
            </div> 
                
            @else
                
            <div class="text-end">
              <a href="{{route('login')}}" class="btn btn-outline-light me-2">Login</a>
              <a href="{{route('register')}}" class="btn btn-warning">Register</a>
            @endauth
            
            </div>
          </div>
        </div>
      </header>