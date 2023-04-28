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
      $(document).ready(function() {
  // When a star is clicked, add the 'fas' class to it and remove 'far' class
  $('.star-rating').click(function() {
    $(this).removeClass('far').addClass('fas');
    // Loop through all previous stars and add the 'fas' class to them as well
    $(this).prevAll('.star-rating').removeClass('far').addClass('fas');
    // Loop through all subsequent stars and add the 'far' class to them
    $(this).nextAll('.star-rating').removeClass('fas').addClass('far');
    // Change the color of all filled stars to yellow
    $('.fas').css('color', 'yellow');
    var rating = $(this).data('rating');
    console.log(rating);
    // Set the value of the rating input field to the selected rating
    $('#rating').val(rating);
  });
  
  // Set up submit event for the form
  $('form').submit(function(event) {
    event.preventDefault(); // Prevent the form from submitting normally
    
    // Get the form data
    var formData = {
      rating: $('#rating').val(),
      review: $('#message').val()
    };
    
    // Send the form data to the server using AJAX
    $.ajax({
      type: 'POST',
      url: 'submit-review.php', // Replace with the URL of the server-side script to handle form submission
      data: formData,
      dataType: 'json', // Set the expected data type to JSON
      encode: true
    })
    .done(function(data) {
      // Handle the response from the server
      console.log(data); // Replace with your own code to handle the response
    });
  });
});

    
  </script>
  </head>

<body>

  <div class="col-md-6">
    <h4 class="mb-4">Leave a review</h4>
    <small>Your email address will not be published. Required fields are marked *</small>
    <div class="d-flex my-3">
        <p class="mb-0 mr-2">Your Rating * :</p>
        <div class="text-primary">
          <i class="far fa-star star-rating" data-rating="1"></i>
        <i class="far fa-star star-rating" data-rating="2"></i>
        <i class="far fa-star star-rating" data-rating="3"></i>
        <i class="far fa-star star-rating" data-rating="4"></i>
        <i class="far fa-star star-rating" data-rating="5"></i>

        </div>
    </div>
    <form>
        <div class="form-group">
            <label for="message">Your Review *</label>
            <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
        </div>
        <div class="form-group mb-0">
            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
        </div>
    </form>
</div>
</body>
</html>