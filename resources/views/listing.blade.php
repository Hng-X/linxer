<!DOCTYPE html>
<html>
<head>
	<title>Linxer | Links </title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="{{ env('APP_URL') }}/css/listing.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>
<body>
<div class="links-container">
	<div class="">
		<header>
			<div class="container header-container">
				<div class="team-name">
					<a href="/">Team <span><?php echo $teamName ?></span></a>
				</div>
				<div class="search-box">
					<span><i class="fa fa-search" aria-hidden="true"></i></span>
					<input type="search" placeholder="eg. donald trump won">
				</div>
			</div>
		</header>
		<section>
			<div class="container welcome-note">
				<article class="well">
					<h4>Oh Hey!</h4>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum
					</p>
				</article>
			</div>
		</section>
		<section class="links">
			<div class="container links-row">
				<div class="links-row__item">
					<div class="item-source">
						<p><span>{{ $teamName }}</span><i class="fa fa-caret-right" aria-hidden="true"></i><span>General</span></p>
					</div>
					<div class="item-details">
						<div class="item-title">
							<div class="item-highlight__attached" >
								<span>Lindaikeji.com</span>
							</div>
							<a href={{ $links }}>Shalvah has no state of origin</a>
						</div>
						<div class="item-highlight">
							<div class="item-highlight__details">
								<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</span>
							</div>
							<div class="item-highlight__image">
							</div>
						</div>
					</div>
					<div class="item-info">
						<div class="item-info__name">
							<p>Author:<span>Shalvah</span></p>
						</div>
						<div class="item-info__date">
							<p>11/06/2016</p>
						</div>
					</div>
				</div>
				<div class="links-row__item">
					<div class="item-source">
						<p><span>{{ teamName }}</span><i class="fa fa-caret-right" aria-hidden="true"></i><span>General</span></p>
					</div>
					<div class="item-details">
						<div class="item-title">
							<div class="item-highlight__attached" >
								<span>Lindaikeji.com</span>
							</div>
							<a href= {{ $links }}>Shalvah has no state of origin</a>
						</div>
						<div class="item-highlight">
							<div class="item-highlight__details">
								<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</span>
							</div>
							<div class="item-highlight__image">
							</div>
						</div>
					</div>
					<div class="item-info">
						<div class="item-info__name">
							<p>Author:<span>Shalvah</span></p>
						</div>
						<div class="item-info__date">
							<p>11/06/2016</p>
						</div>
					</div>
				</div>
				<div class="links-row__item">
					<div class="item-source">
						<p><span>{{ teamName }}</span><i class="fa fa-caret-right" aria-hidden="true"></i><span>General</span></p>
					</div>
					<div class="item-details">
						<div class="item-title">
							<div class="item-highlight__attached" >
								<span>Lindaikeji.com</span>
							</div>
							<a href="https://should-be-dynamically-generated">Shalvah has no state of origin</a>
						</div>
						<div class="item-highlight">
							<div class="item-highlight__details">
								<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</span>
							</div>
							<div class="item-highlight__image">
							</div>
						</div>
					</div>
					<div class="item-info">
						<div class="item-info__name">
							<p>Author:<span>Shalvah</span></p>
						</div>
						<div class="item-info__date">
							<p>11/06/2016</p>
						</div>
					</div>
				</div>
				<div class="links-row__item">
					<div class="item-source">
						<p><span>{{ teamName }}</span><i class="fa fa-caret-right" aria-hidden="true"></i><span>General</span></p>
					</div>
					<div class="item-details">
						<div class="item-title">
							<div class="item-highlight__attached" >
								<span>Lindaikeji.com</span>
							</div>
							<a href={{ $links }}>Shalvah has no state of origin</a>
						</div>
						<div class="item-highlight">
							<div class="item-highlight__details">
								<span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore dolore magna aliqua.</span>
							</div>
							<div class="item-highlight__image">
							</div>
						</div>
					</div>
					<div class="item-info">
						<div class="item-info__name">
							<p>Author:<span>Shalvah</span></p>
						</div>
						<div class="item-info__date">
							<p>11/06/2016</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	</div>
</body>
	
</html>