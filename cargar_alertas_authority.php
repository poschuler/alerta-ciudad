<?php
	require("conexion.php");
	require("validar_sesion.php");
	$query = mysql_query("SELECT *,a.latitude,a.longitude,a.id FROM alert a JOIN authority at ON a.authority_id = at.id JOIN user u ON a.user_id = u.id WHERE a.authority_id = '{$_SESSION['uid']}' ORDER BY alert_date DESC LIMIT 10");
	// echo "SELECT * FROM alert a JOIN authority at ON a.authority_id = at.id JOIN user u ON a.user_id = u.id WHERE a.authority_id = '{$_SESSION['uid']}' ORDER BY alert_date DESC LIMIT 10";
	// die();
	while($data = mysql_fetch_assoc($query)):
	$nombre = utf8_encode($data['firstname'].' '.$data['name'].', '.$data['surname']);
	echo "<div class=\"item\"><img src=\"icons/t_{$data['alert_type_id']}.png\"> <a class=\"nolink\" href=\"index_authority.php?type={$data['alert_type_id']}&latitude={$data['latitude']}&longitude={$data['longitude']}\">{$data['surname']} {$data['firstname']},{$data['name']}</a> <a href=\"index_authority.php?delete={$data['id']}\">Eliminar</a></div>";
	endwhile;

?>