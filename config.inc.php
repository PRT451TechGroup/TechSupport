<?php

define("DOCPATH", $_SERVER["DOCUMENT_ROOT"] . "/techsupport");
define("LIBDIR", DOCPATH . "/lib");
define("PAGEDIR", DOCPATH . "/pages");
define("APPDIR", "/techsupport");
$datasource = function()
{
	return new PDODataSource("mysql:host=localhost;dbname=prt451gr_db", "prt451gr_db", "change_password", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
};

?>
