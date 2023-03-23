<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Create New Coupon </h1>
    <form action="/coupondetails" method="post">
        @csrf
        Enter Code : <input type="text" name="code">
        <br>
        Enter Discount : <input type="number" name="discount">
        <br>
        Usage Limit : <input type="text" name="usagelimit">
        <br>
        Usage Count : <input type="text" name="usagecount">
        <br>
        Start Date : <input type="date" name="startdate">
        <br>
        End Date : <input type="date" name="enddate">
        <br>
        <button type="submit">submit</button>
    </form>
</body>
</html>