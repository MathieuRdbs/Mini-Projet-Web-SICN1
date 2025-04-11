<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container-fluid">
        <span class="toggle-sidebar-btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </span>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-circle"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="{{route('adminprofile')}}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <div>
                                <button type="submit"  class="dropdown-item" id="logout">logout</button>
                            </div>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function() {
     const btn_logout = document.getElementById('logout');
     if (btn_logout) {
       btn_logout.addEventListener('click', function () {
         localStorage.clear();
       });
     }
    });
 </script>