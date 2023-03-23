<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/checkcoupon" method="post">
        @csrf
        <input type="text" name="code" placeholder="Enter coupon code">
        <button type="submit">Search</button>
    </form>
</body>
</html>




