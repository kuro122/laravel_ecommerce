<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/bookOrder" method="get">
      
        <script
          src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="pk_test_51Mea73SJaP0ximCYXI07sLKrqWkhB8kRf716LpoUMtmDqHRdysPsc7CkEVBuRRWN5l9a58Q4er7Qgahe15Auay1f00zImlBkv4"
          data-amount="999"
          data-name="My Store"
          data-description="Widget"
          data-locale="auto"
          data-currency="usd">
        </script>
        <input type="hidden" name="stripeToken" value="">
      </form>
      
</body>
</html>