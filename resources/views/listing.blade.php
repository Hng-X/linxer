<!DOCTYPE html>
<html>
<head>
  <title>{{ $teamName }}'s Links | Linxer</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/css/listing.css" rel="stylesheet" type="text/css" />
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
                      <p>Log Out</p>
            <a href="https://slack.com/oauth/authorize?scope=identity.basic,identity.email,identity.team&client_id=104593454705.107498116711&redirect_uri=http://linxer.herokuapp.com/Auth/signin">
              <button class="signin-btn"><span>Log Out From Slack</span></button>
            </a>
          </div>
        </div>
      </header>

      <!--Long Search Tab -->
      <div class="row search">
        <div class = "col-lg-12 col-md-12 col-xs-12 pull-right">
          <form method = "">
            <div class = "input-group">
            <label for = "search-tags" class="fr-tags"> Find Links </label>
            <input class = "form-control search input-lg" data-list = ".list" id = "search-tags" name = "query" placeholder = "Search for links">
            <span class = "input-group-btn">
              <label for = "search-tags-btn" class="fr-tags"> Search Links </label>
              <button id = "search-tags-btn" class="btn search btn-default btn-lg" type="submit">
                <i class = "fa fa-search"></i>
              </button>
            </span>
            </div>
          </form>
        </div>
      </div>

      <!-- Card Section -->
  @foreach($links->chunk(4) as $chunk)
      @foreach($chunk as $link)
      <div class = "flip3D">
        <div class = "front">
              <span>{{ $link->url }}</span>
              <span>{{ $link->title }}</span>
        </div>
        <div class = "back">
              <p>Added by <span>{{ $link->user_id }}</span></p>
              <p>{{ $link->created_at }}</p>
        </div>
      </div>
      @endforeach
  @endforeach


    </div>
</body>

</html>
