<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EShopper - Bootstrap Shop Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
          document.querySelector('#searchIcon').addEventListener("click", function(e) {
            e.preventDefault();
            document.querySelector('#search-form').submit();
          });
        });
      </script>
       <script>
        $(function() {
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
    
                var query = $('input[name="search"]').val();
                $.ajax({
                    url: "/ajax_search",
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        var data = response.data;
                        console.log(data,'====================');
                        var productsHtml = '';
                        for (var i = 0; i < data.length; i++) {
                            var product = data[i];
                            console.log(product.price,'this is i value');
    
                            productsHtml += '<div class="col-lg-3 col-md-6 col-sm-12 pb-1 product">' +
                                '<div class="card product-item border-0 mb-4">' +
                                '<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">' +
                                '<img class="img-fluid w-100" src="images/' + product.image + '" alt="">' +
                                '</div>' +
                                '<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">' +
                                '<h6 class="text-truncate mb-3">' + product.name + '</h6>' +
                                '<div class="d-flex justify-content-center">' +
                                '<h6>RS. ' + product.price + '</h6>' +
                                '</div>' +
                                '</div>' +
                                '<div class="card-footer d-flex justify-content-between bg-light border">' +
                                '<a href="/shopdetails/' + product.id + '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>' +
                                '<a href="/cart/{{Auth::id()}}" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }
                            // Replace the existing product container with the new HTML
                        $('#product-container').html(productsHtml);
                
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <script type="text/javascript">
    $(document).on('click', '.delete-item', function() {
    console.log('working');
    var userId = "{{ $userid }}";
    var itemId = $(this).data('id');
    console.log(itemId);
    $.ajax({
        url: '/destroy/' + itemId,
        type: 'GET',
        data: {
            '_token': '{{ csrf_token() }}',
        },
        success: function(response) {
            console.log('this si ssuccess file -------------------',response)
            $('#item-' + itemId).remove();
            document.getElementById("myParagraph").innerHTML = response.total;
            document.getElementById("discountprice").innerHTML = response.total+500;
            console.log('success called cart url',response.total);
        }
    });
          
});
// caching , profiling load balancing, anychronous processing

// coupon 
$(document).ready(function() {
            
    $('#myFormcoupon').on('submit',  function(e) {
        var input = document.getElementById("myInput");
        var data = parseFloat($("#myParagraph").text());
                input.value = data;
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/checkcoupon',
            data: $(this).serialize(),
            success: function(response) {
                var res = response.status;
                var prices = document.getElementById("myParagraph").innerHTML = data;
                var mainprice = prices - res;
                document.getElementById("discountprice").innerHTML = mainprice+500;
                document.getElementById('discountpercent').innerHTML = res;
                document.getElementById('totprice').innerHTML = data;
                console.log(data,'-------------------------',prices);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });
   
});

        </script>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    @if(Auth::check())
                        <a class="text-dark" href="/logout">Logout</a>
                     @else
                        <a class="text-dark" href="/adminlogin">Login</a>
                        @endif
                
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
      
    </div>
    <!-- Topbar End -->



    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach($cdata as $data)
                        <tr id="item-{{ $data->id }}">
                            <td class="align-middle"><img src="{{ asset('images/'.$data->image) }}" alt="" style="width: 50px;"> {{$data->name}}</td>
                           
                            <td class="align-middle "  >{{$data->no_of_items}}</td>

                            <td class="align-middle" id="product-{{ $data->id }}" value="{{$data->price}}"  >{{$data->price*$data->no_of_items}}</td>
                            
                            <td class="align-middle"><button type="button" class="btn btn-sm btn-primary  delete-item"  data-id="{{ $data->id }}" ><i class="fa fa-times"></i></button></td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-5" id="myFormcoupon">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="myInput" name="price" value="{{$total}}" style="display: none;">

                        <input type="text" class="form-control p-4" placeholder="Coupon Code" name="code">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit" >Apply Coupon</button>
                        </div>
                    </div>
                </form>
                
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium" id="myParagraph">{{$total}}</h6>
                              - <span id="discountpercent"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">500</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold" id="discountprice">{{$total+500}} </h5>
                        
                        </div>
                        <a href="/checkout/{{$userid}}"> <button class="btn btn-block btn-primary my-3 py-3">   Proceed To Checkout</button></a> 
                    </div>
                </div>
            </div>
        </div>  
    </div>
    <!-- Cart End -->
  <script>
    //  product increment
var rate =  0;
$('.quantity button' ).on('click', function () {
        var itemId = $(this).data('id');
        console.log(itemId,'item iddd');
        const price = $('#product-' + itemId).attr('value');
        console.log(price);

        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
            
            var totalprice = price * newVal;
            document.getElementById('product-' + itemId).innerHTML = totalprice;
            // document.getElementById('myParagraph').innerHTML = totalprice;
            rate = newVal*price;
            console.log(newVal,'-------------', rate);
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            var totalprice = price * newVal;
            document.getElementById('product-' + itemId).innerHTML = totalprice;
            } else {
                newVal = 0;
                var totalprice = price * newVal;
            document.getElementById('product-' + itemId).innerHTML = totalprice;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });

  </script>

   <!-- Footer Start -->
   <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
    <div class="row px-xl-5 pt-5">
        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
            <a href="" class="text-decoration-none">
                <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
            </a>
            <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA</p>
            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                    <div class="d-flex flex-column justify-content-start">
                        <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                        <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                        <a class="text-dark mb-2" href="detail.html"><i class="fa fa-angle-right mr-2"></i>Shop Detail</a>
                        <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                        <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                        <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                    <form action="">
                        <div class="form-group">
                            <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                required="required" />
                        </div>
                        <div>
                            <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row border-top border-light mx-xl-5 py-4">
        <div class="col-md-6 px-xl-0">
            <p class="mb-md-0 text-center text-md-left text-dark">
                &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights Reserved. Designed
                by
                <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
        <div class="col-md-6 px-xl-0 text-center text-md-right">
            <img class="img-fluid" src="img/payments.png" alt="">
        </div>
    </div>
</div>
<!-- Footer End -->
    

<!-- Back to Top -->
<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>

<!-- Template Javascript -->
{{-- <script src="{{asset('js/main.js')}}"></script> --}}
</body>

</html>
