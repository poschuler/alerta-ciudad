<?php

$host = 'localhost';
$user = 'pschuler_alerta';
$pass = 'prueba';
$recurso = mysql_connect($host,$user,$pass);
mysql_select_db("pschuler_alertaciudad");

if (!$recurso)
{
	exit;
}
?>