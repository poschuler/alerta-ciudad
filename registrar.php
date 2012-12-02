<?php

  $x = "";
  
  if(isset($_POST['btnSubmit']))
  {
  $pass = md5($_POST['txtPassword']);
			require("conexion.php");
			
			$query = mysql_query("SELECT username,password FROM user WHERE username = '{$_POST['txtDNI']}' LIMIT 1");
			$info = mysql_fetch_assoc($query);
			
			if (!$info)
			{			
			
				$result = mysql_query("insert into user (username,password,surname,firstname,name) values 
				('{$_POST['txtDNI']}','".md5($_POST['txtPassword'])."','{$_POST['txtNombre']}','{$_POST['txtApePaterno']}',
				'{$_POST['txtAperMaterno']}')");
						
				if ($result)
				{
					$x =  "Usuario registrado Satisfactoriamente";
				}
				else
				{
					$x =  "Error al registrar Usuario";
				}
			}
			else
		    {
				$x =  "Ya existe el Usuario";
			}
  }
?>

<!DOCTYPE html>

<html>
<head>
    	<title>Alerta Ciudad</title>
	

	<link rel="stylesheet" type="text/css" href="css/site.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" /> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.js"></script> 
	<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>	
	
	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" src="scripts/jquery.validate.min.js"></script>
	<script type="text/javascript" src="scripts/jquery.maxlength-min.js"></script>

	<script>
		  $(document).ready(function(){
		  
		  $("#txtDNI").keydown(function(event) {
		  
		  if ($("#txtDNI").val().length <= 8)
		  {
		  	// Allow: backspace, delete, tab, escape, and enter
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else {
				// Ensure that it is a number and stop the keypress
				if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					event.preventDefault(); 
				}   
			}
		}
		else
		{		
		
			if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else
			{
			event.preventDefault(); 
			}
		}
		});
		
		$("#txtPassword").keydown(function(event) {
		  
		  if ($("#txtPassword").val().length <= 20)
		  {
		  	
		   }
			else
		   {		
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else
			{
			event.preventDefault(); 
			}
		   }
			});
			
			$("#txtNombre").keydown(function(event) {
		  
		  if ($("#txtNombre").val().length <= 100)
		  {
		  	
		   }
			else
		   {		
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else
			{
			event.preventDefault(); 
			}
		   }
			});
			
			$("#txtApePaterno").keydown(function(event) {
		  
		  if ($("#txtApePaterno").val().length <= 100)
		  {
		  	
		   }
			else
		   {		
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else
			{
			event.preventDefault(); 
			}
		   }
			});
			
			$("#txtAperMaterno").keydown(function(event) {
		  
		  if ($("#txtAperMaterno").val().length <= 100)
		  {
		  	
		   }
			else
		   {		
				if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
				 // Allow: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				 // Allow: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					 // let it happen, don't do anything
					 return;
			}
			else
			{
			event.preventDefault(); 
			}
		   }
			});
			  
		  		  
		  
			$("#frmRegistrarUsuario").validate();
		  });
		  
		  
		  
	</script>
	
	<style type="text/css">
		* { font-family: Verdana; font-size: 96%; }
		label { width: 10em; float: left; }
		label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
		p { clear: both; }
		.submit { margin-left: 12em; }
		em { font-weight: bold; padding-right: 1em; vertical-align: top; }
	</style>
	
	
  

</head>
<body> 



<div data-role="page" data-theme="b" id="page1" style="background: url('http://m.opentable.com/content/images/springboard-bg-sm.png') repeat">
	<div data-role="header" data-theme="b">
		<h1>Alerta Ciudad</h1>
		<a href="index.php" data-role="button" data-icon="back" data-inline="true" data-theme="b">Volver</a>
	</div><!-- /header -->

	<div data-role="content">	
				
				<form id="frmRegistrarUsuario" data-ajax="false" method="post">
					<label for="txtDNI">DNI:</label>
							<input  value="" type="number" name="txtDNI" id="txtDNI" placeholder="Numero DNI" class="required number" minlength="8"/>							
							</br>
					<label for="txtPassword">Contrase&ntilde;a :</label>
							<input type="password" name="txtPassword" id="txtPassword" value="" placeholder="Password" class="required" minlength="6"/>
							</br>
					<label for="txtNombre">Nombre:</label>
							<input type="text" name="txtNombre" id="txtNombre" value="" placeholder="Nombre" class="required" />
							</br>
					<label for="txtApePaterno">Apellido Paterno:</label>
							<input type="text" name="txtApePaterno" id="txtApePaterno" value="" placeholder="Apellido Paterno" class="required"/>
							</br>
				   <label for="txtApeMaterno">Apellido Materno:</label>
							<input type="text" name="txtAperMaterno" id="txtAperMaterno" value="" placeholder="Apellido Materno" class="required"/>
							</br>
				  
					<fieldset>
							 <div ><button type="submit" name="btnSubmit" data-theme="b" data-mini="true">Registrar</button></div>
					</fieldset>
					
				</form>
				
				<div align="center" style="margin-top: 1%; width: 100%">
					<label name="lblMensaje" style="text-align:center; color: red; "><?php echo(($x!="") ? $x : ""); ?></label>
				</div>

	</div><!-- /content -->

	<div data-role="footer" data-theme="b" data-position="fixed">
		<h4>YS</h4>
	</div><!-- /footer -->
</div>
</div><!-- /page -->

</body>
</html>