<?php
	require("conexion.php");
	require("validar_sesion.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta "charset=utf-8" />
<title>Alerta Ciudad</title>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
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
<script>

var ajax_call = function() {
  $("#results").load("cargar_alertas_authority.php");
};

var interval = 1000 * 3; // where X is your every X minutes

setInterval(ajax_call, interval);


function success(position) {
  var s = $('#status');
  
  if (s.attr("class") == 'success') {
    // not sure why we're hitting this twice in FF, I think it's to do with a cached result coming back    
    return;
  }
  
  s.innerHTML = "Encontrado!";
  s.attr("class","success");
  
	<?php if(!isset($_GET['latitude'])): ?>
		window.location.href="index_authority.php?latitude="+position.coords.latitude+"&longitude="+position.coords.longitude;
    <?php endif; ?>
	
	<?php if(!isset($_GET['type'])): ?>
	var latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	<?php else: ?>
	var latlng = new google.maps.LatLng(<?php echo $_GET['latitude']; ?>,<?php echo $_GET['longitude']; ?>);
	<?php endif; ?>
	
	var myOptions = {
		zoom: 16,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	var map = new google.maps.Map(document.getElementById("mapa"), myOptions);
	
	var image = 'icons/me.png';
	var t_title = "Tu estas aqui! (al menos en un radio de "+position.coords.accuracy+" metros)";
	<?php if(!isset($_GET['type'])): ?>
	latlng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	<?php else: ?>
	latlng = new google.maps.LatLng(<?php echo $_GET['latitude']; ?>,<?php echo $_GET['longitude']; ?>);
	image = 'icons/t_<?php echo $_GET['type']; ?>.png';
	t_title = 'Incident';
	<?php endif; ?>
	var marker = new google.maps.Marker({
		position: latlng, 
		map: map,
		icon:image,
		title: t_title
	});
	<?php
	
		if(isset($_GET['latitude'])):
		$query = mysql_query("SELECT *,3956 * 2 * ASIN(SQRT( POWER(SIN((".$_GET['latitude']." - dest.latitude) * pi()/180 / 2),2) + COS(".$_GET['latitude']." * pi()/180 ) * COS(dest.latitude *  pi()/180) * POWER(SIN((".$_GET['longitude']."-dest.longitude) *  pi()/180 / 2), 2) )) as distance FROM authority dest having distance < 2 ORDER BY distance");
		$i = 0;
		while($data = mysql_fetch_assoc($query)):
		$i++;
	?>
	image = 'icons/<?php echo $data['authority_type_id'];?>.png';
	latlng = new google.maps.LatLng(<?php echo $data['latitude']; ?>,<?php echo $data['longitude']; ?>);
	var marker<?php echo $i; ?> = new google.maps.Marker({
		position: latlng, 
		map: map, 
		title:"<?php echo $data['name']; ?> <?php echo $data['phone']; ?>",
		icon:image
	});
	
	var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
		content: "<blockquote class='example-obtuse'><p><?php echo $data['name']; ?> <?php echo $data['phone']; ?></p></blockquote>"
	});
	
	google.maps.event.addListener(marker<?php echo $i; ?>, "click", function() {
		infowindow<?php echo $i; ?>.open(map, marker<?php echo $i; ?>);
	});
	
	<?php
		endwhile;
		endif;
		
		if(isset($_GET['type'])):
		$query = mysql_query("SELECT *,3956 * 2 * ASIN(SQRT( POWER(SIN((".$_GET['latitude']." - dest.latitude) * pi()/180 / 2),2) + COS(".$_GET['latitude']." * pi()/180 ) * COS(dest.latitude *  pi()/180) * POWER(SIN((".$_GET['longitude']."-dest.longitude) *  pi()/180 / 2), 2) )) as distance FROM alert dest JOIN alert_type at ON dest.alert_type_id = at.id having distance < 2 ORDER BY distance");
		
		while($data = mysql_fetch_assoc($query)):
		$i++;
	?>
	image = 'icons/t_<?php echo $_GET['type'];?>.png';
	latlng = new google.maps.LatLng(<?php echo $data['latitude']; ?>,<?php echo $data['longitude']; ?>);
	var marker<?php echo $i; ?> = new google.maps.Marker({
		position: latlng, 
		map: map, 
		title:"<?php echo $data['description']; ?>",
		icon:image
	});
	
	var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
		content: "<?php echo $data['description']; ?>"
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
  var s = document.querySelector('#status');
  s.innerHTML = typeof msg == 'string' ? msg : "Falló";
  s.className = 'fail';
  
  // console.log(arguments);
}

if (navigator.geolocation) {
  
  navigator.geolocation.getCurrentPosition(success, error);

} else {
  error('not supported');
}
</script>
<style type="text/css">
    html, body {width: 100%; height: 100%; margin:0;}
    #mapa{width:100%; height:100%;}
	
	.item{
		border: 1px solid #E8E8E8;
	}
	
	.results{
		width:100%;
	}
	
	.results .item{
		width:100%;
		padding:10px;
	}
	
	.results:hover{
		background-color:#f5f5f5;
	}
	
	.nolink{
		color:#645f5f;
		font-weight:bold;
		text-decoration:none !important;
		padding-top:10px;
	}
	
	
</style>
<div style="width:300px;height:100%;background-color:white;z-index:2;position:fixed;right:0;">
<div style="float:left;">
<a href="index_authority.php" class="nolink">
<?php
	echo $_SESSION['uname'];
?>
</a>
</div>
<div style="float:right;margin-right:5px;">

<a href="salir.php"><img src="images/exit.png" onmouseover="this.src='images/exit_light.png';" onmouseout="this.src='images/exit.png';" height="40" width="40"/></a>
</div>
<div style="clear:both;"></div>

<div class="results" id="results">
<?php 
	$query = mysql_query("SELECT *,a.latitude,a.longitude FROM alert a JOIN authority at ON a.authority_id = at.id JOIN user u ON a.user_id = u.id WHERE a.authority_id = '{$_SESSION['uid']}' ORDER BY alert_date DESC LIMIT 10");
	// echo "SELECT * FROM alert a JOIN authority at ON a.authority_id = at.id JOIN user u ON a.user_id = u.id WHERE a.authority_id = '{$_SESSION['uid']}' ORDER BY alert_date DESC LIMIT 10";
	// die();
	while($data = mysql_fetch_assoc($query)):
	echo "<div class=\"item\"><img src=\"icons/t_{$data['alert_type_id']}.png\"> <a class=\"nolink\" href=\"index_authority.php?type={$data['alert_type_id']}&latitude={$data['latitude']}&longitude={$data['longitude']}\">{$data['surname']} {$data['firstname']},{$data['name']}</a></div>";
	endwhile;

?>
</div>
</div>
</head>
<body>
	<div id="mapa"></div>
</body>
</html>
