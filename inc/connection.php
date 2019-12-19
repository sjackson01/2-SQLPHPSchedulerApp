<?php

//Create empty object of the PDO class
//Use PDO driver to connect SQLite to PHP 
$db = new PDO("sqlite:".__DIR__."/database.db");

var_dump($db);

?> 