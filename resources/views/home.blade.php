<!DOCTYPE html>
<html>
<head>
	<title>Linxer | </title>
	<link href="{{ env('APP_URL') }}/css/home.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<header>
			<div class="header__wrapper">
				<div class="logo">
					<h1 class="logo__text">Linxer</h1>
				</div>
				<div class="signin">
					<a href="https://slack.com/oauth/authorize?scope=identity.basic,identity.email,identity.team&client_id=104593454705.107498116711">
						<button class="signin-btn"><span>LOGIN</span></button>
					</a>
				</div>
			</div>
		</header>
		<section class="cta">
			<div style="width: 30%;">
				<div class="cta-caption">
					<h1>A tool that saves your team's important links so you don't lose them when you reach the free tier message limit.</h1>
				</div>
				<div class="cta-link">
					<a href="https://slack.com/oauth/authorize?scope=incoming-webhook,bot&client_id=104593454705.107498116711">
						<button class="cta-btn"><span>Add linxer to your slack</span></button>
					</a>
				</div>
			</div>
			<div class="cta-img">
				<p style="width: 350px; height: 350px; visibility: hidden;"></p>
			</div>
		</section>
		<section class="screenshot">
			<div class="screenshot-list">
				<div class="screenshot-list__item">
					<img src="" alt="">
				</div>
				<div class="screenshot-list__item">
					<img src="" alt="">
				</div>
				<div class="screenshot-list__item">
					<img src="" alt="">
				</div>
			</div>
		</section>
		<footer>
			<p>made with ❤️ by <a href="">hngX</a></p>
		</footer>
	</div>
	</body>
</html>