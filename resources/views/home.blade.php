<!DOCTYPE html>
<html>
<head>
	<title>Linxer - Save the stuff that matters to you </title>
	<link href="{{ env('APP_URL') }}/css/home.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="container">
		<header>
			<div class="header__wrapper">
				<div class="logo">
					<h1 class="logo__text">L<span>i</span><span>n</span><span>x</span><span>e</span><span>r</span>
					</h1>
				</div>
				<div class="signin">
					<a href="https://slack.com/oauth/authorize?scope=identity.basic,identity.email,identity.team&client_id=104593454705.107498116711"><img alt="View your team's links" height="40" width="172" src="https://platform.slack-edge.com/img/sign_in_with_slack.png" srcset="https://platform.slack-edge.com/img/sign_in_with_slack.png 1x, https://platform.slack-edge.com/img/sign_in_with_slack@2x.png 2x" /></a>
				</div>
			</div>
		</header>
		<section class="cta">
			<div style="width: 40%;">
				<div class="cta-caption">
					<h1>"Your team has more than 10,000 messages in its archive, so although there are older messages than are shown below, you can't see them."</h1> <h2>Sad, right? That's why Linxer is here-so you can save the important stuff.</h2>
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
			</div>
		</section>
		<footer>
			<p>made with ❤️ by <a href="">hngX</a></p>
		</footer>
	</div>
	</body>
</html>
