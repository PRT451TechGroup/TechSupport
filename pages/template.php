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
	<?= Document::js('Environment') ?>
	<?= Document::js('Server') ?>
	<?= Document::js('Application') ?>
</head>
<body>
	<?php
		Document::body();
	?>
</body>
</html>
