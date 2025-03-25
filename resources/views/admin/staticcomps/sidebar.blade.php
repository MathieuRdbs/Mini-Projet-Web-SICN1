<div class="sidebar" id="sidebar">
    <div class="brand-logo">
        <i class="fas fa-tachometer-alt"></i> <span>AdminPanel</span>
    </div>
    <div class="d-flex flex-column h-100">
        <ul class="nav flex-column mt-4">
            <li class="nav-item">
                <a href="{{route('users')}}" class="nav-link @if(request()->routeIs('users')) active @endif">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('categories')}}" class="nav-link @if(request()->routeIs('categories')) active @endif">
                    <i class="fa-solid fa-table"></i> <span>Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-box"></i> <span>Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-shopping-cart"></i> <span>Orders</span>
                </a>
            </li>
        </ul>
    </div>
</div>