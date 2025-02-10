<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<style>
    .range-slider {
        position: relative;
        width: 100%;
    }
    .range-slider input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 6px;
        background: #007bff;
        border-radius: 5px;
        outline: none;
        cursor: pointer;
        position: relative;
    }

    .range-slider input[type="range"]::-webkit-slider-runnable-track {
        height: 6px;
        background: #007bff;
        border-radius: 5px;
    }

    .range-slider input[type="range"]::-moz-range-track {
        height: 6px;
        background: #007bff;
        border-radius: 5px;
    }

    .range-slider input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        background: white;
        border: 2px solid #007bff;
        border-radius: 50%;
        cursor: pointer;
        margin-top: -6px;
        position: relative;
        z-index: 2;
    }

    .range-slider input[type="range"]::-moz-range-thumb {
        width: 18px;
        height: 18px;
        background: white;
        border: 2px solid #007bff;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        margin-top: -6px;
    }
</style>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('/') }}">E-Shop</a>
            {{-- <form class="d-flex" action="" method="GET">
                <input class="form-control me-2" type="search" name="query" placeholder="Search products"
                    aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form> --}}
            <a href="{{ route('cart-index') }}" class="btn btn-primary ms-3"> Cart
                {{ $productcount > 0 ? $productcount : '' }}</a>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/offer1.jpg') }}" class="d-block w-100" alt="Offer 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/offer2.webp') }}" class="d-block w-100" alt="Offer 2">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
    <br>

    <div class="container">
        <div class="container">
            <form class="d-flex search-form" method="GET">
                <input class="form-control filter" type="search" id="filter" name="query"
                    placeholder="Search products" aria-label="Search">
            </form>
        </div>
    </div>

    <!-- Product Section -->
    <div class="container mt-4">
        <div class="row">
            <!-- Filters -->

            <div class="col-md-3">
                <h5>Filters</h5>
                <div class="inn_data_accord">
                    <h3 class="h3_heading">
                        Price Range
                        <i class="fa-solid fa-plus"></i>
                    </h3>

                    <div class="year_range" id="price_range">
                        <div class="selected-value">
                            ₹<span id="selectedPrice">{{ $minPrice }}</span> - ₹{{ $maxPrice }}
                        </div>

                        <div class="range-slider">
                            <input type="range" id="priceRange" min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                step="1" value="{{ $minPrice }}">
                        </div>
                    </div>
                </div>

                <div class="inn_data_accord">
                    <h3 class="h3_heading">
                        Rating
                        <i class="fa-solid fa-plus"></i>
                    </h3>
                    <div class="rating_range" id="rating_range">
                        <div class="selected-value">
                            <span id="selectedRating">{{ $minRating }}</span> - {{ $maxRating }}
                        </div>
                        <div class="range-slider">
                            <input type="range" id="ratingRange" min="{{ $minRating }}" max="{{ $maxRating }}"
                                step="1" value="{{ $minRating }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Listings -->
            <div class="col-md-9">
                <div class="row" id="product-list">
                    @foreach ($products as $data)
                        {{-- @dd($data); --}}
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('images/' . $data->image) }}" class="card-img-top"
                                    alt="{{ $data->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->name }}</h5>
                                    <p class="card-text">₹{{ $data->price }}</p>
                                    <p class="card-text">{{ $data->discount }} % Off</p>
                                    <p class="card-text">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                                class="{{ $i <= $data->rating ? 'fas fa-star' : 'far fa-star' }} text-warning"></i>
                                        @endfor
                                    </p>
                                    <form class="cart_form">
                                        @csrf
                                        <button type="submit" id="add_to_cart_btn" value="{{ $data->id }}"
                                            class="btn btn-primary">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).on('submit', '.cart_form', function(event) {
            event.preventDefault();

            let button = $(this).find('#add_to_cart_btn');
            let product_id = button.val();
            console.log('productid:', product_id);

            $.ajax({
                url: "{{ route('cart-add') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    product_id: product_id
                },
                success: function(response) {
                    if (response.status === 200) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    toastr.error("Something went wrong. Please try again.");
                }
            });
        });

        $(document).ready(function() {
            $('#filter').on('input', function() {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('product-search') }}",
                    type: "GET",
                    data: {
                        query: query
                    },
                    // dataType: "json",
                    success: function(response) {
                        let productList = $('#product-list');
                        productList.empty();
                        if (response.products.length > 0) {
                            $.each(response.products, function(index, product) {
                                let productCard = `
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <img src="{{ asset('images/') }}/${product.image}" class="card-img-top" alt="${product.name}">
                                    <div class="card-body">
                                        <h5 class="card-title">${product.name}</h5>
                                        <p class="card-text">₹${product.price}</p>
                                        <p class="card-text">${star(product.rating)}</p>
                                        <form class="cart_form">
                                            @csrf
                                            <button type="submit" class="btn btn-primary" value="${product.id}">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                                productList.append(productCard);
                            });
                        } else {
                            productList.html(
                                '<p class="text-center text-muted">No products found.</p>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        toastr.error("Something went wrong. Please try again.");
                    }
                });
            });
        });

        function star(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= rating ? '<i class="fas fa-star text-warning"></i> ' :
                    '<i class="far fa-star text-warning"></i> ';
            }
            return stars;
        }


        $(document).ready(function() {
            $('#priceRange').on('input', function() {
                let selectedPrice = $(this).val();

                $('#selectedPrice').text(selectedPrice);

                $.ajax({
                    url: "{{ route('price-filter') }}",
                    type: "GET",
                    data: {
                        price: selectedPrice
                    },
                    success: function(response) {
                        $('#product-list').empty();

                        $.each(response.products, function(index, product) {
                            let productHTML = `
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('images/') }}/${product.image}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">₹${product.price}</p>
                                    <p class="card-text">${generateStars(product.rating)}</p>
                                    <form class="cart_form">
                                        <button type="submit" value="${product.id}" class="btn btn-primary">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                            $('#product-list').append(
                                productHTML);
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            function generateStars(rating) {
                let starsHTML = "";
                for (let i = 1; i <= 5; i++) {
                    if (i <= rating) {
                        starsHTML += '<i class="fas fa-star text-warning"></i>';
                    } else {
                        starsHTML += '<i class="far fa-star text-warning"></i>';
                    }
                }
                return starsHTML;
            }
        });

        $(document).ready(function() {
            $('#ratingRange').on('input', function() {
                let selectedRating = $(this).val();

                $('#selectedRating').text(selectedRating);

                $.ajax({
                    url: "{{ route('rating-filter') }}",
                    type: "GET",
                    data: {
                        rating: selectedRating
                    },
                    success: function(response) {
                        $('#product-list').empty(); 

                        $.each(response.products, function(index, product) {
                            let productHTML = `
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('images/') }}/${product.image}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">₹${product.price}</p>
                                    <p class="card-text">${generateStars(product.rating)}</p>
                                    <form class="cart_form">
                                        <button type="submit" value="${product.id}" class="btn btn-primary">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                            $('#product-list').append(productHTML);
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            function generateStars(rating) {
                let starsHTML = "";
                for (let i = 1; i <= 5; i++) {
                    starsHTML += (i <= rating) ? '<i class="fas fa-star text-warning"></i>' :
                        '<i class="far fa-star text-warning"></i>';
                }
                return starsHTML;
            }
        });
    </script>
</body>

</html>
