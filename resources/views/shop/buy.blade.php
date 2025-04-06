<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sportero's Gear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        body {
            padding-top: 130px; 
        }
        
        /* Compact sidebar styling */
        .sidebar {
            width: 250px;
            position:fixed;
            top: 140px;
            bottom: 0;
            left: 0;
            background: white;
            padding: 20px;
            overflow-y: auto;
            box-shadow: 1px 0 5px rgba(0,0,0,0.05);
            z-index: 4;
        }
        
        /* Main content area */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            z-index: 4;
        }
    .product-card {
    width: 340px; /* Fixed width */
    height: 400px; /* Fixed height for consistency */
    display: flex; /* Use flexbox to control the card layout */
    flex-direction: column; /* Stack elements vertically */
    justify-content: space-between; /* Ensure spacing between elements */
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: transform 0.3s ease-in-out;
}
    .product-card:hover {
        transform: translateY(-5px);
    }
    .product-card img {
        height: 200px;
        object-fit: cover;
    }
    .product-card .card-body {
        display: flex;
        flex-direction: column;
        padding: 10px;
    }
    .product-card .badge {
        font-size: 0.85rem;
    }
    .product-card .card-title {
        font-size: 1rem;
        font-weight: 600;
    }
    .product-card .card-text {
    font-size: 0.875rem;
    color: #6c757d;
    overflow: hidden; /* Hide overflow for descriptions */
    text-overflow: ellipsis; /* Add ellipsis for overflow text */
    white-space: nowrap; /* Prevent text from wrapping */
    max-height: 120px; /* Control the height of the description */
}
    .product-card .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #ff6600;
        margin-left:15px;
    }
    .product-card .btn-add-to-cart {
        border-radius: 8px;
        font-size: 1rem;
        padding: 10px 20px;
        background-color:rgb(14, 196, 35);
        color: white;
        border: none;
    }
    .product-card .btn-add-to-cart:hover {
        background-color:rgb(255, 102, 0);
    }
    button:active {
    transform: scale(0.96);
    filter: brightness(0.95);
    transition: all 0.05s ease;
}

        /* Filter sections */
        .filter-section {
            margin-bottom: 1.5rem;
        }
        .filter-section h5 {
            font-size: 1rem;
            margin-bottom: 0.75rem;
            color: #333;
            font-weight: 600;
        }
        .filter-option {
            margin-bottom: 0.5rem;
        }
        .filter-option label {
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
        }
        #btn_filter{
            background-color:#212529;
            border:none;
            padding-bottom:8px;
        }

/* Tooltip (cursor-following) styles */
.tooltip-description {
    display: none; /* Initially hidden */
    position: absolute;
    padding: 10px;
    background-color: white; /* White background for tooltip */
    color: black; /* Black text color */
    border-radius: 6px;
    font-size: 1rem;
    width: 100%; /* Set width to match the card width */
    max-width: 100%; /* Ensure it doesn't overflow */
    z-index: 9999;
    pointer-events: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional shadow for better visibility */
    opacity: 0;
    transition: opacity 0.2s ease, transform 0.1s ease;
    top: 0;
    left: 0;
    transform: translateY(-100%); /* Default position above the card */
}

/* Show tooltip on hover */
.product-card:hover .tooltip-description {
    display: block;
    opacity: 1;
    transform: translateY(-10px); /* Move tooltip slightly up */
}

/* Tooltip Arrow */
.product-card:hover .tooltip-description::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 10px solid white; /* Arrow pointing to the card */
}


    </style>
</head>
<body>
    <!-- Navbar (included from partial) -->
    @include('home.navbar_conn')

    <!-- Sidebar Filters -->
    <div class="sidebar">
        
        <div class="filter-section">
            <h5>Category Type</h5>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Archery" >
                    <label class="form-check-label" for="Archery">Archery</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Martial Arts" >
                    <label class="form-check-label" for="Martial Arts">Martial Arts</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Martial Weapons" >
                    <label class="form-check-label" for="Martial Weapons">Martial Weapons</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Tennis" >
                    <label class="form-check-label" for="Tennis">Tennis</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Swimming" >
                    <label class="form-check-label" for="Swimming">Swimming</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Basketball" >
                    <label class="form-check-label" for="Basketball">Basketball</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Football" >
                    <label class="form-check-label" for="Football">Football</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="Volleyball" >
                    <label class="form-check-label" for="Volleyball">Vollyball</label>
                </div>
            </div>
            <!-- Add other categories here -->
        </div>
        
        <div class="filter-section">
            <h5>Price Range</h5>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="price1">
                    <label class="form-check-label" for="price1">Under 100 DHS</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="price2">
                    <label class="form-check-label" for="price2">100 - 400 DHS</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="price3">
                    <label class="form-check-label" for="price3">400 - 1000 DHS</label>
                </div>
            </div>
            <div class="filter-option">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="price" id="price4">
                    <label class="form-check-label" for="price4"> Over 1000 DHS</label>
                </div>
            </div>
            <!-- Add other price ranges here -->
        </div>
        
        <button class="btn btn-primary btn-sm w-100 mb-2" id="btn_filter">Apply Filters</button>
        <button class="btn btn-outline-secondary btn-sm w-100" id="resetFilters">Reset All</button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <!-- Mobile filter toggle -->
    <button class="btn btn-sm btn-outline-primary mb-3 d-lg-none" id="filterToggle">
        <i class="bi bi-funnel"></i> Filters
    </button>
    
    <h4 class="mb-4">Sports Equipment</h4>
    
    <!-- Add product display here, inside main-content -->
    <div class="d-flex justify-content-start flex-wrap" style="gap: 1rem;">
        @if($products->isNotEmpty()) 
        @foreach($products as $product)
            <div class="product-card m-3 card border-0 position-relative" data-category="{{ $product->category->category_name }}">
                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">

                <div class="card-body">
                    <span class="badge mb-2" id="btn_filter">{{ $product->category->category_name }}</span>
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text" title="{{ $product->description }}">
                        {{ \Str::limit($product->description, 100, '...') }}
                    </p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="price">{{ $product->price }}DHS</span>
                        <button class="btn btn-sm btn-primary btn-add-to-cart" >Add to Cart</button>
                    </div>
                </div>
                <!-- Tooltip Description (Full Description) -->
                <div class="tooltip-description">
                    {{ $product->description }}
                </div>
            </div>
        @endforeach
        @else
            <p class="text-center">There are no products.</p>
        @endif
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.getElementById('btn_filter').addEventListener('click', function() {
    // Get selected categories
    let selectedCategories = [];
    document.querySelectorAll('.form-check-input[type="checkbox"]:checked').forEach(checkbox => {
        selectedCategories.push(checkbox.id.toLowerCase()); // Convert category name to lowercase
    });

    // Get selected price range
    let selectedPriceRange = getSelectedPriceRange();

    // Apply filter based on selected categories and price range
    filterProducts(selectedCategories, selectedPriceRange);
});

