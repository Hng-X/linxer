<!DOCTYPE html>
<html>
<head>
  <title>{{ $teamName }}'s Links | Linxer</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ env('APP_URL') }}/css/listing.css" rel="stylesheet" type="text/css" />
  <link href="/css/home.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
</head>

<body>
    <div class = "container">
      <!--Header Section -->
      <header>
        <div class="header__wrapper">
          <div class="logo">
            <h1 class="logo__text">Linxer</h1>
          </div>
          <div class="signin">
                      <p>Your team's already using Linxer?</p>
            <a href="https://slack.com/oauth/authorize?scope=identity.basic,identity.email,identity.team&client_id=104593454705.107498116711&redirect_uri=http://linxer.herokuapp.com/Auth/signin">
              <button class="signin-btn"><span>Log Out From Slack</span></button>
            </a>
          </div>
        </div>
      </header>

      <!--Long Search Tab -->
      <div>

      </div>

      <!-- Card Section -->
      <div>

      </div>

      <!--Footer Section -->
      <div>
        
      </div>
    </div>
</body>

</html>
