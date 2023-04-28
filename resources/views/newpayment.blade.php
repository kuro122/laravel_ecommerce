<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://js.stripe.com/v3/"></script>
<script>
    function stripeTokenHandler(token) {
  // Set the value of the hidden input field to the token ID.
  document.getElementById('stripeToken').value = token.id;
console.log(token.id);
  // Submit the form.
  var form = document.getElementById('payment-form');
  form.submit();
}

</script>
    <title>Document</title>
</head>
<body>
    <form action="/chargenow" method="POST" id="payment-form">
        @csrf
        <!-- other form fields -->
        <input type="hidden" name="stripeToken" id="stripeToken">
        <button type="submit" id="submit-button" class="btn btn-primary">Submit Payment</button>
      </form>
       
</body>
</html>
