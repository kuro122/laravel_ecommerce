<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    
   
   
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        @foreach($data  as  $data)
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td> {{ $data->name}}</td>
            <td>{{$data->price}}</td>
            <td>{{$data->description}}</td>
            <td><a href="/admin_product_delete/{{$data->id}}"><button>Delete</button></a>  </td>
            <td><button>Update</button></td>
          </tr>
        </tbody>
        @endforeach
      </table>
</body>
</html>
{{-- why  - fast api is build for speed and provides high performace by using asynchrounous programing 
  it is used to create high performacence apis and microservices
  easy to use : it provides easy and concise syntax which allow developers to build apis quickly and deploy
  automatic api documentaion : fast api generate automatic documentation for api  using swagger ui
  fast api uses pydantic for data validation and serialization 
  dependency injection
  fully support for asynchrouns programming 
  asgi 
  pydantic
  swagger ui
  production ready 
  Overall, FastAPI is a powerful and easy-to-use web framework for building high-performance APIs and microservices with Python. 
  Its features make it an ideal choice for building modern, scalable, and production-ready web applications. --}}
