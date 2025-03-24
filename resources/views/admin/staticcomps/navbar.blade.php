<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container-fluid">
        <span class="toggle-sidebar-btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </span>
        
        <form action="{{route('logout')}}" method="post">
            @csrf
            <div>
                <button type="submit" class="btn btn-primary">logout</button>
            </div>
        </form>
    </div>
</nav>