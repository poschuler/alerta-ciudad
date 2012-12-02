<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$recurso = mysql_connect($host,$user,$pass);
mysql_select_db("sac");

if (!$recurso)
{
	exit;
}
?>