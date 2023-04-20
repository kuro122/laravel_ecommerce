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
    
    <form id="search-form">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    
 
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div>
     
        <div class="row px-xl-5 pb-3" id="product-container" >

            @foreach($data as $data)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1 product">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="images/{{$data->image}}" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{$data->name}}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>RS. {{$data->price}}</h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="/shopdetails/{{$data->id}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        @auth
                       
                        <a href="/cart/{{Auth::id()}}" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                       @else
                       <a href="/userlogin" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Login</a>
                    @endauth
                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>
{{-- $.ajax({
    //     url: '/your-ajax-url',
    //     success: function(response) {
    //         // Parse the JSON data from the response
    //         var data = JSON.parse(response);
    
    //         // Create the HTML for the new products
    //         var productsHtml = '';
    //         for (var i = 0; i < data.length; i++) {
    //             var product = data[i];
    //             productsHtml += '<div class="col-lg-3 col-md-6 col-sm-12 pb-1 product">' +
    //                 '<div class="card product-item border-0 mb-4">' +
    //                 '<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">' +
    //                 '<img class="img-fluid w-100" src="images/' + product.image + '" alt="">' +
    //                 '</div>' +
    //                 '<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">' +
    //                 '<h6 class="text-truncate mb-3">' + product.name + '</h6>' +
    //                 '<div class="d-flex justify-content-center">' +
    //                 '<h6>RS. ' + product.price + '</h6>' +
    //                 '</div>' +
    //                 '</div>' +
    //                 '<div class="card-footer d-flex justify-content-between bg-light border">' +
    //                 '<a href="/shopdetails/' + product.id + '" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>' +
    //                 '<a href="/cart/{{Auth::id()}}" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>' +
    //                 '</div>' +
    //                 '</div>' +
    //                 '</div>';
    //         }
    
    //         // Replace the existing product container with the new HTML
    //         $('#product-container').html(productsHtml);
    //     }
    // });


 --}}
