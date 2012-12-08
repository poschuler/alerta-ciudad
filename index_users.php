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

<!DOCTYPE html>
<html>
<head>
<meta "charset=utf-8" />
<title>Alerta Ciudad</title>
<link href='http://fonts.googleapis.com/css?family=Anaheim' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<style type="text/css">
.example-obtuse {
	position:relative;
	padding:15px 30px;
	margin:0;
	color:#000;
	background:#f3961c; /* default background for browsers without gradient support */
	/* css3 */
    background:-webkit-gradient(linear, 0 0, 0 100%, from(#f9d835), to(#f3961c));
	background:-moz-linear-gradient(#f9d835, #f3961c);
	background:-o-linear-gradient(#f9d835, #f3961c);
	background:linear-gradient(#f9d835, #f3961c);
	/* Using longhand to avoid inconsistencies between Safari 4 and Chrome 4 */
	-webkit-border-top-left-radius:25px 50px;
	-webkit-border-top-right-radius:25px 50px;
	-webkit-border-bottom-right-radius:25px 50px;
	-webkit-border-bottom-left-radius:25px 50px;
	-moz-border-radius:25px / 50px;
	border-radius:25px / 50px;
}
</style>
<?php 
if(isset($_GET['your'])):
  mysql_query("UPDATE user SET latitude='{$_GET['latitude']}',longitude='{$_GET['longitude']}' WHERE id='{$_SESSION['uid']}'");
endif;
?>
<script>
function success(position) {
  var s = $('#status');
  
  if (s.attr("class") == 'success') {
    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
    return;
  }
  
  s.innerHTML = "Encontrado!";
  s.attr("class","success");
  
	<?php if(!isset($_GET['latitude'])): ?>
		window.location.href="index_users.php?latitude="+position.coords.latitude+"&your=true&longitude="+position.coords.longitude;
    <?php endif; ?>
	var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	var myOptions = {
		zoom: 16,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById("mapa"), myOptions);
	
	var image = 'icons/me.png';
	var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	var marker = new google.maps.Marker({
		position: latlng, 
		map: map,
		icon:image,
		title:"Tu estas aqui! (al menos en un radio de "+position.coords.accuracy+" metros)"
	});
	<?php
		if(isset($_GET['latitude'])):
    $espacio = "";
		$query = mysql_query("SELECT * FROM user where id <> 1 and id <> '{$_SESSION['uid']}' and latitude <> '{$espacio}' and longitude <> '{$espacio}' order by 1;");
		$i = 0;
		while($data = mysql_fetch_assoc($query)):
		$i++;
	?>
	image = 'icons/male-2.png';
	latlng = new google.maps.LatLng(<?php echo $data['latitude']; ?>,<?php echo $data['longitude']; ?>);
	var marker<?php echo $i; ?> = new google.maps.Marker({
		position: latlng, 
		map: map, 
		title:"<?php echo $data['surname']." ".$data['firstname']; ?> <?php echo $data['username']; ?>",
		icon:image
	});
	
	var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
		content: "<blockquote class='example-obtuse'><p><?php echo $data['surname']." ".$data['firstname'];  ?> <?php echo $data['username']; ?></p></blockquote>"
	});
	
	google.maps.event.addListener(marker<?php echo $i; ?>, "click", function() {
		infowindow<?php echo $i; ?>.open(map, marker<?php echo $i; ?>);
	});
	<?php
		endwhile;
		endif;
	?>

	google.maps.event.addDomListener(window, 'resize', function() {
	var center = map.getCenter();
	google.maps.event.trigger(map, "resize");
	map.setCenter(center);
	});
}

function error(msg) {
  alert(msg);
}

if (navigator.geolocation) {
  
  navigator.geolocation.getCurrentPosition(success, error);

} else {
  error('not supported');
}

function alerta(tipo,latitud,longitud)
{
	$("#nocontent").load("registrar_alerta.php?tipo="+tipo+"&latitude="+latitud+"&longitude="+longitud);
	alert("Alerta Reportada con exito");
}

</script>
<style type="text/css">
    html, body {width: 100%; height: 100%; margin:0;}
    #mapa{width:100%; height:100%;}
	.nolink{ 
	height:100%;top:10px;position:relative;
	text-decoration:none;
	color:white;
	margin-left:10px;
	}
</style>
<?php
	if(!isset($_GET['latitude'])):
		$_GET['latitude'] = "";
		$_GET['longitude'] = "";
		
	endif;
?>
<div style="display:none;" id="nocontent"></div>
<div style="width:100%;height:40px;background-color:gray;z-index:2;position:fixed;bottom:0;padding-left:20px;">
<div style="float:left; font-family:Anaheim; color:white;" >
<a href="#" class="nolink" onclick="alerta(2,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" >Policia</a><a href="#" title="Reportar Incidente a Policia" alt="Reportar Incidente a Policia"><img src="icons/policia2.png"  onclick="alerta(2,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" onmouseover="this.src='icons/policia3.png';" onmouseout="this.src='icons/policia2.png';" height="38px" width="38px" style="vertical-align: top;"/></a>
<a href="#" class="nolink" onclick="alerta(1,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" >Ambulancia</a><a href="#" title="Reportar Incidente a Hospital" alt="Reportar Incidente a Hospital"><img src="icons/hospital2.png"  onclick="alerta(1,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" onmouseover="this.src='icons/hospital.png';" onmouseout="this.src='icons/hospital2.png';" height="38px" width="38px" style="vertical-align: top;"/></a>
<a href="#" class="nolink" onclick="alerta(3,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" >Bomberos</a><a href="#" title="Reportar Incidente a Bomberos" alt="Reportar Incidente a Bomberos"><img src="icons/bombero2.png"  onclick="alerta(3,<?php echo $_GET['latitude'];?>,<?php echo $_GET['longitude']; ?>)" onmouseover="this.src='icons/bombero1.png';" onmouseout="this.src='icons/bombero2.png';" height="38px" width="38px" style="vertical-align: top;"/></a>
<a href="index_other.php" class="nolink">Alerta Ciudad</a><a href="index_other.php" title="Alerta Ciudad" alt="Alerta Ciudad"><img src="icons/imageAW.png"  onmouseover="this.src='icons/imageAB.png';" onmouseout="this.src='icons/imageAW.png';" height="38px" width="38px" style="vertical-align: top;"/></a>
</div>
<div style="float:right;margin-right:30px;">
<a href="salir.php"><img src="images/exit.png" onmouseover="this.src='images/exit_light.png';" onmouseout="this.src='images/exit.png';" height="40" width="40"/></a>
</div>
<div style="clear:both;"></div>
</div>
</head>
<body>
	<div id="mapa"></div>
</body>
</html>
