<!DOCTYPE html>
<html>
<head>
  <title>{{ $teamName }}'s Links | Linxer</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ env('APP_URL') }}/css/listing.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://use.fontawesome.com/c8c67c47f4.js"></script>
  	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
</head>

<body>

<div class = "w3-container">
  <!--Header Section -->
    <header>
      <div class="container header-container">
        <div class="team-name">
          <a href="/">Team <span>{{ $teamName }}</span></a>
        </div>
        <div class="search-box">
          <span><i class="glyphicon glyphicon-search" aria-hidden="true"></i></span>
          <input type="search" placeholder="Enter a keyword">
        </div>
      </div>
    </header>

  <!-- Card section -->
    <div class = "w3-row-padding">
      <div class = "w3-col m3 w3-panel w3-card-4">
         <header class = "w3-container w3-red">
            <p>Header container for card </p>
         </header>

         <div class = "w3-container">
           <p> Containers basic information of the links added by the user</p>
         </div>

         <footer class = "w3-container w3-red">
           <p> Containers footer's information better</p>
         </footer>

       </div>

      <div class = "w3-col m3 w3-panel w3-card-4">
        <header class = "w3-container w3-red">
           <p>Header container for card </p>
        </header>

        <div class = "w3-container">
          <p> Containers basic information of the links added by the user</p>
        </div>

        <footer class = "w3-container w3-red">
          <p> Containers footer's information better</p>
        </footer>
      </div>

      <div class = "w3-col m3 w3-panel w3-card-4">
        <header class = "w3-container w3-red">
           <p>Header container for card </p>
        </header>

        <div class = "w3-container">
          <p> Containers basic information of the links added by the user</p>
        </div>

        <footer class = "w3-container w3-red">
          <p> Containers footer's information better</p>
        </footer>
      </div>

      <div class = "w3-col m3 w3-panel w3-card-4">
        <header class = "w3-container w3-red">
           <p>Header container for card </p>
        </header>

        <div class = "w3-container">
          <p> Containers basic information of the links added by the user</p>
        </div>

        <footer class = "w3-container w3-red">
          <p> Containers footer's information better</p>
        </footer>

      </div>
    </div>

    <footer class= "w3-container">
      <div class="w3-container">
        <ul class="w3-pagination">
          <li><a href="#">&laquo;</a></li>
          <li><a class="w3-green" href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li><a href="#">&raquo;</a></li>
        </ul>
      </div>
    </footer>
  </div>
</body>

</html>
