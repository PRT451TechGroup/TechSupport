<?php

Configuration::datasource(new PDODataSource("mysql:host=localhost;dbname=prt451gr_db", "prt451gr_db", "change_password", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)));

?>
