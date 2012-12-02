<?php
	require("conexion.php");
	require("validar_sesion.php");
	
	/**
 * Devuelve la diferencia entre 2 fechas según los parámetros ingresados
 * @author Gerber Pacheco
 * @param string $fecha_principal Fecha Principal o Mayor
 * @param string $fecha_secundaria Fecha Secundaria o Menor
 * @param string $obtener Tipo de resultado a obtener, puede ser SEGUNDOS, MINUTOS, HORAS, DIAS, SEMANAS
 * @param boolean $redondear TRUE retorna el valor entero, FALSE retorna con decimales
 * @return int Diferencia entre fechas
 */
function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'SEGUNDOS', $redondear = false){
   $f0 = strtotime($fecha_principal);
   $f1 = strtotime($fecha_secundaria);
   if ($f0 < $f1) { $tmp = $f1; $f1 = $f0; $f0 = $tmp; }
   $resultado = ($f0 - $f1);
   switch ($obtener) {
       default: break;
       case "MINUTOS"   :   $resultado = $resultado / 60;   break;
       case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
       case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
       case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
   }
   if($redondear) $resultado = round($resultado);
   return $resultado;
}
	
?>

<?php if(isset($_GET['latitude'])): ?>
<?php
$query1 = null;
if(isset($_GET['latitude'])):
	$query1 = mysql_query("SELECT *,3956 * 2 * ASIN(SQRT( POWER(SIN((".$_GET['latitude']." - dest.latitude) * pi()/180 / 2),2) + COS(".$_GET['latitude']." * pi()/180 ) * COS(dest.latitude *  pi()/180) * POWER(SIN((".$_GET['longitude']."-dest.longitude) *  pi()/180 / 2), 2) )) as distance FROM authority dest having distance < 2 and authority_type_id = {$_GET['tipo']} ORDER BY distance");
endif;

$i = 0;
while($data1 = mysql_fetch_assoc($query1)):
$i++;

	$result = mysql_query("select id,alert_date from alert where user_id = '".$_SESSION['uid'] ."' and authority_id = '".$data1["id"]."' order by 1 desc limit 1");
	$data = mysql_fetch_assoc($result);
	$query;
		
	if(diferenciaEntreFechas(date("Y-m-d H:i:s"), $data["alert_date"], 'HORAS', false) <= 3)
	{
	$query = mysql_query("update alert  set alert_date = '".date("Y-m-d H:i:s")."' where id = '".$data["id"]."'");   
	}
	else
	{
	
	$query = mysql_query("insert into alert (latitude,longitude,alert_date,intensity,status,user_id,alert_type_id,authority_id) values 
			('".$_GET['latitude']."','".$_GET['longitude']."','".date("Y-m-d H:i:s")."','"."1"."','"."1"."','".$_SESSION['uid']."'
			 ,'".$_GET['tipo']."','".$data1["id"]."')");
	}	

endwhile;

if (!$query)
{
?>

<?php
}
else
{
?>
<?php
}
?>
<?php endif; ?>