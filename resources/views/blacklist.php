<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h1 {
            text-align: center;
        }
        
        .search-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .search-box {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        
        .search-button {
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }
        
        .response-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Search Page</h1>
    
    <div class="search-container">
        <input type="text" id="search-input" class="search-box" placeholder="Enter your domain name">
        <button type="button" id="search-button" class="search-button">Search</button>
    </div>

    <div class="response-container">
        <pre id="response"></pre>
    </div>

    <script type="text/javascript">
     
        const api_url = "http://blacklist.kuroit.co.uk/api/delistdetails?apikey=9e4JJUDrP4jEF0nQ6dv4HUdSd5Xw9qGz&ip=124.253.228.37";
    async function getUser() {
      
      // Making an API call (request)
      // and getting the response back
      const response = await fetch(api_url);
      response.setHeader("Access-Control-Allow-Origin", "*");


      // Parsing it to JSON format
      const data = await response.json();
      console.log(data,'results-0-- ');
    }
    getUser();
    </script>
    
</body>
</html>
