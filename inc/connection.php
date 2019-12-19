<?php


try{
//Create empty object of the PDO class
//Use PDO driver to connect SQLite to PHP 
$db = new PDO("sqlite:".__DIR__."/database.db");
//Define error mode level
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//Store exceptions in $e
}catch (Exception $e){
    //Display exception 
    echo $e->getMessage();
    exit;
}

?> 