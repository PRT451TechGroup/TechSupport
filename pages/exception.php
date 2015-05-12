<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="author" content="" />

	<link rel="stylesheet" href="<?=APPDIR?>/jquery/jquery.mobile-1.4.5.css" />
	<script src="<?=APPDIR?>/jquery/jquery-1.11.2.min.js"></script>
	<script src="<?=APPDIR?>/jquery/jquery.mobile-1.4.5.min.js"></script>
	<script src="<?=APPDIR?>/js/Environment.js"></script>
	<script src="<?=APPDIR?>/js/Server.js"></script>
	<script src="<?=APPDIR?>/js/Application.js"></script>
</head>
<body>
<div data-role="page" data-back="<?=APPDIR?>/">
	<div data-role="header" data-position="fixed">
		<h1>Exception</h1>
		<a href="<?=APPDIR?>/" data-rel="back" class="ui-btn-left ui-btn ui-icon-back ui-btn-icon-notext ui-shadow ui-corner-all">Back</a>
	</div>
	<div data-role="content">
		<p><?=$GLOBALS["PrimaryException"]?></p>
	</div>
</body>
</html>
