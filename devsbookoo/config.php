<?php
session_start();
$base = 'http://localhost/modulo12DevsBookOO/devsbookoo';

$db_name = 'devsbooks';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$maxWidth = 800;
$maxHeight = 800;

$pdo = new PDO("mysql:dbname=".$db_name.";host=".$db_host, $db_user, $db_pass);