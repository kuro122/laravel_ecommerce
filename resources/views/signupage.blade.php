<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="css/sign.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>

<form action="/adminsignup" method="post">
    @csrf
        <label>
          <p class="label-txt">ENTER YOUR NAME</p>
          <input type="text" class="input" name="name" required>
          <div class="line-box">
            <div class="line"></div>
          </div>
        </label>
        <label>
            <p class="label-txt">ENTER YOUR EMAIL</p>
            <input type="text" class="input" name="email" required>
            <div class="line-box">
              <div class="line"></div>
            </div>
          </label>
        <label>
          <p class="label-txt">ENTER YOUR PASSWORD</p>
          <input type="password" class="input" name="password" required>
          <div class="line-box">
            <div class="line"></div>
          </div>
        </label>
        <button type="submit">submit</button>
      </form>
      <!-- Template Javascript -->
    <script src="js/sign.js"></script>
</body>
</html>