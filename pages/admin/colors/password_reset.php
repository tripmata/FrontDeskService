<?php
$ret->Content =
"<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
		<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'>
		<meta name='viewport' content='width=device-width, initial-scale=1.0' />
		
		<title>".$subscriber->BusinessName." : . login</title>
		
		<link rel='stylesheet' type='text/css' href='".$host."cdn/css/semantic.min.css'/>
		<link rel='stylesheet' type='text/css' href='".$host."cdn/css/space_app.css'/>
		
		<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/lato/stylesheet.css'/>
		<link rel='stylesheet' type='text/css' href='".$host."cdn/fonts/quicksand/stylesheet.css'/>
	</head>
	<body style='background-image: url(".$host."cdn/images/back.png)'>
		<div class='l-width-3' style='margin: auto; margin-top: 150px;'>
			<div class='l-margin-t-9 l-pad-2'>
				<div class='l-width-8' style='margin: auto;'>
					<form action=''>
						<div class='align-c pad-2'>
							<img src='".$host."/cdn/images/unlock_pastel.png' style='max-width: 80px;'>
						</div>
						<div class='ui fluid input'>
							<input type='text' placeholder='email'/>
						</div>
						<h5 style='float: right; font-weight: normal; cursor: pointer;'>
						<a href='".$router->Page."/".Router::ResolvePath("", $path)."'>Login</a></h5>
						<button class='ui blue compact sleak button'  style='margin-top: 10px; font-family: quicksandregular;'>Reset Password</button>
					</form>
				</div>
			</div>
		</div>
		<h5 class='align-c' style='position: fixed; bottom: 5px; font-family: quicksandregular; width: 100%;'>Powered By <a href=''>Ononiru Hotels</a></h5>
	</body>
</html>";