// Function to get selected price range
function getSelectedPriceRange() {
    let priceRange = null;
    document.querySelectorAll('.form-check-input[name="price"]:checked').forEach(input => {
        priceRange = input.id; // Get selected price range ID
    });
    return priceRange;
}

// Filter function to show/hide products based on selected categories and price range
function filterProducts(categories, priceRange) {
    const searchQuery = new URLSearchParams(window.location.search).get('query')?.toLowerCase() || '';
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productCategory = product.getAttribute('data-category').toLowerCase();
        const priceText = product.querySelector('.price').textContent.replace('DHS', '').trim();
        const productPrice = parseFloat(priceText);
        const productName = product.querySelector('.card-title').textContent.toLowerCase();
        const productDesc = product.querySelector('.card-text').textContent.toLowerCase();

        // MODIFIED SEARCH LOGIC (PRICE-ONLY FIRST)
        const searchMatch = !searchQuery || 
            priceText.includes(searchQuery) ||  // Check price digits FIRST
            productName.includes(searchQuery) || 
            productCategory.includes(searchQuery) || 
            productDesc.includes(searchQuery);

        // Keep existing category/price range checks
        const categoryMatch = categories.length === 0 || categories.includes(productCategory);
        const priceMatch = !priceRange || isPriceInRange(productPrice, priceRange);

        // CHANGED TO PRIORITIZE PRICE SEARCH
        product.style.display = (searchMatch && categoryMatch && priceMatch) ? 'flex' : 'none';
    });
}

// Function to check if the product's price is within the selected price range
function isPriceInRange(price, priceRange) {
    switch (priceRange) {
        case 'price1': 
            return price < 100;
        case 'price2': 
            return price >= 100 && price <= 500;
        case 'price3': 
            return price >= 500 && price <= 1000;
        case 'price4':
            return price > 1000;
        default:
            return true; 
    }
}

// Reset filters function

// Reset filters function - single event listener
document.getElementById('resetFilters').addEventListener('click', function() {
    // Uncheck all filters
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
        checkbox.checked = false;
    });

    // Reset product visibility
    filterProducts([], null); // Show all products if no filters are applied
    
    // Clear search query from URL without page reload
    const url = new URL(window.location.href);
    if (url.searchParams.has('query')) {
        url.searchParams.delete('query');
        window.history.pushState({}, '', url);
    }
    
    // Clear search input if it exists
    const searchInput = document.querySelector('input[type="search"]');
    if (searchInput) {
        searchInput.value = '';
    }
});
const cards = document.querySelectorAll('.card');
cards.forEach(card => {
    card.classList.add('visible');
});


document.addEventListener('DOMContentLoaded', function () {
    // Check for search query
    const searchInput = new URLSearchParams(window.location.search).get('query');
    // Check for category filter from navbar
    const categoryFilter = new URLSearchParams(window.location.search).get('category');
    
    // Handle search if present
    if (searchInput) {
        const searchQuery = searchInput.toLowerCase();
        const productCards = document.querySelectorAll('.product-card');

        productCards.forEach(card => {
            const productName = card.querySelector('.card-title').textContent.toLowerCase();
            const productCategory = card.getAttribute('data-category').toLowerCase();
            const productPrice = card.querySelector('.price').textContent.toLowerCase();
            const productDescription = card.querySelector('.card-text').textContent.toLowerCase();

            // Check if search matches name, category, price or description
            const matches = 
                productName.includes(searchQuery) || 
                productCategory.includes(searchQuery) || 
                productPrice.includes(searchQuery) ||
                productDescription.includes(searchQuery);

            // Show/hide cards based on match
            card.style.display = matches ? 'flex' : 'none';
        });
    }
    
    // Handle category filter from navbar if present
    if (categoryFilter) {
        // Check the corresponding checkbox
        const checkbox = document.getElementById(categoryFilter);
        if (checkbox) {
            checkbox.checked = true;
            
            // Apply the filter
            const categories = [categoryFilter.toLowerCase()];
            filterProducts(categories, null);
        }
    }
});
    </script>
    
    
</body>
</html>