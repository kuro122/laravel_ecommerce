<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif



    this is add products file
    <form action="/addproductdetails" method="post"  enctype="multipart/form-data"  >
        @csrf
        Product Name : <input type="text" name="product_name">
        Product Price : <input type="number" name="product_price">
        Product image : <input type="file" name="product_image">
        About Product : <textarea name="product_about" id="" cols="30" rows="10"></textarea>
        <button type="submit">submit</button>
    </form>
</body>
</html>