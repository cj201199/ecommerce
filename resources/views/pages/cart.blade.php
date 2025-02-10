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
    .error {
        color: red;
    }
</style>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('/') }}">E-Shop</a>
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

    <!-- Cart Section -->
    <div class="container mt-5">
        <h2>Shopping Cart</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($cart)
                    @foreach ($cart as $data)
                        @php
                            $total = 0;
                            $itemtotal = $data->product->price * $data->quantity;
                            $total += $itemtotal;
                        @endphp
                        <tr>
                            <td>
                                <img style="height: 50px;width:100px"
                                    src="{{ asset('images/' . $data->product->image) }}" class="card-img-top"
                                    alt="{{ $data->name }}">
                                {{ $data->product->name }}
                            </td>
                            <td>
                                <input type="number" class="form-control quantity-input"
                                    data-price="{{ $data->product->price }}" data-id="{{ $data->id }}"
                                    value="{{ $data->quantity }}" min="1">
                            </td>
                            <td class="product-price">{{ $data->product->price * $data->quantity }}</td>
                            <td>
                                <a href="#" class="btn btn-danger remove_cart"
                                    data-cartid="{{ $data->id }}">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    @php
        $total = $total ?? 0;
    @endphp
    <div style="padding-left: 827px">
        <p> <strong>TOTAL: </strong> ₹<span
                id="total-price">{{ isset($total) ? number_format($total, 2) : '0.00' }}</span> </p>
        @if ($total > 0)
            <p> <strong>SHIPPING: </strong> {{ isset($total) ? '₹100.00' : '₹0' }} </p>
        @else
            <p> <strong>SHIPPING: </strong> ₹0.00 </p>
        @endif
        @if ($total > 0)
            <p> <strong>GRAND TOTAL: </strong> ₹<span id="grand-total">
                    {{ isset($total) && $total > 0 ? number_format($total + 100, 2) : '0' }}</span> </p>
        @else
            <p> <strong>GRAND TOTAL: </strong> ₹0.00 </p>
        @endif
    </div>

    <!-- Place Order Form -->
    <div class="container mt-5">
        <h2>Place Order</h2>
        <form id="order_form">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name">
                <input type="hidden" name="productid" id="productprice"
                    value="{{ isset($total) ? $total + 100 : 100 }}">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address">
            </div>
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" class="form-control" id="mobile" maxlength="10" minlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')" name="mobile">
            </div>
            <button type="submit" id="order_btn" class="btn btn-success">Place Order</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
        integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            updatetotal();
        });

        $(document).on('input', '.quantity-input', function() {
            let quantity = $(this).val();
            let price = $(this).data('price');
            let totalPrice = quantity * price;
            $(this).closest('tr').find('.product-price').text(totalPrice.toFixed(2));
            updatetotal();
        });

        function updatetotal() {
            let total = 0;
            $('.quantity-input').each(function() {
                let quantity = parseInt($(this).val());
                let price = parseFloat($(this).data('price'));
                total += quantity * price;
            });

            $('#total-price').text(total.toFixed(2));
            $('#grand-total').text((total + 100).toFixed(2));
            $('#productprice').val((total + 100).toFixed(2));
        }

        $(document).on('click', '.remove_cart', function(event) {
            event.preventDefault();

            let product_id = $(this).data('cartid');
            // console.log('product:', product_id);

            $.ajax({
                url: "{{ route('cart-remove') }}",
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
            $('#order_form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    address: {
                        required: true,
                        minlength: 5
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                },
                messages: {
                    name: {
                        required: "Please enter a name"
                    },
                    address: {
                        required: "Please enter an address",
                        minlength: "Address must be at least 5 characters long"
                    },
                    mobile: {
                        required: "Please enter your mobile number",
                    },
                },
                submitHandler: function(form, event) {
                    event.preventDefault();

                    var formData = new FormData(form);
                    $('#order_btn').prop('disabled', true).text('Processing...');

                    $.ajax({
                        url: "{{ route('add-order') }}",
                        type: "POST",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === 200) {
                                toastr.success(response.message);
                                setTimeout(() => window.location.reload(), 2000);
                            } else {
                                toastr.error("There was an issue. Please try again.");
                            }
                            $('#order_btn').prop('disabled', false).text('Place Order');
                        },
                        error: function() {
                            toastr.error("Something went wrong. Please try again.");
                            $('#order_btn').prop('disabled', false).text('Place Order');
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
