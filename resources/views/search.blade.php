<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
    $('#myForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '/checkcoupon',
            data: $(this).serialize(),
            success: function(response) {
                var data = response.status;
                document.getElementById("myParagraph").innerHTML = data;

                console.log(response);
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
    <form id="myForm">
        @csrf
        <input type="text" name="code" placeholder="Enter coupon code">
        <input type="text" class="form-control p-4" placeholder="Coupon Code" name="price" value="500" style="display: none;">

        <button type="submit">Search</button>
    </form>
    <p id="myParagraph">This is a paragraph.</p>
</body>
</html>




