<div id="myCarousel" class="carousel slide mb-0" data-bs-ride="carousel" data-bs-interval="4000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active slide-1">
            <div class="overlay"></div> <!-- Overlay -->
                <div class="container">
                <div class="carousel-caption text-start">
                <h1>WELCOME TO SPORTERO</h1>
                <p>A place where you can find your favorite sport articles.</p>
                <p><a class="btn btn-lg btn-primary" href="/contact_us">Learn more</a></p>
            </div>
        </div>
    </div>
      <div class="carousel-item slide-2">
      <div class="overlay"></div> <!-- Overlay -->
        <div class="container">
          <div class="carousel-caption">
            <h1>SEE OUR LATEST DEAL</h1>
            <p>We offer you all good products with less costing price. Sign up or Login and add everything to your cart.</p>
            <p><a class="btn btn-lg btn-primary" href="{{route('login')}}">Login</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item slide-3">
      <div class="overlay"></div> <!-- Overlay -->
        <div class="container">
          <div class="carousel-caption text-end">
            <h1>200% SATISFACTION </h1>
            <p>Our team is always ready to accompagny you before and after your purchasing. Feel free to contact us !</p>
            <p><a class="btn btn-lg btn-primary" href="{{route('contact_us')}}">Contact us</a></p>
          </div>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- OTHER Display -->
<div class="card bg-dark text-white rounded-0">
  <img class="card-img" src="{{asset('img/homepage/sport4.jpg')}}" alt="Card image">
  <div class="card-img-overlay">
    <h5 class="card-title display-5">Our Products</h5>
    <p class="card-text">Scroll down to see few of our products. Some of them have been added recently. <br> Don't hesitate to choose and add in your cart !</p>

    <p class="card-text">Last updated 3 mins ago</p>
  </div>
</div>

<!-- Some products presentation -->
<div class="container my-5">
    <div class="box p-4 shadow-lg">
        <h2 class="text-center mb-4">Our products</h2>

        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($products->chunk(3) as $index => $productChunk)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="row">
                        @foreach($productChunk as $product)
                        <div class="col-md-4">
                            <div class="card text-white border-0">
                                <img src="{{ asset('productimages/' . basename($product->image)) }}" class="card-img" alt="{{ $product->name }}">
                                <div class="card-img-overlay d-flex flex-column justify-content-center text-center bg-dark bg-opacity-50">
                                    <h4 class="card-title">{{ $product->name }}</h4>
                                    <p class="card-text">{{ Str::limit($product->description, 80) }}</p>
                                    @auth
                                    <a href="{{ route('product.showDetails', $product->id) }}" class="btn btn-warning">See More</a>
                                    @else
                                    <a href="{{ route('login') }}" class="btn btn-warning">See More</a>
                                    @endauth
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Boutons de navigation -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    </div>
</div>

<style>
    .box {
        background: rgba(248, 249, 250, 0.8); /* Ajout de transparence */
        border-radius: 15px;
        border: 2px solid #dee2e6;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>



