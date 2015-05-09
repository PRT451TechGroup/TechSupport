<?php
session_start();
?>
<!DOCTYPE html> 
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="author" content="" />
	
	<link rel="stylesheet" href="jquery/jquery.mobile-1.4.5.css" />
	<link rel="stylesheet" href="themes/jquery.mobile.icons.min.css" />
	<script src="jquery/jquery-1.11.2.min.js"></script>
	<script src="jquery/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<?php
		echo htmlspecialchars($_SERVER['REQUEST_URI']);
	?>
</body>
</html>
