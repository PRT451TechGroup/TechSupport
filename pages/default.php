<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="author" content="" />
	
	<?= Document::css_root('jquery/jquery.mobile-1.4.5') ?>
	<?= Document::js_root('jquery/jquery-1.11.2.min') ?>
	<?= Document::js_root('jquery/jquery.mobile-1.4.5.min') ?>
	<?= Document::js('Server') ?>
</head>
<body>
	<div data-role="page" id="ddddd">
		<div data-role="header">
	<h1>Sign In</h1>
</div>
<div data-role="content">
	<form id="frmLogin">
		<label for="txtUsername">Username</label>
		<input type="text" name="txtUsername" id="txtUsername" />
		<label for="txtPassword">Password</label>
		<input type="password" name="txtPassword" id="txtPassword" />
		<input type="submit" data-icon="action" value="Login" />
		<a href="#pgRegister" id="btnRegister" class="ui-btn ui-corner-all ui-btn-icon-left ui-icon-user" data-transition="slide">Register</a>
	</form>
	
</div>
	</div>
</body>
</html>
